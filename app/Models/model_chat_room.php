<?php namespace App\Models;

use App\Events\PsychicCheckIsInReadingProgress;
use DB;
use DateTime;
use App\Models\User;
use App\Services\WhiteLabel;
use App\Services\ChatRoomUtils;

use App\Mail\ClientPleaseReview;
use App\Services\ApiUtils;
use App\Services\EmailUtils;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use spec\Prophecy\Argument\Token\StringContainsTokenSpec;

class model_chat_room extends Model {
	
	use SoftDeletes;

	protected $casts = [
        'credits_per_minute' => 'decimal:2',
        'credits_deducted' => 'decimal:2',
        'credits_total' => 'decimal:2',
        'minutes_total' => 'decimal:2',
	];
	
	protected $dates = ['deleted_at'];

    protected $table = 'model_chat_room';
    protected $fillable = ['model_id', 'user_id'
                           , 'state'
                           , 'credits_per_minute'
                           , 'credits_deducted'
                           , 'credits_total'
                           , 'tokbox_model_token'
                           , 'tokbox_session_id'
                           , 'minutes_minimum'
                           , 'minutes_max'
                           , 'minutes_paid'
                           , 'minutes_total'
                           , 'started_at'
                           , 'low_credits_warning_at'
                           , 'ended_at'
                           , 'notify_email_at'
                           , 'notify_sms_at'
                           , 'notify_sns_at'];
    const TIME_TIL_ABORT = 300; //5min
    const CACHE_MIN = 60;
	//

 	public static function create_model_chat_room($in=[]){
 		
	    if (!isset($in['model_id'])){
		    return [false,"No ".WhiteLabel::config('star')->alias." specified."];
	    }
	    if (!isset($in['user'])){
		    return [false,"No user specified."];
	    }
        $max_minutes = $in['minutes_max'];
	    $model_id = $in['model_id'];
	    $user = $in['user'];
	    
	    $existing_rooms = model_chat_room::where('model_id',$model_id)
	                                   ->whereIn('state',[
	                                   	'LIVE'
	                                   ])->first();
	    
    	if($existing_rooms) {
    		return [false,WhiteLabel::config('star')->alias." is currently chatting."];
		}
		
		$waiting_rooms = model_chat_room::where('model_id',$model_id)
		->whereIn('state',[
		'WAITING'
		])->get();

		if($waiting_rooms) {
    		foreach ($waiting_rooms as $chat_room)
					{
						$chat_room->terminate();
					}
		}
	   
	    $session = ChatRoomUtils::get_room_id();
	    if (!$session[0]){
		    return $session;
	    }
	    $session_id = $session[1];
	    
	    $name = $user->userProfile()->first()->display_name;
	    
	    $token_res = ChatRoomUtils::get_token($session_id,[
	    	'model_id'=>$model_id
		    ,'user_name'=>$name
		    ,'minutes_max'=>$max_minutes
	    ]);


	    if (!$token_res[0]){
	    	return $token_res;
	    }
	    
	    $token = $token_res[1];

	    //$star_rate = star_rate::get_current_rate($model_id);

	    $minutes_minimum = $in['minimum_minutes'];
        $minutes_max = $in['minutes_max'];
	    $credits_per_minute = $in['rate'];
	    
	    $chat_room = model_chat_room::create([
	    	"user_id" => $user->id,
		    "model_id"=>  $model_id,
		    "state"=>  'WAITING' ,
		    "tokbox_model_token"=> $token  ,
		    "tokbox_session_id"=>  $session_id ,
		    "minutes_minimum"=>   $minutes_minimum,
            "minutes_max"=>   $minutes_max,
		    "minutes_total"=>   0,
		    "minutes_paid"=>   0,
		    "credits_per_minute"=>   $credits_per_minute,
		    "credits_deducted"=>   0,
		    "credits_total"=>   0,
	    ]);
	    
	    $chat_room->save();
	    
	    $out['model_chat_room']=$chat_room;
	    
	    return [true,$out];
		
	}
	
	public static function end_chat($id,$model=false){
		$room = model_chat_room::find($id);
		if (!$room){
			return [false,"Invalid chat room id"];
		}
		
		if ($model){
			if ($room->model_id != $model->id){
				return[false,"Chat not with star"];
			}
		}
		
		
		$chat_done = ChatRoomUtils::is_room_empty($room->tokbox_session_id);
		
		if (!$chat_done){
			ChatRoomUtils::clear_room($room->tokbox_session_id);
		}
		
		return $room->process_end_chat();
		
	}
	
	public static function extend_chat($id,$model=false){
		$room = model_chat_room::find($id);
		if (!$room){
			return [false,"Invalid chat room id"];
		}
		
		if ($model){
			if ($room->model_id != $model->id){
				return[false,"Chat not with star"];
			}
		}
		
		
		$chat_done = ChatRoomUtils::is_room_empty($room->tokbox_session_id);
		
		if (!$chat_done){
			ChatRoomUtils::clear_room($room->tokbox_session_id);
		}
		
		return $room->process_end_chat();
		
	}
	
	public function live_session_update($ending = false){
		//Log::debug("\n\nlive_session_update for ".$this->id." ... ");
		$user_chat_room = $this->fan_chat_room()->first();
		$request = $this->user_1_1_chat_request;
		
		if(!$user_chat_room){
			return [false,'No user in chat room'];
		} else {
			$user = $user_chat_room->user;
		}
		
		// Bill for the difference between new total and billed amount
		
		$seconds_started = strtotime($this->started_at);

		$terminate = false;
		
		if ($seconds_started > 0)
		{
			$seconds_so_far = time() - $seconds_started;
			
			$minutes_so_far = floor($seconds_so_far / 60);
			
			$minutes_due    = $minutes_so_far - $this->minutes_paid;
			
			$credits_due    = $minutes_due  * $this->credits_per_minute;



         	$credits_left   = $user->credits - $credits_due;
			
			if ( !$user->check_credits($credits_due,true))
			{
				$terminate = true;
				$credits_due = $user->credits;

			}

			if ($credits_due > 0)
			{
				
				$action = $this->user_1_1_chat_request->service->name;

				if(!$ending){
					if ( !$user->deduct_credits(
						$credits_due,
						$action, 
						$this->model_id, 
						null, 
						false, 
						$this->user_1_1_chat_request->service_id, 
						$this->user_1_1_chat_request->id
						) 
					) {
	
						return [false ,'Not enough credits'];
					}
			
			
				$this->minutes_paid += $minutes_due;
				$this->credits_deducted += $credits_due;
				$this->save();
				}	


				if ($terminate){
					return [false,'Not enough credits'];
				}

				
				$min_credits = 2 * $this->credits_per_minute;

				
				if (!$user->check_credits($min_credits,true))
				{
					$data = [
						'action'   => 'WARNING'
						,'message' => 'LOW CREDITS'
	
					];
					ChatRoomUtils::send_signal($this->tokbox_session_id ,$data);
					$this->low_credits_warning_at = date('Y:m:d H:i:s');
					$this->save();
				}
			
			}

			
			
			
			// Bail if out of time
			
			/*if (( $request->minutes_requested - $minutes_so_far) <= 0){
				return [false,"Time expired"];
			}*/
			
			
			// Give 2 minute warning if needed
			
			
			/*if ( $this->two_minute_warning_at == '0000-00-00 00:00:00' )
			{
				
				if (($request->minutes_requested - $minutes_so_far) <= 2.0)
				{
					
					
					$data = [
						'action'   => 'WARNING'
						,'message' => 'TWO MINUTES'
					
					];
					ChatRoomUtils::send_signal($this->tokbox_session_id ,$data);
					$this->two_minute_warning_at = date('Y:m:d H:i:s');
					$this->save();
				}
			}*/
			
			
		}
		

		return [true];
		
 
	}
	
	public function start_session(){
		
 //		Log::debug("start_session ... ");
 		
 		$user_chat_rooms = $this->fan_chat_room();
 		
 		$user_polled = date('Y:m:d H:i:s');
 		
 		$user_chat_room = $user_chat_rooms->first();

		
		$user_polled = min($user_polled, $user_chat_room->created_at);

        $user = $user_chat_room->user()->first();
		
		$this->started_at =  $user_polled;
		
		$star = $this->star;
		
		// Bill the minimum
		$minimum_credits = $this->minutes_minimum * $this->credits_per_minute;
		
//		Log::debug("minimum credits needed $minimum_credits ...");
		
		if (!$user->check_credits($minimum_credits)) {
			return [false, ['message'=> 'Not enough credits']];
		}
		
		if ($minimum_credits) {
			
			$action = $this->user_1_1_chat_request->service->name;

			if (! $user->deduct_credits(
				$minimum_credits, 
				$action, 
				$this->model_id,
				null, 
				false, 
				$this->user_1_1_chat_request->service_id,
				$this->user_1_1_chat_request->id
			)) {
				return [false, ['message'=> 'Not enough credits']];
			}
			
			$this->credits_deducted = $minimum_credits;
			$this->minutes_paid = $this->minutes_minimum;
		}
		
		
		$this->save();
		
		$data = [
			'action'=>'INFO'
			,'message'=>'Billing started at '.$user_polled
			
		];
		broadcast(new PsychicCheckIsInReadingProgress($this->model)); 
		ChatRoomUtils::send_signal($this->tokbox_session_id,$data);
		
		return [true];
	}
	
	public function process_end_chat(){
 		// Called when TokBox session is alerady dead.
		
		$user_chat_room = $this->fan_chat_room()->first();
		
		if(!$user_chat_room){
			return [false,'No user in chat room'];
		} else {
			$this->live_session_update(true);
			$user = $user_chat_room->user;
		}
	
		
		
		$this->ended_at = date('Y:m:d H:i:s');
		
		$seconds_ended_at = strtotime($this->ended_at);
		$seconds_started_at = strtotime($this->started_at);
		
		$duration = ($seconds_started_at>0) ? $seconds_ended_at - $seconds_started_at : 0 ;
		
		$this->minutes_total = ($duration==0) ? 0 : max(($duration/60),$this->minutes_minimum);

		$real_duration = ($duration==0) ? 0 : $duration/60;
		
		$this->credits_total = $this->credits_per_minute * $this->minutes_total;

		$credits_due = $this->credits_total - $this->credits_deducted;

		if (!$user->check_credits($credits_due,true))
		{
			$credits_due = $user->credits;
		}

		if ($credits_due > 0)
		{

		$action = $this->user_1_1_chat_request->service->name;

		if (!$user->deduct_credits(
					$credits_due,
					$action, 
					$this->model_id, 
					null, 
					false, 
					$this->user_1_1_chat_request->service_id, 
					$this->user_1_1_chat_request->id
					) 
				) {

					return [false ,'Not enough credits'];
				}

				$this->credits_deducted += $credits_due;
				
		}
		
		switch ($this->state){
			case 'LIVE':
			case 'COMPLETE':
				$this->state = 'COMPLETE';
				break;
			default:
				$this->state = 'INCOMPLETE';
				break;
		}
		
		$user_chat_rooms = $this->fan_chat_room;
		
		foreach ($user_chat_rooms as $user_chat_room)
		{
			if (!$user_chat_room->end())
			{
				return [false,"Error terminating 1-1 video chat"];
			}
		}
		
		$user_1_1_chat_request = $this->user_1_1_chat_request;
		if ($user_1_1_chat_request){
			if (!$user_1_1_chat_request->end()){
				return [false,"Error ending 1-1 video chat"];
			}
		}
		
		$this->save();

		if ($user_1_1_chat_request->appointment_id) {

			$appointment=$this->user_1_1_chat_request->appointment;
			
			$appointment->status="Completed";
			//$appointment->duration=$real_duration;	
			
				if(!$appointment->token_review){
					$token = ApiUtils::generate_token(40); 
					$appointment->token_review = $token;  
				}
			    $appointment->save();			
		
				
		 
		EmailUtils::send_to_client_when_request_review($appointment);
		//Mail::to($user->email, $user->name)->send(new ClientPleaseReview($user, $psychic));

		}
        broadcast(new PsychicCheckIsInReadingProgress($this->model)); 
		// Updating Credit Log

		$mightFindLog=UserCreditLog::where('user_1_1_chat_request_id', '=', $this->user_1_1_chat_request->id)->first();

		if ($mightFindLog) {

        	$mightFindLog->duration= $real_duration;
			if($this->credits_deducted > $mightFindLog->credits){
				$mightFindLog->credits = $this->credits_deducted;
			}
			
            $mightFindLog->save();
		}

		
		
		$out = [
			'star_chat_room_id'=>$this->id
			,'minutes_total'=>$real_duration
			,'ended_at'=>$this->ended_at
		];	
		

		return [true, $out];
			
	}
	
	public function live() {
		switch ($this->state){
			case 'LIVE':
			case 'WAITING':
				$this->state = 'LIVE';
				$this->save();
				break;
			default:
				return false;
		}
		
		return true;
		
	}
	
	public function go_live(){
//		Log::debug("Go live ...");
		
		$this->live();
		$this->user_1_1_chat_request->live();
		$user_connections = $this->fan_chat_room();
		foreach ($user_connections as $user_connection)
		{
			$user_connection->live();
 		}
	}

	public function terminate(){
	
			$this->state = 'INCOMPLETE';
			$this->save();
	}
	
	public static function calls_star_interval($star,$interval){
		return self::selectRaw('count(*) as calls')
			->where('model_id',$star->id)
			->whereBetween('created_at',[$interval[0]." 00:00:00",$interval[1]." 00:00:00"])
			->where('state','COMPLETE')
			->first()->calls;
	}

    public static function find_by_timestamp($model_id, $created_at)
    {
        $dt = new DateTime($created_at);
        $period['end_date'] = $dt->format("Y-m-d H:i:s");
        $dt->modify("-290 seconds"); // 4 mins, 50 seconds -- (must be less than 5 mins)
        $period['start_date'] = $dt->format("Y-m-d H:i:s");
        return self::where('model_id', $model_id)
            ->whereBetween('started_at', [$period['start_date'], $period['end_date']])
            ->first();
    }

	public function model(){
        return $this->belongsTo('App\Models\User', 'model_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
	
	public function fan_chat_room(){
 		return $this->hasMany('App\Models\fan_chat_room');
	}
	
	public function user_1_1_chat_request(){
 		return $this->hasOne('App\Models\user_1_1_chat_request');
	}

    public static function star_minutes_total_by_period($model_id, $start_date, $end_date) {
        return array_sum(model_chat_room::where('model_id', $model_id)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get()
            ->pluck('minutes_total')
            ->toArray());
    }
}

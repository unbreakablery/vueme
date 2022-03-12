<?php namespace App\Models;


use DB;
use Log;
use App\Models\User;
use App\Services\WhiteLabel;
use App\Services\TwilioUtils;

//use App\admin_log;
use App\Models\model_chat_room;
use App\Services\NotificationUtils;
use Illuminate\Database\Eloquent\Model;
use App\Services\NotificationsInAppUtils;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\v1\UserChatRequestResource;

class user_1_1_chat_request extends Model {
	
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $table = 'user_1_1_chat_request';
    protected $fillable = ['user_id', 'model_id','service_id','state','minimum_minutes', 'max_minutes',
	    'model_chat_room_id', 'appointment_id', 'rate'];
		
	public function user(){
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}
	
	public function model(){
		return $this->belongsTo(\App\Models\User::class, 'model_id');
	}

	public function service(){
		return $this->belongsTo(\App\Models\Services::class, 'service_id');
	}

	public function appointment(){
		return $this->belongsTo(\App\Models\Appointment::class, 'appointment_id');
	}
	
	public function getModelAttribute(){
		return User::find($this->model_id);
	}
	
	public function getModelChatRoomAttribute(){
		return model_chat_room::find($this->model_chat_room_id);
	}
	
	public function model_chat_room(){
		return $this->belongsTo(\App\Models\model_chat_room::class );
	}
	public function user_credit_log(){
		return $this->hasOne(\App\Models\UserCreditLog::class ,'user_1_1_chat_request_id');
	}
	
	public static function vchat_request($input) {
		if (empty($input['user']) || empty($input['model']) || empty($input['duration'])) {
			return [false, 'Missing model, user or duration.'];
		}
		/*if ($input['user']->model_id) {
			return [false, 'Sorry, your account type cannot request video chats'];
		}*/
		/*if (admin_log::is_chat_banned($input['user']->id)
		    || star_block::is_chat_blocked($input['star']->id, $input['user']->id)) {
			return [false, 'Sorry, this action is unavailable'];
		}*/
		
		
		$user_1_1_chat_requests = user_1_1_chat_request::where([
			'model_id'=> $input['model']->id
			,'user_id'=> $input['user']->id
		])->get();


		foreach ($user_1_1_chat_requests as $user_1_1_chat_request)
		{
			switch ($user_1_1_chat_request->state) {
				case 'COMPLETE':
				case 'INCOMPLETE':
					continue 2;
				case 'ENQUEUED':
				case 'WAITING':
					return [true,['message'=>"Pending request",'request'=>
                        new UserChatRequestResource($user_1_1_chat_request)
					]];
				case 'LIVE':
					return [true,['message'=>"Video chat in progress with creator",'request'=>
                        new UserChatRequestResource($user_1_1_chat_request)
					]];
				default:
					return [false,['message'=> 'Video chat in progress']];
			}
		}
		
		/*$user_subscription = user_subscribe::is_user_subscription($input['model']->id, $input['user']->id, 'MEDIA');
		if (!$user_subscription) {
			return [false,'User must be subscribed to model'];
		}*/

        //$rate = UserService::get_current_rate($input['model']->id);
		$rate = $input['rate'];

		$full_price = ($input['duration']) * ($rate);
		if(!$input['user']->check_credits($full_price,true)){
			return[false,['message'=> 'Not enough credits']];
		}

		try {
			$user_1_1_chat_request = user_1_1_chat_request::create([
				'user_id' => $input['user']->id,
				'model_id' => $input['model']->id,
                'service_id' => $input['service_id'],
                'state' => "ENQUEUED",
				/*'site_id' => WhiteLabel::site_id_from_uri(),*/
				'minimum_minutes' => $input['duration'],
                'max_minutes' => $input['max_minutes'],
                'appointment_id' => $input['appointment_id'],
                'rate'=> $rate
			]);
		} catch (Exception $e) {
			Log::warning( 'DB error in 1-1 chat request '.print_r($e->getMessage(), true));
		}
		return [
			true,
			[
				'message'=>"Submitted request",
				'request'=> new UserChatRequestResource($user_1_1_chat_request)
			]
		];
		
	}
	
	public static function user_requests($user,$states=['WAITING']){
		return user_1_1_chat_request::whereIn('state',$states)->where('user_id',$user->id)->get();
	}
	
	public static function user_model_requests($model,$states=['WAITING' ,'ENQUEUED']){
		$user_star_requests = user_1_1_chat_request::whereIn('state',$states)->where('model_id',$model->id)->get();
		return $user_star_requests;
	}
	
	public function cancel() {
		switch ($this->state){
			case 'ENQUEUED':
			case 'WAITING':
			case 'INCOMPLETE':

				$this->state = "INCOMPLETE";
				$this->save();

				$appointment=$this->appointment;

				if ($appointment) {
        
		            $appointment->status='Cancelled';
		       
		    	    $appointment->save();

				}

				break;
			default:
				return false;
		}
		return true;
	}
	
	public function end() {
		switch ($this->state){
			case 'LIVE':
				$this->state = 'COMPLETE';
				break;
			default:
				$this->state = 'INCOMPLETE';
		}
		
		$this->save();
		return true;
		
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
	
	public function wait() {
		switch ($this->state){
			case 'ENQUEUED':
			case 'WAITING':
				$this->state = 'WAITING';
				$this->save();
			break;
			default:
				return false;
		}
		
		return true;
		
	}


    public function expire()
    {
        $this->cancel();
    }

    /**
     * Expire all ENQUEUED chat requests that are > 2hrs old
     */
    public function expireAll() {
        $expired_requests = user_1_1_chat_request::where('state', '=', 'ENQUEUED')
            ->whereRaw('created_at < DATE_SUB(NOW(), INTERVAL 2 HOUR)')
            ->get();

        foreach($expired_requests as $expired_request) {
            try {
                $result = $expired_request->expire();
                //$user = User::find($expired_request->user_id);
                //$model = User::fetch(['id' => $expired_request->model_id]);
					$expired_request->expired = 1;
					if($expired_request->model->online){
						$expired_request->expired_online = 1;
					}
					$expired_request->save();
					TwilioUtils::send_to_psychic_when_request_expired($expired_request->model);
                    NotificationsInAppUtils::f_to_user_when_psychic_canceled_request_or_expired($expired_request,'user','expired');
                   //NotificationUtils::vchat_expired($user, $model, $expired_request->site_id);

            } catch (Exception $e) {
                Log::warning('cron_1_1_vchat_process fail expire() - ' . print_r($expired_request->toArray(), true));
                Log::warning($e);
            }
            print '#'.$expired_request->id.' '.$expired_request->created_at.' - '.$expired_request->state."\n";
        }
	}
	 /**
     * Expire all ENQUEUED chat requests that are > 2hrs old
     */
    public function expireWhenPsychicIsOnline() {
        $expired_requests = user_1_1_chat_request::where('state', '=', 'ENQUEUED')
            ->whereRaw('created_at < DATE_SUB(NOW(), INTERVAL 30 MINUTE)')
            ->get();

        foreach($expired_requests as $expired_request) {
            try {
				if($expired_request->model->online){

			        $expired_request->expire();             
					$expired_request->expired = 1;
					$expired_request->expired_online = 1;
					$expired_request->save();
					TwilioUtils::send_to_psychic_when_request_expired($expired_request->model);
					NotificationsInAppUtils::f_to_user_when_psychic_canceled_request_or_expired($expired_request,'user','expired');
					NotificationsInAppUtils::f_to_psychic_when_request_expired($expired_request,'user','expired');
                 
				}
           
            } catch (Exception $e) {
                Log::warning('cron_1_1_vchat_process fail expireWhenPsychicIsOnline() - ' . print_r($expired_request->toArray(), true));
                Log::warning($e);
            }
            print '#'.$expired_request->id.' '.$expired_request->created_at.' - '.$expired_request->state."\n";
        }
    }

    public static function star_find_missed_vchats_in_period($model_id, $start_date, $end_date) {
        return user_1_1_chat_request::where('model_id', $model_id)
            ->where('state', 'INCOMPLETE')
            ->where('model_chat_room_id', null)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();
    }
    public static function star_find_completed_vchats_in_period($model_id, $start_date, $end_date) {
        return user_1_1_chat_request::where('model_id', $model_id)
            ->where('state', 'COMPLETE')
            ->where('model_chat_room_id', '!=', null)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->count();
	}
	
	public function save(array $options = [])
    {
		if($this->model_id){

			if($this->expired_online && $this->expired){
			   
			   if($user = User::find($this->model_id)) $user->update(['lost_requests' => $user->lost_requests + 1]);
			}
			else if($user = User::find($this->model_id)) {
				
			 if($user->lost_requests) $user->update(['lost_requests' => $user->lost_requests - 1]);
			}
		   }
		   
        return parent::save();
    }
}

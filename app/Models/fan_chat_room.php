<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

use App\admin_log;
use App\Models\model_chat_room;
use Log;
use Auth;

class fan_chat_room extends Model {
	
	use SoftDeletes;

    protected $table = 'fan_chat_room';
    protected $fillable = ['user_id', 'model_chat_room_id', 'tokbox_user_token', 'state'];
	protected $dates = ['deleted_at'];
	//

	public function user(){
        return $this->belongsTo('App\Models\User');
    }
	
	public function model_chat_room(){
		return $this->belongsTo('App\Models\model_chat_room');
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
	

		
	public static function user_chat_start($input) {
		
        if (empty($input['user']) || empty($input['model']) || empty($input['model_chat_room_id'])) {
            return [false, 'invalid input'];
        }
        if ($input['user']->model_id) {
            return [false, 'Sorry, your account type cannot join shows'];
        }
        /*if (admin_log::is_chat_banned($input['user']->id)
            || star_block::is_chat_blocked($input['star']->id, $input['user']->id)) {
            return [false, 'User cannot chat with star'];
        }*/
 
        $user_subscription = user_subscribe::is_user_subscription($input['star']->id, $input['user']->id, 'MEDIA');
        if (!$user_subscription) {
            if ($input['user']->credits < $input['star_chat_room']->credits_price) {
                return [false, 'not enough credits'];
            }
            if (fan_chat_room::model_chat_room()->first()->show_type == 'PAY_PER_VIEW') {
                if (
	                	! $input['user']->deduct_credits(
	                		fan_chat_room::model_chat_room()->first()->credits_price, 
	                		'VIDEO_CHAT_SESSION', 
	                		$input['model']->id,
	                		null,
	                		false,
	                		fan_chat_room::model_chat_room()->first()->user_1_1_chat_request->service_id
	                	)
            		) {
                    return [false, 'not enough credits'];
                }
            }
        }

        return [true, []];
    }
	
	public static function end_chat($user_chat_room_id){
		
		$user_chat_room = fan_chat_room::find($user_chat_room_id);
		
		if (!$user_chat_room){
			return [false,"Invalid user chat room id"];
		}
		
		//Log::debug("User ".Auth::user()->id." and chat room user ".$user_chat_room->user_id);
		if ($user_chat_room->user_id != Auth::user()->id){
			return[false,"Chat not with this user"];
		}
		
		$room = model_chat_room::find($user_chat_room->model_chat_room_id);
		if (!$room){
			return [false,"Invalid star chat room id"];
		}
		
		return model_chat_room::end_chat($room->id);
		
	}
	public static function extend_chat($user_chat_room_id,$minutes=5){
		
		$user_chat_room = fan_chat_room::find($user_chat_room_id);
		
		if (!$user_chat_room){
			return [false,"Invalid user chat room id"];
		}
		$user = Auth::user();
		//Log::debug("Logged in user is ".$user->email);
		
		//Log::debug("Extend $minutes mins with User ".$user->id." and chat room user ".$user_chat_room->user_id);
		if ($user_chat_room->user_id != $user->id){
			return[false,"Chat not with this user"];
		}
		
		$room = model_chat_room::find($user_chat_room->model_chat_room_id);
		if (!$room){
			return [false,"Invalid star chat room id"];
		}
		
		$request = $room->user_1_1_chat_request;
		
		$minutes_unpaid = $request->minutes_requested - $room->minutes_paid;
		
		$credits_to_extend = $room->credits_per_minute * ($minutes+$minutes_unpaid);
		
		if ($user->credits < $credits_to_extend){
			
			return [false,"Not enough credits"];
		}
		
		$request->minutes_requested += $minutes;
		$request->save();
		
		// Reset 2 minute warning
		
		$room->low_credits_warning_at = '0000-00-00 00:00:00';
		$room->save();
		
		
		
		return [true,['new_length'=>$request->minutes_requested ]];
		
		
	}
	
}

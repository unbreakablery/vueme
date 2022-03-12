<?php

namespace App\Models;

use App\Http\Resources\v1\UserChatRequestResource;
use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserService extends Model
{
    //
	protected $table = 'user_service';

    protected $casts = [
        'rate' => 'decimal:2',
    ];

	protected $fillable = [

		'service_id',
		'user_id',
		'active',
		'rate',
		'min_duration'

	];

    protected $appends = ['service'];

    public function getServiceAttribute()
    {
        return $this->service()->first();
    }
	
	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

	public function service() {
		return $this->belongsTo(\App\Models\Services::class);
	}

    public static function get_current_rate($model_id) {
        $rate = UserService::where('user_id', '=', $model_id)
            ->where('service_id', '=',  WhiteLabel::config('services')->services['VideoChat'])
            ->first();
        if (!$rate) {
            $rate = false;
        }
        return $rate;
    }



    public function get_available_time() {
	    $user = auth()->guard('api')->user();
        $time_available = 0;

        if(is_null($user)){
          return 0;
        }else{

            $credits = $user->credits;
            $rate_per_minute = $this->rate;
            $minimum_time = $this->min_duration;

            if(!is_null($minimum_time ) && $minimum_time > 0 && $rate_per_minute >= 1){
                $time_available = $credits / $rate_per_minute;
            }

            if($time_available < $minimum_time){
                return 0;
            }

            return (int)$time_available;
        }

    }


    public function get_pending_request() {
        $user = auth()->guard('api')->user();
        $model  = $this->user()->first();
        $pending_request = null;
        $states=['WAITING', 'ENQUEUED'];
        if(is_null($user)){
            return null;
        }else{
            $pending_request = new UserChatRequestResource(user_1_1_chat_request::whereIn('state',$states)->where('service_id', '=', $this->service_id)->where('user_id', '=', $user->id)->where('model_id', '=', $model->id)->first());

        }
        return $pending_request;
    }


    function formatRate($n_decimals = 2)
    {
        return ((floor($this->rate) == round($this->rate, $n_decimals)) ? number_format($this->rate) : number_format($this->rate, $n_decimals));
    }

}

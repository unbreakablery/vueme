<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:03 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMessageLog
 * 
 * @property int $id
 * @property int $user_id
 * @property int $model_id
 * @property string $name
 * @property string $type
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * 
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $notify_in_apps
 *
 * @package App\Models
 */
class Appointment extends Model
{
	protected $table = 'appointment';

	protected $casts = [
		'user_id' => 'int',
		'psychic_id' => 'int',
        'service_id' => 'int'
	];

    protected $fillable = [
        'user_id',
        'psychic_id',
        'category_id',
        'service_id',
        'date',
        'start_hour',
        'end_hour',
        'duration',
        'status',
        'text',
        'type',
        'channel'
    ];

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}

	public function psychic()
	{
		return $this->belongsTo(\App\Models\User::class, 'psychic_id');
	}

    public function service()
    {
        return $this->belongsTo(\App\Models\Services::class, 'service_id');
    }
    public function user_service()
    {
        return $this->hasOne(\App\Models\UserService::class, 'service_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
    public function user_1_1_chat_request()
    {
        return $this->hasOne(\App\Models\user_1_1_chat_request::class);
    }
    public function appointment_users(){
        return $this->belongsToMany(\App\Models\User::class, 'appointment_user','appointment_id','user_id');
    }
    public function appointmentUsers(){
        return $this->hasMany(\App\Models\AppointmentUsers::class);
    }

    public function getStatusColor()
    {
        $color = "";
        if($this->status == "Pending"){
            $color = "#f9a825";
                }else if($this->status == "Confirmed"){
            $color = "#00c853";
                }else if($this->status == "Cancelled"){
            $color = "#e53935";
                }else if($this->status == "Completed"){
            $color = "#4899FA";
        }
        return $color;
    }
    
    public function convertTime($time, $fromTimezone='America/New_York', $toTimezone="America/Los_Angeles") {


        $date = new \DateTime($time, new \DateTimeZone($fromTimezone));
        
        $date->setTimezone(new \DateTimeZone($toTimezone));

        $_return = $date->format('Y-m-d H:i:s');

        return $_return;


    }

    public function getPrice(){

	    $service = $this->psychic()->first()->userService()->where('service_id', '=', $this->service()->first()->id)->first();
	    $price = $service->rate * $this->duration;
        return ((floor($price) == round($price, 2)) ? number_format($price) : number_format($price, 2));


    }
    public function end_channel_live(){
        
        $this->status = 'ENDED';
        $this->save();
        $specialist = $this->psychic;
        $specialist->is_streaming_live = false;
        $specialist->appointment_live = null;
        $specialist->save();
        //Todo pusher notification

    }
    public function channel_live_collect($users_id, $byUser = false){       
        
        $appointmentUsersTable = $this->appointmentUsers()->whereIn('user_id',$users_id);
        //$appointmentUsersTableSubscribed = $appointmentUsersTable->where('subscribed',1)->get();
        $appointmentUsersTableUnSubscribeds = $appointmentUsersTable->where('subscribed',0)->get();
        foreach ($appointmentUsersTableUnSubscribeds as $unSubscribed) {           
             $unSubscribed->proccess();

              //If collect by user then put apointment status PAUSED and update user in_stream = 0
              // Also remove model live and channel
              // find a way to do that from model side or webhooks or something
                if($byUser){
                    $this->status = 'PAUSED';
                    $this->paused_at = now();
                    $this->save(); 
                    $unSubscribed->in_stream = 0;
                    $unSubscribed->save();

                }

        }
         
    }

}

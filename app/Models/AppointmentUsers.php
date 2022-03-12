<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentUsers extends Model
{
    protected $table = 'appointment_user';

    protected $fillable = [
		'user_id',
        'appointment_id',
        'subscribed',
        'start_time',
        'credits_per_minute'
	];


    public function user()
	{
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}
    public function appointment()
	{
		return $this->belongsTo(\App\Models\Appointment::class, 'appointment_id');
	}
    public static function add_user_appointment_streaming(User $user, Appointment $live_stream){ 
        
        
       
  
        if($user->role_id == 2){
            $subscribed  = $live_stream->psychic->user_fan_subscribed()
                        ->where('user_subscription.user_id',$user->id)
                        ->whereIn('user_subscription.status',['ACTIVE'])->count();  
                        
            $inserted = $live_stream->appointment_users()->where('appointment_user.user_id',$user->id)->first();          
            if($subscribed){
                if(!$inserted){
                    //Add user to livestream
                    $service = $live_stream->psychic->user_services()->where('service_id',$live_stream->service_id)->first();
                    return AppointmentUsers::create([
                      'user_id' => $user->id,
                      'appointment_id' => $live_stream->id,
                      'subscribed' => 1,
                      'credits_per_minute' => $service->rate
                    ]);
                 }else{
                     $appointment_user = AppointmentUsers::where('user_id',$user->id)
                                                            ->where('appointment_id',$live_stream->id)->first();
                     if($appointment_user){
                          $appointment_user->subscribed = 1;
                          $appointment_user->start_time = now();
                          $appointment_user->save();
                     }                                       
                  
                 } 
            }else{
                if(!$inserted){
                    //Add user to livestream
                    $service = $live_stream->psychic->user_services()->where('service_id',$live_stream->service_id)->first();
                    return AppointmentUsers::create([
                      'user_id' => $user->id,
                      'appointment_id' => $live_stream->id,
                      'subscribed' => 0,
                      'start_time' => now(),
                      'credits_per_minute' => $service->rate
                    ]);
                 }else{

                    $appointment_user = AppointmentUsers::where('user_id',$user->id)
                                                            ->where('appointment_id',$live_stream->id)->first();
                     if($appointment_user){                          
                          $appointment_user->start_time = now();
                          $appointment_user->save();
                     }                                   
                    

                 }    
                 
            } 
              
        }
    }
    public function proccess(){
        
        $this->live_streaming_update();       
       
    }
    public function live_streaming_update($ending = false){		
		
			
		$seconds_started = strtotime($this->start_time);
		$terminate = false;
		$time_collected = time();
        $start_time = now();
        $user = $this->user;
		if ($seconds_started > 0)
		{
			$seconds_so_far = $time_collected - $seconds_started;           
			
			$minutes_so_far = floor($seconds_so_far / 60);
			
			$minutes_due    =  $minutes_so_far;
			
			$credits_due    =  round($seconds_so_far  * $this->credits_per_minute / 60,2);



         	$credits_left   = $user->credits - $credits_due;
			
			if ( !$user->check_credits($credits_due,true))
			{
				$terminate = true;
				$credits_due = $user->credits;

			}

			if ($credits_due > 0)
			{
				
				$action = $this->appointment->service->name;

				if(!$ending){
					if ( !$user->deduct_credits(
						$credits_due,
						$action, 
						$this->appointment->psychic_id, 
						null, 
						false, 
						$this->appointment->service_id, 
						$this->appointment->id
						) 
					) {
	
						return [false ,'Not enough credits'];
					}
			
			
				$this->duration += $seconds_so_far;
				$this->credits_deducted += $credits_due;
                $this->start_time = $start_time;
				$this->save();
                //Send signal to update credits
                //Todo pusher notification
				}	


				if ($terminate){
                    //Send signal end session
                    //Todo pusher notification
					return [false,'Not enough credits'];
				}



				
				$min_credits = 2 * $this->credits_per_minute;

				
				if (!$user->check_credits($min_credits,true))
				{
                    //Send signal end session in total seconds
                    //Todo pusher notification
					$data = [
						'action'   => 'WARNING'
						,'message' => 'LOW CREDITS'
	
					];
                    


					//ChatRoomUtils::send_signal($this->tokbox_session_id ,$data);
					// $this->low_credits_warning_at = date('Y:m:d H:i:s');
					// $this->save();
				}
			
			}	
			
		}
		

		return [true];
		
 
	}
}    

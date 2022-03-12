<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserChatRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $action_description = $first_image = $second_image = $first_text = $second_text = $action = $from = $profile_headshot_url =''; 
      
        if($this->online && $this->last_log_in < now()->subHours(30)){
            $user = User::find($this->id);
            $user->online = 0;
            $user->save();
        }

   
       if(Auth::check() && Auth::user()->role_id == 1){

         switch($this->state){
             case 'ENQUEUED':
             $action_description = 'Requested Now';  
             $first_text = 'Start';
             $second_text = 'Decline';      
                if($this->service_id == 1){
                $first_image = '/images/icons/notifications/call.svg';
                }else{
                $first_image = '/images/icons/notifications/video.svg';
                }
                $second_image = '/images/icons/notifications/decline.svg';
                $action = 'to_model_request_now_received';
                $from = $this->user->userProfile->name;
                $profile_headshot_url = $this->user->userProfile->haedshot_path;

                if($this->appointment->status == 'Confirmed'){
                    $action_description = 'Begin Scheduled Reading';  
                    $action = 'to_psychic_scheduled_reading_start';
                }

                
                    break;
             case 'WAITING':
           
                    break;
             break;       
         }

          
       }else{
         
        switch($this->state){
            case 'ENQUEUED':
                $action_description = 'Now, Request Sent';     
                $first_image = '/images/icons/notifications/decline.svg'; 
                $second_image = '';  
                $first_text = 'Cancel';
                $second_text = '';  
                $action = 'to_user_request_now_sent';   
                $from = $this->model->userProfile->display_name;
                $profile_headshot_url = $this->model->userProfile->haedshot_path;

                if($this->appointment->status == 'Confirmed'){
                    $action_description = 'Scheduled Reading';  
                    $action = 'to_user_scheduled_reading_start';
                }
            break;

            case 'WAITING':
                $action_description = 'Accepted, Join Reading'; 
                if($this->service_id == 1){
                    $first_image = '/images/icons/notifications/call.svg';
                    }else{
                    $first_image = '/images/icons/notifications/video.svg';
                    }
                $second_image = '/images/icons/notifications/decline.svg'; 
                $first_text = 'Join';
                $second_text = 'Cancel';  
                $action = 'to_user_request_now_accepted';  
                $from = $this->model->userProfile->display_name; 
                $profile_headshot_url = $this->model->userProfile->haedshot_path;
            break;
        }
          
       }
        
       
       
        return [
            'id' => $this->id,
            'state' => $this->state,
            'max_minutes' => $this->max_minutes,
            'minimum_minutes'=> $this->minimum_minutes,
            'user' => new UserBasicResource($this->user()->first()),
            'model' => new UserBasicResource($this->model()->first()),
            'model_chat_room' => $this->model_chat_room()->first(),
            'service_id' => $this->service_id,

            'action_description' => $action_description,
            'request_description' => $this->service->name.', '.$this->appointment->category->name,
            'first_image' => $first_image,            
            'second_image' => $second_image,
            'first_text' => $first_text,
            'second_text' => $second_text,
            'action' => $action, 
            'color' => '', 
            'from' => $from, 
            'profile_headshot_url' =>$profile_headshot_url,
            'updated' => $this->updated_at,  
            'online' => $this->online,
            'schedule' => $this->appointment->schedule,        

        ];
    }
}

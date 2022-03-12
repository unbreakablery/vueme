<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\SMSChat;
use App\Services\TwilioUtils;
use Exception;

class SendSMSChat
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //Send SMS
    $interval = (object) array('h' => 0);
    $number= '';
       if($event->last_chat){
            $last_time = date_create($event->last_chat->created_at);
            $now_time = date_create($event->chat->created_at);
            $interval =date_diff($last_time,$now_time);
          
       } 
       $receiver =$event->chat->receiver()->first();
    //    if($receiver->isPsychic()){
    //        $message = 
    //    }
       $number_obj = $receiver->user_mobile_nums()->first();
       

       $number = $number_obj->prefix.$number_obj->number;
      

       if($number_obj->user->email_validated && $number){         
          try {
           
            //$code = rand(1000, 99999);            
            TwilioUtils::is_valid_number($number);
            if($event->chat->user()->first()->role_id == 2){
                
                if(!$event->last_chat 
                || ($event->chat->receiver->online && ($interval->i >= 1 || $interval->h > 0 ||  $interval->days > 0)) 
                || (!$event->chat->receiver->online && ($interval->h > 0 || $interval->days > 0)))
                {
                    TwilioUtils::send_sms_to_psychic_first_message_new_chat($event->chat);
                }


                
            }else{
                if(!$event->last_chat || $interval->h > 0 || $interval->days > 0){

                    $name = ($event->chat->user()->first()->role_id == 1)? 
                    $event->chat->user()->first()->UserProfile()->first()->display_name:
                    $event->chat->user()->first()->UserProfile()->first()->name;
                     TwilioUtils::send_sms_first_message($number,'You have a new message from '.$name.':  https://respectfully.com/chat?user='.$event->chat->user->id);
                }
               
            }
        
        
          } catch (Exception $ex) {
              return "Error SMS";
          }
         
        }
    }
    public function failed(SMSChat $event, $exception)
    {
        //
    }
}

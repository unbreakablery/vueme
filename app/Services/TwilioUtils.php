<?php

namespace App\Services;
use Exception;
use App\Services\WhiteLabel;
use Twilio\Rest\Client;
use App\Models\User;


class TwilioUtils
{
     
   
    public static function is_valid_number($number,$code= null)
    {
    
        if($code == null){
            $code ='US';
        }
        try {

            $user = env('TWILIO_USER');      
            $secret = env('TWILIO_PASSWORD');
            $account_sid = env('TWILIO_ACCOUNT_SID');  
            $client = new Client($user, $secret, $account_sid);         
            $phone_number = $client->lookups->v1->phoneNumbers('+'.$number)->fetch(array("type" => array("carrier")));
            return $phone_number->carrier['type']!='voip';
            //return true;
       
        } catch (Exception $ex) {
            return false;           
        }
       
    } 
    public static function sms_15_minutes_before_appointment($appointment)
    {       

        $mobile_user = $appointment->user->user_mobile_nums()->first();
        $mobile_specialist = $appointment->specialist->user_mobile_nums()->first();
              
        $message_user = 'Teachers1on1 Friendly Reminder: Your lesson with ' .$appointment->specialist->UserProfile->display_name.' begins in 15 minutes.';
        $message_specialist = 'Teachers1on1 Friendly Reminder: Your lesson with ' .$appointment->user->UserProfile->name.' begins in 15 minutes.';
        self::send_message($mobile_user,$message_user); 
        self::send_message($mobile_specialist,$message_specialist);   
      
    }


    public static function send_sms_first_message($number,$message,$code = null)
    {
        $user = env('TWILIO_USER');      
        $secret = env('TWILIO_PASSWORD');
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $twilio_number =WhiteLabel::config('twilio')->system_numbers['US'];         
        $client = new Client($user, $secret, $account_sid);          
        
        $client->messages->create(
            // Where to send a text message (your cell phone?)
            '+'.$number,
            array(
                'from' => $twilio_number,
                'body' => $message
            )
        );
      
    }



    // Teachers SMS - STUDENT ENGAGEMENT DAY 3 -done
    public static function send_sms_day_3_student_engagement($user)
    {       

        $mobile = $user->user_mobile_nums;       
        $message = 'Teachers1on1 - get started with $5 free on your first purchase: teachers1on1.com ';
        self::send_message($mobile,$message);  
      
    } 

    // STUDENT - JOIN LESSON -done
    public static function send_sms_student_join_lesson($user_1_1_chat_request)
    {       

        $mobile = $user_1_1_chat_request->user()->first()->user_mobile_nums()->first();              
        $message = 'It is time for your lesson with '.$user_1_1_chat_request->model()->first()->UserProfile()->first()->display_name.
                 '. Join now: '.route('user_dashboard_appointments').'?r='.$user_1_1_chat_request->id;
        self::send_message($mobile,$message);  
      
    } 

    // STUDENT- ACCOUNT
    // Sent to student when they have a new chat message recieved more than 10 mins since the last new message recieved. 
    public static function send_sms_student_account($chat) /***check*/
    {       
        $code = rand(1000, 99999);
        $mobile = $chat->receiver()->first()->user_mobile_nums()->first(); 
        $message = 'You have a new message from Teacher '.$chat->user()->first()->UserProfile()->first()->display_name.
                 ': '.env('APP_URl').'/chat?user='.$chat->user->id;
        self::send_message($mobile,$message); 
        
      
    } 

    

    // TEACHERS NEW REQUEST SCHEDULED -done
    //Sent to teachers when they have a new scheduled lesson equest to confirm. Should link to modal so they can confirm immediatly. 
    public static function send_sms_teachers_new_request_scheduled($appointment,$now_or_later)
    {       

        $mobile = $appointment->psychic()->first()->user_mobile_nums()->first(); 

        $app = ApiUtils::url();
        $name = $appointment->user()->first()->UserProfile()->first()->name;
        $message = 'Student '.$name.' has requested a lesson - confirm now! '.$app.'/dashboard/appointments';

        if($now_or_later == 'later'){
            $message = $name.' has requested a scheduled lesson - confirm now! '.route('dashboard').'?a='.$appointment->id;
        }       
        self::send_message($mobile,$message); 
        
      
    } 

    //TEACHERS NEW REQUEST NOW
    public static function send_sms_teachers_new_request_now($user_1_1_chat_request)
    {       

        $mobile = $user_1_1_chat_request->user()->first()->user_mobile_nums()->first();       
        $message =  'Student '.$user_1_1_chat_request->user()->first()->UserProfile()->first()->name.' needs help now. 
                     Accept or deny their request here: '.route('dashboard').'?r='.$user_1_1_chat_request->id;
        self::send_message($mobile,$message);  

      
    } 

   //TEACHERS START LESSON NOW 
   //Sent to teachers when its time to start a lesson 
   public static function send_sms_teachers_start_lesson_now($appointment,$now_or_later)
   {       

       $mobile = $appointment->psychic()->first()->user_mobile_nums()->first();       
       $message =  'It is time for your lesson with '.$appointment->user()->first()->UserProfile()->first()->display_name.'
                    . Start now: [link to pop up to join/start lesson]';
       self::send_message($mobile,$message);  


       $mobile_user = $user_1_1->user()->first()->user_mobile_nums()->first();      
       $message = 'It is time for your lesson with '.$user_1_1->model()->first()->UserProfile()->first()->display_name.
           ' Start now:'.route('user_dashboard_appointments').'/r='.$user_1_1->id;
      self::send_message($mobile_user,$message, null, 'SmsMarketing');

      $mobile_psychic = $user_1_1->model()->first()->user_mobile_nums()->first();      
      $message = 'Begin '.
          $user_1_1->user()->first()->UserProfile()->first()->name.'`s lesson Now! '.route('dashboard').'?r='.$user_1_1->id;

       self::send_message($mobile_psychic,$message, null, 'SmsMarketing');



       
     
   } 


      //TEACHERS NEW CHAT MESSAGE - SMS OFFLINE / ONLINE
      //Triggered if a teacher is OFFLINE and a specific student sends them a message for the first time in 1+hr(s) - (do not send again if the same user sends more than one message in under 1hr)
      public static function send_sms_to_teachers_first_message_new_chat($chat)
      {       
   
          $code = rand(1000, 99999);
          $mobile = $chat->receiver()->first()->user_mobile_nums()->first(); 
          $message = $chat->receiver->online ?
           'You have a new message from student '. $chat->user()->first()->UserProfile()->first()->name.'. Please respond ASAP: '.env('APP_URL').'/chat?user='.$chat->user->id : 
           'You have a new message from student '. $chat->user()->first()->UserProfile()->first()->name.'. Please respond within 24 hours: '.env('APP_URL').'/chat?user='.$chat->user->id;
          self::send_message($mobile,$message);
        
      }
      
      






    public static function send_sms_appointment_booked($appointment)
    {       

        $mobile = $appointment->user()->first()->user_mobile_nums()->first();       
        $message = 'Your lesson with '.
            $appointment->psychic()->first()->UserProfile()->first()->display_name.' is booked: '.route('user_dashboard_appointments').'?p='.self::get_rand_number();
        self::send_message($mobile,$message);  
      
    } 
    public static function send_sms_appointment_cancel($appointment)
    {       

        $app = ApiUtils::url();
        $mobile = $appointment->user()->first()->user_mobile_nums()->first();        
        $message = 'Your lesson with '.
            $appointment->psychic()->first()->UserProfile()->first()->display_name.' was declined. Try another Teacher: '.$app.'?p='.self::get_rand_number();
        self::send_message($mobile,$message); 
      
    } 
    public static function send_sms_psychic_is_ready_to_initiate_service($user_1_1_chat_request)
    {       

        $mobile = $user_1_1_chat_request->user()->first()->user_mobile_nums()->first();       
        $message = $user_1_1_chat_request->model()->first()->UserProfile()->first()->display_name.
        ' is ready for your lesson! Join now: '.route('user_dashboard_appointments').'?r='.$user_1_1_chat_request->id;
        self::send_message($mobile,$message); 
       
    }
    
        
    public static function send_sms_when_user_create_appointment($appointment,$now_or_later)
    {       

        $mobile = $appointment->psychic()->first()->user_mobile_nums()->first(); 

        $app = ApiUtils::url();
        $name = $appointment->user()->first()->UserProfile()->first()->name;
        $message = $name.' has requested a lesson - confirm now! '.$app.'/dashboard';

        if($now_or_later == 'later'){
            $message = $name.' has requested a scheduled lesson - confirm now! '.route('dashboard').'?a='.$appointment->id;
        }       
        self::send_message($mobile,$message); 
    
    } 

    public static function send_sms_to_psychic_request_now_received($user_1_1_chat_request)
    {
        $mobile = $user_1_1_chat_request->user()->first()->user_mobile_nums()->first();       
        $message = $user_1_1_chat_request->user()->first()->UserProfile()->first()->name.
        ' has requested a lesson - start now! '.route('dashboard').'?r='.$user_1_1_chat_request->id;
        self::send_message($mobile,$message); 
    }
    public static function send_sms_psychic_and_user_when_appointment_will_start($user_1_1)
    {       

        $mobile_user = $user_1_1->user()->first()->user_mobile_nums()->first();      
        $message = $user_1_1->model()->first()->UserProfile()->first()->display_name.
            ' is ready for your lesson! Join now: '.route('user_dashboard_appointments').'/r='.$user_1_1->id;
       self::send_message($mobile_user,$message, null, 'SmsMarketing');

       $mobile_psychic = $user_1_1->model()->first()->user_mobile_nums()->first();      
       $message = 'Begin '.
           $user_1_1->user()->first()->UserProfile()->first()->name.'`s lesson Now! '.route('dashboard').'?r='.$user_1_1->id;

        self::send_message($mobile_psychic,$message, null, 'SmsMarketing');
      
    }
    
    public static function send_sms_to_psychic_appointment_cancel($appointment)
    {       
    
        $mobile = $appointment->psychic()->first()->user_mobile_nums()->first();          
        $message = 'Your appointment with '.
        $appointment->user()->first()->UserProfile()->first()->name.' has been canceled. '.route('dashboard');
        self::send_message($mobile,$message);
      
    }
    public static function send_sms_to_user_when_psychic_appointment_cancel($appointment)
    {       
    
        $app = ApiUtils::url(); 
        $mobile = $appointment->user()->first()->user_mobile_nums()->first();          
        $message = 'Your lesson with '.
        $appointment->model()->first()->UserProfile()->first()->display_name.' was declined. Try another teacher: '. $app.'?p='.self::get_rand_number();
        self::send_message($mobile,$message);
      
    }  
    public static function send_sms_to_psychic_appointment_rescheduled($appointment)
    {       

        $mobile = $appointment->psychic()->first()->user_mobile_nums()->first();         
        $message = 'Your lesson with '.
        $appointment->user()->first()->UserProfile()->first()->name.' was rescheduled. Confirm Now: '.env('APP_URL').'/dashboard';
        self::send_message($mobile,$message);
      
    } 

    public static function send_sms_to_psychic_first_message_new_chat($chat)
    {
        $code = rand(1000, 99999);
        $mobile = $chat->receiver()->first()->user_mobile_nums()->first(); 
        $message = $chat->receiver->online ?
         'You have a new message from '. $chat->user()->first()->UserProfile()->first()->name.'. Please respond ASAP: '.env('APP_URl').'/chat?user='.$chat->user->id : 
         'You have a new message from '. $chat->user()->first()->UserProfile()->first()->name.'. Please respond within 24 hours: '.env('APP_URl').'/chat?user='.$chat->user->id;
        self::send_message($mobile,$message);
      
    }


    public static function send_verification_sms($mobile)
    {
       
        $message = 'Your '.env('APP_NAME').' verification code is: '.$mobile->verification_code. '. Reply STOP to unsubscribe.';
        self::send_message($mobile,$message);

    }
    public static function send_to_user_after_one_day_regiter_first_chat_free($user)
    {
        $mobile = $user->user_mobile_nums()->first();
        $app = ApiUtils::url(); 
        $message = 'Get started on '.env('APP_NAME').' - the first message you send is FREE:'.$app;
        self::send_message($mobile,$message, null, 'SmsMarketing');

    }
    public static function send_to_psychic_when_request_expired($specialist)
    {
       $total_request_expired = $specialist->lost_requests;
       if($total_request_expired == 10 || $total_request_expired == 25) {
        $message = env('APP_NAME').' Warning: Your profile visibility has been downgraded due to 10+ missed lesson requests. Unresponsive Teachers create a poor student experience. Questions? Contact support@teachers1on1.com';
           if($total_request_expired == 25){
           $message = env('APP_NAME').' Last Warning: Your profile has been downgraded to lowest visibility due to 25+ missed lesson requests. Continued unresponsiveness when online will result in account deactivation.';
           }
        $mobile = $specialist->user_mobile_nums()->first();
        if($mobile){
            self::send_message($mobile,$message, null, 'SmsMarketing');
        }
        
       }

    }

     

    public static function send_SMS($mobile,$message, $did = 'SmsMarketing')
    {
       
        self::send_message($mobile,$message, null, $did);

    }
    private static function get_rand_number(){
        return  rand(1000, 99999);
    }
    private static function check_user_disabled($user){
       
    }


    private static function send_message($number_obj,$message,$code2=null, $did = "twilio"){

       if($number_obj->user->email_validated)
       {
        $number = $number_obj->prefix.$number_obj->number;
        $code2 = $number_obj->code2; 
        if($number){
                 $is_valid = self::is_valid_number($number,$code2);
                if($is_valid){
                    $user = env('TWILIO_USER');      
                    $secret = env('TWILIO_PASSWORD');
                    $account_sid = env('TWILIO_ACCOUNT_SID');
                    $twilio_number =WhiteLabel::config($did)->system_numbers['US'];         
                    $client = new Client($user, $secret, $account_sid);                     
                        $client->messages->create(
                        // Where to send a text message (your cell phone?)
                        '+'.$number,
                        array(
                            'from' => $twilio_number,
                            'body' => $message
                        )
                        );            
                }

        }
       }

      
     
           
    } 
    
    }  

    
<?php

namespace App\Services;
use App\Mail\BlogEmail;
use App\Mail\Subscribed;
use App\Mail\DailyReport;
use App\Mail\CreditsOffer;
use App\Mail\WellcomeUser;
use App\Mail\ReferralEmail;
use App\Mail\RequestReview;
use App\Mail\NoLogged30Days;
use App\Mail\PsychicProfile;
use App\Mail\ReviewReceived;
use Illuminate\Mail\Message;
use App\Mail\PayoutInitiated;
use App\Mail\PurchaseCredits;
use App\Mail\SpanishPsychics;
use App\Mail\Day10ClientEmail;
use App\Mail\Day20ClientEmail;
use App\Mail\Day45ClientEmail;
use App\Mail\FeaturesPsychics;
use App\Mail\FirstMessageFree;
use App\Mail\Day14PsychicsTips;
use App\Mail\NewReadingRequest;
use App\Mail\Specialties30Days;
use App\Mail\Day3PurchaseCredit;
use App\Mail\Day7PurchaseCredit;
use App\Mail\AfterRegister24Hour;
use App\Mail\BeginYourReadingNow;
use App\Mail\ClientReadingBooked;
use App\Mail\Day7PsychicsSuccess;
use App\Mail\UserTopRatePsychics;
use App\Mail\FirstPurchaseCredits;
use App\Mail\MarketingClientEmail;
use App\Mail\WeeklyHoroscopeEmail;
use App\Mail\MarketingPsychicEmail;
use App\Mail\ClientWishesReschedule;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientIsReadyForReading;
use App\Mail\PsychicIsReadyForReading;
use App\Mail\WeeklyHoroscopeSignEmail;
use App\Mail\newScheduleReadingRequest;
use App\Mail\AnnouncementHoroscopeEmail;
use App\Mail\PsychicProfileMissingFields;

class EmailUtils
{

    public static function send_to_user_when_reading_booked($appointment)
    {
        //12 Goes to client when their appointment has been booked
        //AppointmentController  updateAppointmentStatus()
        Mail::to($appointment->user()->first()->email)->send(new ClientReadingBooked($appointment));  
    }    
    public static function send_to_user_when_register($user_created)
    {
        //08 Goes to clients immediately after signup
        // AuthController  registerUser
        Mail::to($user_created->email, $user_created->UserProfile()->first()->name)->send(new WellcomeUser($user_created));
    } 
    public static function send_to_user_when_psychic_is_ready_to_initiate_service($user_1_1_chat_request)
    {
        //14 Goes to client when Model is ready for to inititate video chat or calling session 
        // UserController  model_vchat_start()

        Mail::to($user_1_1_chat_request->user()->first()->email)->send(new BeginYourReadingNow($user_1_1_chat_request));  
    } 
    public static function send_to_psychic_when_user_request_service($appointment,$now_or_later)
    {
        //15 Goes to Model when client has requested to schedule video chat or calling session 
        //AppointmentController  createAppointment()
        if($now_or_later == 'later'){
            Mail::to($appointment->psychic()->first()->email)->send(new newScheduleReadingRequest($appointment)); 
        }else{
            Mail::to($appointment->model()->first()->email)->send(new NewReadingRequest($appointment)); 
        }
         
    } 
    public static function send_to_psychic_when_user_is_ready_to_reading($appointment)
    {
        //16 Goes to Model when scheduled video chat or calling session is ready to begin 
        //  ()
        Mail::to($appointment->psychic()->first()->email)->send(new ClientIsReadyForReading($appointment));
        Mail::to($appointment->user()->first()->email)->send(new PsychicIsReadyForReading($appointment));    
    } 
    public static function send_to_psychic_when_user_reschedules_service($new_appointment,$old_appointment)
    {
        //18 Goes to Model when client reschedules a scheduled call or chat, they will need to confrim or deny 
        // AppointmentController  editUserAppointment()
        Mail::to($new_appointment->psychic()->first()->email)->send(new ClientWishesReschedule($new_appointment,$old_appointment));  
    }

    public static function send_to_clients_credits_offer($user)
    {
        //18 Goes to Model when client reschedules a scheduled call or chat, they will need to confrim or deny
        // AppointmentController  editUserAppointment()
        Mail::to($user->email)->send(new CreditsOffer($user));
        //var_dump($user->email);
    }
    public static function send_to_psychic_when_payout_is_created($user,$payoutDetails)
    {
        Mail::to($user->email)->queue( new PayoutInitiated($user, $payoutDetails));
        //Mail::to($user->email)->send(new PayoutInitiated($user,$payoutDetails));
        //var_dump($user->email);
    }
    public static function send_to_client_when_request_review($appointment)
    {
        //# Goes to client when Model selects request review
        Mail::to($appointment->user()->first()->email)->queue( new RequestReview($appointment));
    }


    public static function spanish_psychics_send_to_all($user)
    {
        //# Goes to client when Model selects request review
        Mail::to($user->email)->queue( new SpanishPsychics($user));
    }
    public static function send_email_to_users_after_one_day_after_register_first_message_free($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new FirstMessageFree($user));
    }
    public static function send_email_to_psychic_when_received_review($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new ReviewReceived($user));
    }

    public static function send_email_to_user_features_psychics($user, $subject, $psychic)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new FeaturesPsychics($user, $subject, $psychic));
    }

    public static function send_email_to_user_top_rate_psychics($user, $subject, $models)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new UserTopRatePsychics($user, $subject, $models));
    }

    public static function send_email_to_first_purchase_credits($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new FirstPurchaseCredits($user));
    }

    public static function send_email_to_purchase_credits($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new PurchaseCredits($user));
    }

    public static function send_email_to_no_logged_30_days($user, $users)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new NoLogged30Days($user, $users));
    }

    public static function send_daily_report()
    {
        //# Goes to client after 1 day register
        Mail::to('jl@justindlevine.com')->cc([
            'avi@telxcomputers.com',
            'km@collide.com'
        ])->send( new DailyReport());

    }

    public static function send_blog_email($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->send( new BlogEmail($user));

    }

    public static function day_7_purchase_credit($user)
    {
        Mail::to($user->email)->queue( new Day7PurchaseCredit($user));
    }

    public static function day_3_purchase_credit($user)
    {
        Mail::to($user->email)->queue( new Day3PurchaseCredit($user));
    }

    public static function weekly_hroscope_email($user, $subject, $signs)
    {
        Mail::to($user->email)->queue( new WeeklyHoroscopeEmail($user, $subject, $signs));
    }

    public static function weekly_horoscope_sign_email($user, $subject, $signs)
    {
        Mail::to($user->email)->queue( new WeeklyHoroscopeSignEmail($user, $subject, $signs));
    }

    public static function psychic_profile($user)
    {
        Mail::to($user->email)->queue( new PsychicProfile($user));
    }

    public static function send_email_24_hour_after_register($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new AfterRegister24Hour($user));
    }

    public static function send_email_10_day_after_client_register($user, $users)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new Day10ClientEmail($user, $users));
    }

    public static function send_email_20_day_after_client_register($user, $users)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new Day20ClientEmail($user, $users));
    }

    public static function send_email_45_day_after_client_register($user, $users)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new Day45ClientEmail($user, $users));
    }

    public static function send_email_psychic_profile_missing_details($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new PsychicProfileMissingFields($user));
    }


    public static function send_email_to_specialties_30_days($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new Specialties30Days($user));

    }

    public static function send_email_to_psychics__7days($user, $images, $titles, $texts)
    {
        //# Goes to psychic after 7 day register
        Mail::to($user->email)->queue( new Day7PsychicsSuccess($user, $images, $titles, $texts));
    }

    public static function send_email_to_psychics__14days($user, $images, $titles, $texts)
    {
        //# Goes to psychic after 7 day register
        Mail::to($user->email)->queue( new Day14PsychicsTips($user, $images, $titles, $texts));
    }

    public static function send_email_marketing_psychic($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new MarketingPsychicEmail($user));
    }

    public static function send_email_marketing_client($user)
    {
        //# Goes to client after 1 day register
        Mail::to($user->email)->queue( new MarketingClientEmail($user));
    }



    public static function send_announcement_horoscope_email($user)
    {
        Mail::to($user->email)->queue( new AnnouncementHoroscopeEmail($user));
    }

    public static function send_referral_email($user)
    {
        Mail::to($user->email)->queue( new ReferralEmail($user));        
    }

    public static function subscribed($user, $subscription){ 
        
        // if(EmailUtils::can_send($user)){     
        Mail::to($user->email)->send(new Subscribed($user, $subscription));  
        // }  
    }
    
}
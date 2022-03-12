<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Appointment;
use App\Models\user_1_1_chat_request;
use App\Models\User;

use App\Events\VideoPrivateSent;
use App\Events\ModelAcceptTokboxChat;
use App\Events\ModelCancelsTokboxChat;
use App\Events\FanCancelsTokboxChat;
use App\Services\EmailUtils;
use App\Services\NotificationsInAppUtils;
use App\Services\TwilioUtils;


class MakeVideoChatRequestForAppointment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MakeVideoChatRequestForAppointments:Run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $todays_appointment=Appointment::where('status', '=', 'Confirmed')->get();
        /// whereDate('start_hour', date("Y-m-d"))->

        foreach ($todays_appointment as $t_appointment) {
        
            // @ToDo still needs timezone calu

            $toTimezone=$t_appointment->user->userProfile->timezone;

            $now=new \DateTime(  );
                $now->setTimezone(new \DateTimeZone($toTimezone));


            print_r($now);
            echo PHP_EOL;

            $start_hour= new \DateTime(
                $t_appointment->start_hour, 
                new \DateTimeZone($toTimezone)
            );

            print_r($start_hour);
            echo PHP_EOL;

            $since_start = $now->diff($start_hour);   

            print_r($since_start);  
            echo PHP_EOL;

            $minutes = $since_start->days * 24 * 60;
            $minutes += $since_start->h * 60;
            $minutes += $since_start->i;
            
            //$minutes = \abs($minutes);
            print_r("Minutes: ".$minutes);
            echo PHP_EOL;
            if (
                ($minutes <= 2 && $minutes > 0)
                &&
                (user_1_1_chat_request::where('appointment_id', '=', $t_appointment->id)->doesntExist())
            ) {
                echo 'APPOINTMENT ID: '.$t_appointment->id. PHP_EOL;
                echo PHP_EOL;

                $model = User::getModelByIdOrDisplayName($t_appointment->psychic_id, null);
                $user = User::find($t_appointment->user_id);

                $chat_service = $model->userService()->where('service_id', '=', $t_appointment->service_id)->first();

                if ($chat_service->active) {
                    
                    $duration = $chat_service->min_duration;
                    $max_duration  = $chat_service->get_available_time();

                    $data = ['model'=> $model
                        ,'user'=> $user
                        ,'duration'=> $duration
                        ,'service_id'=> $t_appointment->service_id
                        ,'max_minutes'=> $max_duration
                        ,'rate'=> $chat_service->rate
                        ,'appointment_id' => $t_appointment->id
                    ];

                    //var_dump($data);

                    $result = user_1_1_chat_request::vchat_request($data);  
                    broadcast(new VideoPrivateSent($result[1]))->toOthers();
                    NotificationsInAppUtils::f_send_notification($t_appointment,'user','appointment');
                    NotificationsInAppUtils::f_send_notification($t_appointment,'psychic','appointment');                       
                    EmailUtils::send_to_psychic_when_user_is_ready_to_reading($t_appointment);
                    TwilioUtils::send_sms_psychic_and_user_when_appointment_will_start($result[1]['request']);
                    

                    //var_dump($result);
                    
                    if (empty($result[0])) {
                    }
                    else {
                       //broadcast(new VideoPrivateSent($result[1]))->toOthers();
                    }
                }

            }

        }



    }
}

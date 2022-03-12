<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\TwilioUtils;
use Illuminate\Console\Command;

class sms_new_promo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms_new_promo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get $5 free next purchase';

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
        $users = User::where('user.role_id', '=', 2)->where('test_user', 0)->where('email_validated', 1)->where('id','>', 9750)->get();   
        //$users = User::where('user.role_id', '=', 2)->where('email_validated', 1)->where('email', 'guiasmartwireless@gmail.com')->get();      

        foreach ($users as $user) {

            $number = $user->user_mobile_nums()->first();
            if($number && $number->number != "" && !is_null($number->number) && !empty($number->number) && $number->validated){
                $code = rand(1000, 99999);
                $message = "Get $5 free with your next purchase! Apply the promo by purchasing through this link: respectfully.com/?mc=".$code;
                $this->line('Client ID: '.$user->id.' -- Client number: '.$number->number);
                TwilioUtils::send_SMS($number, $message, 'sms_new_promo');
                
            }

        }

        $models = User::where('user.role_id', '=', 1)->where('test_user', 0)->where('email_validated', 1)->get();
        //$models = User::where('user.role_id', '=', 1)->where('email_validated', 1)->where('email', 'rayselguia@gmail.com')->get();

        foreach ($models as $psychic) {
            $number = $psychic->user_mobile_nums()->first();
            if($number && $number->number != "" && !is_null($number->number) && !empty($number->number) && $number->validated){
                $code = rand(1000, 99999);
                $message = "You spoke and we listened - as of today the “First Message Free” promo is officially over! respectfully.com/?pl=".$code;
                $this->line('Model ID: '.$psychic->id.' -- Model number: '.$number->number);   
                TwilioUtils::send_SMS($number, $message, 'sms_new_promo');
                            
            }

        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\TwilioUtils;
use Illuminate\Console\Command;

class sms_new_profile_page extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_sms_new_profile_page_ready';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send sms to all active models as soon as the new psychic profile goes live';

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
        //$models = User::where('user.role_id', '=', 1)->where('test_user', 0)->where('email_validated', 1)->get();
        $models = User::where('user.role_id', '=', 1)->where('email_validated', 1)->where('email', 'rayselguia@gmail.com')->get();

        foreach ($models as $psychic) {
            $number = $psychic->user_mobile_nums()->first();
            if($number && $number->number != "" && !is_null($number->number) && !empty($number->number) && $number->validated){
                $code = rand(1000, 99999);
                $message = "Respectfully has a new profile page design! Edit your profile details now to ensure your page looks complete: ".route('psychic_profile').'?n='.$code;
                $this->line('Model ID: '.$psychic->id.' -- Model number: '.$number->number);   
                TwilioUtils::send_SMS($number, $message, 'sms_new_profile_page');
                EmailUtils::psychic_profile($psychic);
                            
            }

        }
    }
}

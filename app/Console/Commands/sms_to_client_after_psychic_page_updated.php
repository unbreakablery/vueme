<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\TwilioUtils;
use Illuminate\Console\Command;

class sms_to_client_after_psychic_page_updated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_sms_to_client_after_psychic_page_updated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Goes to all active clients 5 days after the psychic profile page updates go live';

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
        //$users = User::where('user.role_id', '=', 2)->where('test_user', 0)->where('email_validated', 1)->where('id','>', 9750)->get();   
        $users = User::where('user.role_id', '=', 2)->where('email_validated', 1)->where('email', 'guiasmartwireless@gmail.com')->get();      

        foreach ($users as $user) {

            $number = $user->user_mobile_nums()->first();
            if($number && $number->number != "" && !is_null($number->number) && !empty($number->number) && $number->validated){
                $code = rand(1000, 99999);
                $message = "We’ve got a new look! Browse our models to see more robust profiles with detailed information about the services they offer: ".route('home').'?f='.$code;
                $this->line('Client ID: '.$user->id.' -- Client number: '.$number->number);
                TwilioUtils::send_SMS($number, $message, 'sms_new_profile_page');
                
            }

        }
    }
}

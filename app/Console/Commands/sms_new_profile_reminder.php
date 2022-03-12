<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\TwilioUtils;
use Illuminate\Console\Command;

class sms_new_profile_reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send_sms_psychic_without_update_profile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
         $day_updated = date('Y-m-d',strtotime(now(). '- 5 days')); 
         $models = User::select('user.*')
                       ->join('user_profile', 'user.id', '=', 'user_profile.user_id')
                       ->where('user.email_validated', 1)
                       ->where('user.id', '>', 2845)
                       //->where('user.email', 'km@collide.com')
                       ->where('user.role_id', '=', 1)
                       ->whereDate('user_profile.updated_at', '<', $day_updated)
                       ->get();
                 
         foreach ($models as $psychic) {
             
             $number = $psychic->user_mobile_nums()->first();
             if($number && $number->number != "" && !is_null($number->number) && !empty($number->number) && $number->validated){
                 $code = rand(1000, 99999);
                 $message = "Don’t miss out! Profiles that are not updated in the next week are at risk of being hidden from client view. Update now: ".route('psychic_profile').'?r='.$code;
                 $this->line('Model ID: '.$psychic->id.' -- Model number: '.$number->number);   
                 TwilioUtils::send_SMS($number, $message, 'sms_new_profile_page');
                             
             }
 
         }
    }
}

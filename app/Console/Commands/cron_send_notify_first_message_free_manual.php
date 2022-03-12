<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\TwilioUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class cron_send_notify_first_message_free_manual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cron_send_notify_first_message_free_manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to users after 24 hours register';

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
        $date = new \DateTime();
        date_sub($date, date_interval_create_from_date_string('22 days'));

        //$users = User::where('email_validated', 1)->where('role_id', 2)->whereDate('created_at', $date->format('Y-m-d'))->get();

         //send 1 day after signup and has not purchase credit-----------------------------------------------------------
         $users = User::where('user.email_validated', 1)
         ->where('user.test_user', 0)
         ->where('user.role_id', '=', WhiteLabel::roleId('User'))
         //->where('user.email', "devtelx1@gmail.com")
         ->whereDate('user.created_at', '<', $date->format('Y-m-d'))
         ->get(); 
        Log::info("-------------------- BEGIN cron_send_notify_first_message_free ----------------------------------");
        Log::info(count($users));
        foreach ($users as $user) {
            $this->line($user->email);
            Log::info($user->email);
            //Log::info($user->created_at);
            //$this->line($user->created_at);
            EmailUtils::send_email_to_users_after_one_day_after_register_first_message_free($user);
            //TwilioUtils::send_to_user_after_one_day_regiter_first_chat_free($user);
            //echo date('Y-m-d H:i:s') . " - " . $user->email . PHP_EOL;
        }
        Log::info("-------------------- END cron_send_notify_first_message_free ----------------------------------");
    }

}

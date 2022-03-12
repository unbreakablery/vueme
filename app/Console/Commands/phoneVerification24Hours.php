<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Services\EmailUtils;
use App\Services\TwilioUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class phoneVerification24Hours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:24_hour_phone_verification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Phone not verified after 24 hours of signup.';

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
        date_sub($date, date_interval_create_from_date_string('1 day'));

        $users =  User::select('user.*')->join('user_mobile_num', 'user_mobile_num.user_id', '=', 'user.id')
            ->where('test_user', 0)
            ->where('user_mobile_num.validated', 0)
            ->where('role_id', '=', WhiteLabel::roleId('User'))
            ->where('email_validated', 1)
            //->where('email', 'devtelx1@gmail.com')
            ->whereDate('user.created_at', '=', $date->format('Y-m-d'))
            ->get();


        foreach ($users as $user) {
            //$this->line($user->email);
            //$this->line($user->user_mobile_nums()->first()->number);
            $mobile = $user->user_mobile_nums()->first();
            if($mobile){
                TwilioUtils::send_verification_sms($mobile,$user, true);
            }
            
        }

    }
}

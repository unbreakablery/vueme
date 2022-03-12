<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\TwilioUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class sms_blast_users extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms_blast_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sms_blast_users';

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

        $users = User::where('user.role_id', '=', 2)->where('email_validated', 1)->where('id', '>', 4650)->get();
        //$users = User::where('user.role_id', '=', 2)->where('email', 'osnielcainzo@gmail.com')->get();

        foreach ($users as $user) {

            $number = $user->user_mobile_nums()->first();
            if($number && $number->number != "" && !is_null($number->number) && !empty($number->number)){
                $code = rand(1000, 99999);
                $message = "Respectfully is on TV! Watch our exclusive interview on ExtraTV tomorrow, and find our featured Models for your next reading respectfully.com/?m=".$code;
                TwilioUtils::send_SMS($number, $message, 'sms_blast_users');
                $this->line($user->id);
                $this->line($number->number);
            }

        }

    }
}

<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\TwilioUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class sms_blast_psychics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms_blast_psychics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sms_blast_psychics';

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

        $users = User::where('user.role_id', '=', 1)->where('email_validated', 1)->where('id', '>', 4503)->get();
        //$users = User::where('user.role_id', '=', 1)->where('email', 'osnielcainzo@gmail.com')->get();

        foreach ($users as $user) {
            $number = $user->user_mobile_nums()->first();
            if($number){
                $message = "Respectfully will be featured on ExtraTV tomorrow! Tune in for our exclusive interview and share the exciting news as we kickstart marketing in a big way!";
                TwilioUtils::send_SMS($number, $message, 'sms_blast_psychics');
                $this->line($number->number);
            }

        }

    }
}

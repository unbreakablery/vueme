<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\TwilioUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class sms_announcement_horoscope extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms_announcement_horoscope';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sms_announcement_horoscope';

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

        // $users = User::where('email_validated', 1)->get();
        $users = User::where('email_validated', 1)->where('id', '>', 74)->get();

            foreach ($users as $user) {
                $number = $user->user_mobile_nums()->first();

                if($number && $number->number != "" && !is_null($number->number) && !empty($number->number)){

                if($number->validated == 1) {
                    $message = "This is the sign you've been looking for... say hello to your Horoscope Hub! Get your free weekly horoscope on demand @Respectfully respectfully.com/horoscope";
                    TwilioUtils::send_SMS($number, $message);
                    $this->line($user->id.' => '.$number->number.' = Yes');
                    }
                }

            }

    }
}

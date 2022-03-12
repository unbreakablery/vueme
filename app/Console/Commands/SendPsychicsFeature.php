<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;
use App\Models\EmailAdminConfig;

class SendPsychicsFeature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send_psychics_feature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send top six models to user';

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
        $config = EmailAdminConfig::where('type', 'featured')->first();        

        //if ($config->date) {
            
            //$date = new Carbon('now', $config->timezone);

            //$date2 = new Carbon($config->date, $config->timezone);

           // if ( $date2->format('YmdHi') == $date->format('YmdHi') ) {

                $psychic = \collect($config->users)->filter(function($item){ return !isset($item['used']);})->first();

                foreach (User::where('email_validated', 1)
                ->where('test_user', 0)
                ->where('role_id', '=', WhiteLabel::roleId('User'))
                //->where('email', 'km@collide.com')
                ->get() as $user) {
                    $this->line($user->email);
                    EmailUtils::send_email_to_user_features_psychics($user, $config->subject, $psychic);
                }


                
            //}
       // }

    }
}

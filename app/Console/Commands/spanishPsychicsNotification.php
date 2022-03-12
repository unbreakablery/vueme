<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Billing\gwapi;
use App\Services\WebUtils;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use App\Models\UserCreditLog;
use App\Services\BillingUtils;
use App\Models\UserBillerEdata;
use Illuminate\Console\Command;
use App\Models\UserSubscriptionModel;
use Log;

class spanishPsychicsNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spanishPsychicsNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Spanish Models Notification';

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
        //list of models
        $models = User::where('email_validated', 1)->where('role_id', 1)->get();
        //$models = User::where('email_validated', 1)->where('role_id', 1)->where('email', 'osnielcainzo@gmail.com')->get();

        foreach ($models  as $user) {
            EmailUtils::spanish_psychics_send_to_all($user);
            echo date('Y-m-d H:i:s'). " - ".$user->email;
        }
    }
}

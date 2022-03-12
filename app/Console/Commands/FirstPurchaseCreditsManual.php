<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class FirstPurchaseCreditsManual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:purchase_credits_1_manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invite users to purchase credits';

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
        date_sub($date, date_interval_create_from_date_string('114 days'));


        //send 3 day after signup and has not purchase credit-----------------------------------------------------------
         $users = User::where('user.email_validated', 1)
         ->where('user.test_user', 0)
         ->where('user.role_id', '=', WhiteLabel::roleId('User'))
         ->whereDate('user.created_at', '<', $date->format('Y-m-d'))
         ->get();

        //$this->line($date->format('Y-m-d'));

        foreach ($users as $user) {
            $this->line($user->email);
            $this->line($user->created_at);
            //EmailUtils::day_3_purchase_credit($user);
        }

    }
}

<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class AfterRegister24Hour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:24_hour_after_register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'No logged in 30 day.';

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

        $users = User::where('email_validated', 1)
            ->where('test_user', 0)
            ->where('role_id', '=', WhiteLabel::roleId('Model'))
            //->where('email', 'devtelx1@gmail.com')
            ->whereDate('user.created_at', '=', $date->format('Y-m-d'))
            ->get();


        foreach ($users as $user) {
            //$this->line($user->email);
            EmailUtils::send_email_24_hour_after_register($user);
        }

    }
}

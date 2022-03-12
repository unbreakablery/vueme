<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class Specialties30Days extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:specialties_30_day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Specialties 30 Days.';

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
        date_sub($date, date_interval_create_from_date_string('30 days'));
        

      //  $users = User::where('email_validated', 1)
          $users = User::where('test_user', 0)
            ->where('role_id', '=', WhiteLabel::roleId('User'))
            ->where('fraud', 0)
            //->where('email', 'devtelx1@gmail.com')
            ->where('account_status', 'ACTIVE')
            ->where('email_validated', 1)
            ->whereDate('user.created_at', '=', $date->format('Y-m-d'))
            ->get();


        foreach ($users as $user) {
            $this->line($user->email);
            EmailUtils::send_email_to_specialties_30_days($user);
        }

    }
}

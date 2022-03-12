<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;
use App\Models\EmailAdminConfig;

class NoLogged30Days extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:no_logged_in_30_day';

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
        date_sub($date, date_interval_create_from_date_string('31 days'));

      //  $users = User::where('email_validated', 1)
      $users = User::where('test_user', 0)
            ->where('role_id', '=', WhiteLabel::roleId('User'))
            //->where('email', 'osnielcainzo@gmail.com')
            ->whereDate('user.last_log_in', '=', $date->format('Y-m-d'))
            ->get();
            $users2 = User::selectRaw('user.*')//->where('user.id', '=', 4560)->orWhere('user.id', '=', 8305)->orWhere('user.id', '=', 8284)
            ->orderBy('user.top_rating', 'DESC')->orderBy('user.featured', 'DESC')->limit(3)->get();

        foreach ($users as $user) {
            $this->line($user->email);
            EmailUtils::send_email_to_no_logged_30_days($user, $users2);
        }

    }
}

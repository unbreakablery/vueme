<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Day10ClientEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:10_day_after_client_register';

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
        $date = Carbon::now()->subDays(10);

        $users = User::join('user_profile', 'user.id', '=', 'user_profile.user_id')->where('email_validated', 1)
            ->where('test_user', 0)
            // ->where('email', 'devtelx1@gmail.com')
            ->where('role_id', '=', WhiteLabel::roleId('User'))
            //->whereDate('created_at', '=', $date->format('Y-m-d'))
            ->get();
        
        if(!empty($users)){
            
            $users2 = User::selectRaw('user.*')//->where('user.id', '=', 12634)->orWhere('user.id', '=', 4458)->orWhere('user.id', '=', 2096)
            ->orderBy('user.top_rating', 'DESC')->orderBy('user_profile.t_clients', 'DESC')->limit(3)->get();
    
            foreach ($users as $user) {
                $this->line($user->email);
                EmailUtils::send_email_10_day_after_client_register($user, $users2);
            }

        }

    }
}

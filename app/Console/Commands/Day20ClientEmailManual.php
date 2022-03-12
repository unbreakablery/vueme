<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Day20ClientEmailManual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:20_day_after_client_register_manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '20 days after signup.';

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
        $date = Carbon::now()->subDays(34);

        $users = User::where('email_validated', 1)
            ->where('test_user', 0)
            ->where('email', 'devtelx1@gmail.com')
            ->where('role_id', '=', WhiteLabel::roleId('User'))
            ->whereDate('created_at', '<=', $date->format('Y-m-d'))
            ->get();
        
        if(!empty($users)){    

            $users2 = User::selectRaw('user.*')
            ->where('user.id', '=', 2013)->orWhere('user.id', '=', 3847)->orWhere('user.id', '=', 4501)->orderBy('user.top_rating', 'DESC')->get()->all();
    
            foreach ($users as $user) {
                $this->line($user->email);
                $this->line($user->created_at);
                EmailUtils::send_email_20_day_after_client_register($user, $users2);
            }

        }

    }
}

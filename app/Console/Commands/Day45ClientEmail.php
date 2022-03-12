<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Day45ClientEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:45_day_after_client_register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '45 days after signup';

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
        $date = Carbon::now()->subDays(45);
        //$this->line($date);    
        $users = User::where('email_validated', 1)
            ->where('test_user', 0)
            //->where('email', 'devtelx1@gmail.com')
            ->where('role_id', '=', WhiteLabel::roleId('User'))
            ->whereDate('user.created_at', '=', $date->format('Y-m-d'))
            ->get();
        
        if(!empty($users)){    

            $users2 = User::selectRaw('user.*')->join('user_category', 'user.id', '=', 'user_category.user_id')->join('category', 'category.id', '=', 'user_category.category_id')
            //->where('user.id', '=', 2049)->orWhere('user.id', '=', 873)->orWhere('user.id', '=', 228)
            ->where('category.slug', 'medium')->orderBy('user.top_rating', 'DESC')->limit(3)->get();
    
            foreach ($users as $user) {
                $this->line($user->email);
                EmailUtils::send_email_45_day_after_client_register($user, $users2);
            }

        }

    }
}

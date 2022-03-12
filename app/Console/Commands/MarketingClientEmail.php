<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarketingClientEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:marketing:client';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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

        $users = User::select('user.*')
            ->where('user.email_validated', 1)
            ->where('user.test_user', 0)
            ->where('user.role_id', '=', WhiteLabel::roleId('User'))
            //->where('user.email', 'km@collide.com')
            ->get();
        
        if(!empty($users)){
    
            foreach ($users as $user) {
                $this->line($user->email);
                EmailUtils::send_email_marketing_client($user);
            }

        }

    }
}

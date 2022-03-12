<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;
use App\Models\EmailAdminConfig;
use App\Models\HoroscopeInfo;
use Illuminate\Support\Facades\DB;

class testOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:one';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Test One';

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

        $users = User::where('test_user', 0)
        //->where('role_id', '=', WhiteLabel::roleId('User'))
        //->where('fraud', 0)
        ->where('email', 'jessica@collide.com')
        //->where('email_validated', 1)
        ->get();

      

        foreach ($users as $user) {
            $this->line($user->email);
            EmailUtils::send_referral_email($user);
        }

      
    }
}

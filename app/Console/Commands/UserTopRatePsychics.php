<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;
use App\Models\EmailAdminConfig;

class UserTopRatePsychics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send_psychics_top_rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send top four models to user';

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

        $config = EmailAdminConfig::where('type', 'top-rated')->first();        

        //if ($config->date) {
            
            //$date = new Carbon('now', $config->timezone);

            //$date2 = new Carbon($config->date, $config->timezone);

            //if ( $date2->format('YmdHi') == $date->format('YmdHi') ) {

                $users = User::selectRaw('user.*, review.id as review')->join('review', 'review.psychic_id', '=', 'user.id')
                 ->whereIn('review.id', \collect($config->users)->map(function($item){return $item['review'];}))->get()->all();

                foreach (User::where('email_validated', 1)
                ->where('test_user', 0)
                //->where('email', 'km@collide.com')
                ->where('role_id', '=', WhiteLabel::roleId('User'))
                ->get() as $user) {
                    $this->line($user->email);
                    EmailUtils::send_email_to_user_top_rate_psychics($user, $config->subject, $users);
                }
                

            //}
        //} 

      
    }
}

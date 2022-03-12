<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\WhiteLabel;

class ChangeRepteDisplayNameAndProfileLInk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_display_name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Blog Email';

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
        ->join('user_profile', 'user.id', '=', 'user_profile.user_id')
        ->where('user.role_id', '=', WhiteLabel::roleId('Model'))
        //->where('user.email', 'km@collide.com')
        ->get();
        $cont = 0;
      
            foreach ($users as $user) {
                
                    $userProfile =  $user->userProfile;
                   
                    $userProfile->profile_link = "model_".$cont;
                    $userProfile->display_name = "Model_".$cont;
                    $userProfile->save();
                    $this->line("Model_".$cont);
                    $this->line($cont);
                    $cont++;
            }
       

       

    }
}

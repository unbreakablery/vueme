<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PsychicProfileMissingDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:psychic_profile_missing_details';

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

        $users = User::select('user.*')->join('user_profile', 'user.id', '=', 'user_profile.user_id')
            ->where('user.email_validated', 1)
            ->where('user.test_user', 0)
            //->where('email', 'gino@collide.com')
            ->where('user.role_id', '=', WhiteLabel::roleId('Model'))
            ->whereRaw('(user_profile.intro_video_path IS NULL OR user_profile.intro_audio_path IS NULL OR user_profile.haedshot_path IS NULL OR user_profile.cover_path IS NULL)')
            ->get();
        
        if(!empty($users)){
    
            foreach ($users as $user) {
                $this->line($user->email);
                EmailUtils::send_email_psychic_profile_missing_details($user);
            }

        }

    }
}

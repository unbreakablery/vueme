<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Models\Review;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class SetUserFiveRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_five_rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Count how many five rating each user has and save it in top_rating user' field.";

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

        $users = User::select('user.*')->join('review', 'review.psychic_id', '=', 'user.id')
        ->join('user_profile', 'user.id', '=', 'user_profile.user_id')
        ->join('user_service', 'user_service.user_id', '=', 'user.id')
        ->where('review.status', 'Posted')
        ->where('user.email_validated', 1)
        ->where('user.test_user', 0)
        ->where('user.role_id', '=', WhiteLabel::roleId('Model'))
        ->where('user_profile.haedshot_path', '!=', '')
        ->where('user.profile_percent', '!=', 0)
        ->where('user_service.active', '!=', 0)->distinct()->get();
        

        foreach ($users as $user) {
            //$this->line($user->id);
            $user->top_rating = Review::where('psychic_id', $user->id)->where('status', 'Posted')->where('rating', 5)->where('psychic_id', '!=', 4458)->count();
            $user->save();
        }

    }
}

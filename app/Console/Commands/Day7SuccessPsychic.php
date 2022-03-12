<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class Day7SuccessPsychic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:7daysSuccess';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '7 Days Success.';

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
        date_sub($date, date_interval_create_from_date_string('7 days'));

      //  $users = User::where('email_validated', 1)
          $users = User::where('test_user', 0)
            ->where('role_id', '=', WhiteLabel::roleId('Model'))
            ->where('fraud', 0)
            ->where('email', 'devtelx1@gmail.com')
            ->where('account_status', 'ACTIVE')
            ->where('email_validated', 1)
            //->whereDate('user.created_at', '=', $date->format('Y-m-d'))
            ->get();
            $images = [1,2,3];
            $titles = ['An Intro Video Makes Your Profile Shine', 'Make Your Tagline Memorable', 'Your Profile Even Shows on Google Search'];
            $texts = ['Clients love a little face-to-face before booking a reading. Plus, intro media means you get priority visibility (and more clients!).', 'Summing yourself up in a 50 character phrase isn’t easy, but makes a world of difference in how many clients end up on your page (grab their attention!).', 'This means when someone searches your Respectfully™ display name, they’ll see your elevator pitch and even click right through to your profile!'];
            


        foreach ($users as $user) {
            $this->line($user->email);
            EmailUtils::send_email_to_psychics__7days($user, $images, $titles, $texts);
        }

    }
}

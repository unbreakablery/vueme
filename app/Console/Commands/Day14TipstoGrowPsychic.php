<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class Day14TipstoGrowPsychic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:14daysTips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '14 Days Tips.';

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
        date_sub($date, date_interval_create_from_date_string('14 days'));

      //  $users = User::where('email_validated', 1)
          $users = User::where('test_user', 0)
            ->where('role_id', '=', WhiteLabel::roleId('Model'))
            //->where('email', 'devtelx1@gmail.com')
            ->where('fraud', 0)
            ->where('account_status', 'ACTIVE')
            ->whereDate('user.created_at', '=', $date->format('Y-m-d'))
            ->get();
            $images = [1,2,3];
            $titles = ['Send a Better Message', 'Reviews Get More Views', 'Offer Specialty Reading Up-Sells'];
            $texts = ['Chat readings are most popular, but don’t pack a full reading in one message. Respond in detail, keep asking questions and offer a follow up reading.', 'At the end of each reading, ask Clients to write you a review if they enjoyed your spiritual guidance. Reviews showcase all your stamps of approval.', 'Include details in your profile Background section or mention special services in a chat reading. It’s an easy up-sell!'];
           
        foreach ($users as $user) {
            $this->line($user->email);
            EmailUtils::send_email_to_psychics__14days($user, $images, $titles, $texts);
        }

    }
}

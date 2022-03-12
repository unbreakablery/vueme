<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;

class BlogEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:blog_email';

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
        foreach (User::where('user.email_validated', 1)->where('user.test_user', 0)->where('user.fraud', 0)->whereRaw("( user.role_id = ? OR user.role_id = ? )", [WhiteLabel::roleId('Model'), WhiteLabel::roleId('User')])->get() as $user) {
            EmailUtils::send_blog_email($user);
            // $this->line($user->email);
        }

    }
}

<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use App\Models\User;
use App\Services\EmailUtils;
use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class SendCreditsOffer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:creditsOffer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Credits Offer to Clients';

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

       $users = User::where('role_id', 2)->get();


        foreach ($users as $user){
            EmailUtils::send_to_clients_credits_offer($user);
        }

    }
}

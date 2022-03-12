<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate User Subscriptions';

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
        $users = User::where('role_id', 1)->get();

        foreach ($users as $user) {
            $subscription = new Subscription();
            $subscription->user_id = $user->id;
            $subscription->name = "Subscription";
            $subscription->save();

            $subscription = new Subscription();
            $subscription->user_id = $user->id;
            $subscription->name = "Snapchat Subscription";
            $subscription->type = "SNAPCHAT";
            $subscription->status = 0;
            $subscription->price = 15;
            $subscription->save();
        }
    }
}

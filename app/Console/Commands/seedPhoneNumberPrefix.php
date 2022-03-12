<?php

namespace App\Console\Commands;

use App\Models\Country_all;
use App\Models\UserMobileNum;
use Illuminate\Console\Command;

class seedPhoneNumberPrefix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phoneNumberPrefix:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Phone Number Prefix';

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
        $numbers = UserMobileNum::whereNull('prefix')->get();

        foreach ($numbers as $number){
            if($number->code2){
                $country  = Country_all::where('code2', $number->code2)->first();
                $number->prefix = $country->prefix;
                $number->save();
            }

        }
    }
}

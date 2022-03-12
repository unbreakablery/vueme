<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Services\EmailUtils;
use App\Services\TwilioUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class phoneWeeklyHoroscopeSign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:phone_weekly_horoscope_sign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly Horoscope Sign.';

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
        
        $users = DB::select('SELECT us.number, us.country_code,us.name, us.birth_date, hz.id as sign, LOWER(hz.name) as zodiac
        FROM user_horoscope us,horoscope_zodiac_signs hz
        where DATE_FORMAT(us.birth_date,"%m/%d") BETWEEN hz.start_period and hz.end_period
        and us.number is not null
        ');


        foreach ($users as $user) {
                $this->line($user->number);
                TwilioUtils::phone_weekly_horoscope_sign_sms($user);
        }

    }
}

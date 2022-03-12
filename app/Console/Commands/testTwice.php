<?php
//01/08/2020 12:24
namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Console\Command;
use App\Models\EmailAdminConfig;
use App\Models\HoroscopeInfo;
use Illuminate\Support\Facades\DB;

class testTwice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:twice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Test Twice';

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

    public function dateF($data,$format,$ini = 'Y-m-d'){
        $date = new \DateTime();
        $date = $date::createFromFormat($ini,trim($data));
        return $date->format($format);
        
    }




    public function handle()
    {



 
        $users = DB::select('SELECT us.email,us.name, us.birth_date, hz.id as sign, hz.name as zodiac
        FROM user_horoscope us,horoscope_zodiac_signs hz
        where DATE_FORMAT(us.birth_date,"%m/%d") BETWEEN hz.start_period and hz.end_period
        and us.email is not null and us.email = "usmjesus@gmail.com"
        ');

        
        $weeks = HoroscopeInfo::
        leftJoin('horoscope_zodiac_signs', 'horoscope_info.horoscope_zodiac_signs_id', '=', 'horoscope_zodiac_signs.id')
        ->get();


       $signs = array();
       foreach($weeks as $week){
           
        $signs[$week->horoscope_zodiac_signs_id]['id'] = $week->horoscope_zodiac_signs_id;
        $signs[$week->horoscope_zodiac_signs_id]['name'] = $week->name;
        $signs[$week->horoscope_zodiac_signs_id]['url'] = strtolower($week->name);
        $signs[$week->horoscope_zodiac_signs_id]['text'] = $week->content;
        $signs[$week->horoscope_zodiac_signs_id]['date'] = $this->dateF($week->start_period,'M d','m/d')." - ".$this->dateF($week->end_period,'M d','m/d');

         }


        $subject = " here is what's in the stars for you this week...";

        foreach ($users as $user) {
            $this->line($user->email);
            EmailUtils::weekly_horoscope_sign_email($user, 'Send Test Twice', $signs[$user->sign]);
        }

      
    }
}

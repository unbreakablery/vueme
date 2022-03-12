<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Services\EmailUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HoroscopeAdminConfig;
use App\Models\HoroscopeZodiacSigns;
use App\Models\HoroscopeInfo;
use App\Models\UserHoroscope;

use App\Services\ApiUtils;

class HoroscopeController extends Controller
{
    public function getHoroscopeConfig(){

        $config = null;

        if($config = HoroscopeAdminConfig::first()){
            
            if($date = $config->date ){
                if($config->timezone){
                    $date = new Carbon($date, $config->timezone);
                    $now = new Carbon('now', $config->timezone);
                }
                else{
                    $config->timezone = 'America/Los_Angeles';
                    $config->save();
                    $now = new Carbon();
                    $date = new Carbon($date);
                }

                if($date < $now){
                    
                    $config->date = null;
                    $config->save();
                }
            }
        }

        $signs = HoroscopeZodiacSigns::all();

        if($signs->count() == 0){
            foreach ($this->signs as $key => $value) {
                $signs->push(HoroscopeZodiacSigns::create($value));
            }
        }
        
        return response()->json(['timezones' => \timezone_identifiers_list(), 'config' => $config, 'signs' => $signs]);


    }

    public function saveHoroscopeConfig(Request $request){

        if(!($config = HoroscopeAdminConfig::first())){
            $config = new HoroscopeAdminConfig();
        }

        $config->emails = $request->emails;
        $config->subject = $request->subject;
        $config->timezone = $request->timezone;
        
        if($request->date || $request->time){
          $config->date = new Carbon($request->date . " " . $request->time);//new \DateTime($request->date . " " . $request->time, new \DateTimeZone($request->timezone ?? date_default_timezone_get()));
        }
        $config->save();
        
        return response()->json(['config' => $config]);

    }

    public function updateHoroscopeInfo(Request $request){


        $this->validate($request, [
            'horoscope_zodiac_signs_id' => 'required|integer',
            'start_week' => 'required|date',
            'end_week' => 'required|date',
            'match_id1' => 'required|integer',
            'match_id2' => 'required|integer',
            'match_id3' => 'required|integer',
            'subject1' => 'required|string',
            'subject2' => 'required|string',
            'subject3' => 'required|string',
            'hustle' => 'required|integer',
            'love' => 'required|integer',
            'outlook' => 'required|integer',
            'vibe' => 'required|integer',

        ]);




            $input = $request->all();

        // HoroscopeInfo::find($input['id'])->update($input);


        $info = HoroscopeInfo::find($input['id']);

        $info->horoscope_zodiac_signs_id = $request->horoscope_zodiac_signs_id;
        if($request['start_week']){
            $date = new \DateTime($request['start_week']);
            $start_week  = $date->format('Y-m-d');
        }
        
        $info->start_week = $start_week;


        if($request['end_week']){
            $date = new \DateTime($request['end_week']);
            $end_week  = $date->format('Y-m-d');
        }
        $info->end_week = $end_week;


        $info->match_id1 = $request->match_id1;
        $info->subject1 = $request->subject1;
        $info->match_id2 = $request->match_id2;
        $info->subject2 = $request->subject2;
        $info->match_id3 = $request->match_id3;
        $info->subject3 = $request->subject3;
        $info->content = $request->content;
        $info->hustle = $request->hustle;
        $info->love = $request->love;
        $info->outlook = $request->outlook;
        $info->vibe = $request->vibe;

        if($info->update()){
            
            return ApiUtils::response_success('Horoscope saved', 200);
        }


        return ApiUtils::response_fail(['message'=> 'Something wrong'], 400);
        

    }


    public function archiveHoroscopeInfo(Request $request){
        
        $input = $request->all();
        $info = HoroscopeInfo::find($input['id']);
        $info->archived = $request->archived == 0 ? '1': '0';
        
        if($info->update()){
            return ApiUtils::response_success('Horoscope saved'.$input['id'], 200);
        }

        return ApiUtils::response_fail(['message'=> 'Something wrong'], 400);

    }

    public function saveHoroscopeInfo(Request $request)
    {



        $this->validate($request, [
            'horoscope_zodiac_signs_id' => 'required|integer',
            'start_week' => 'required|date',
            'end_week' => 'required|date',
            'match_id1' => 'required|integer',
            'match_id2' => 'required|integer',
            'match_id3' => 'required|integer',
            'subject1' => 'required|string',
            'subject2' => 'required|string',
            'subject3' => 'required|string',
            'hustle' => 'required|integer',
            'love' => 'required|integer',
            'outlook' => 'required|integer',
            'vibe' => 'required|integer',

        ]);




        $info = new HoroscopeInfo();
        $info->horoscope_zodiac_signs_id = $request->horoscope_zodiac_signs_id;
        if($request['start_week']){
            $date = new \DateTime($request['start_week']);
            $start_week  = $date->format('Y-m-d');
        }
        
        $info->start_week = $start_week;


        if($request['end_week']){
            $date = new \DateTime($request['end_week']);
            $end_week  = $date->format('Y-m-d');
        }
        $info->end_week = $end_week;


        $info->match_id1 = $request->match_id1;
        $info->subject1 = $request->subject1;
        $info->match_id2 = $request->match_id2;
        $info->subject2 = $request->subject2;
        $info->match_id3 = $request->match_id3;
        $info->subject3 = $request->subject3;
        $info->content = $request->content;
        $info->hustle = $request->hustle;
        $info->love = $request->love;
        $info->outlook = $request->outlook;
        $info->vibe = $request->vibe;

        if($info->save()){
            
            return ApiUtils::response_success('Horoscope saved', 200);
        }

            return ApiUtils::response_fail(['message'=> 'Something wrong'], 400);

        
        


        
        
    }

    public function dateF($data,$format,$ini = 'Y-m-d'){
        $date = new \DateTime();
        $date = $date::createFromFormat($ini,trim($data));
        return $date->format($format);
        
    }

    public function sendEmail(Request $request){

        if($config = HoroscopeAdminConfig::first()){
            
            foreach (\explode(',', $config->emails) as $email) {

                $email = str_replace(' ', '', $email);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                  }

                if(!($user = User::where('email', $email)->first())){

                 if($user = User::where('test_user', 1)->first())
                  $user->email = $email;
                  else{
                    $user = User::first();
                    $user->email = $email;
                  } 
                  $user->userProfile->name = 'Test Name';
                }
                $date = new Carbon();
                $month = $date->format('F');
                $day = $date->format('d');
                
                $signs = HoroscopeZodiacSigns::get();


                

                //$subject = $config->subject ? $config->subject . "| Week of $month $day" : "Week of $month $day";

                
                $weeks = HoroscopeInfo::
                // ->where('horoscope_info.horoscope_zodiac_signs_id',1)
                 leftJoin('horoscope_zodiac_signs', 'horoscope_info.horoscope_zodiac_signs_id', '=', 'horoscope_zodiac_signs.id')
                ->whereDate('horoscope_info.start_week','<=', date('Y-m-d', strtotime('next tuesday')))
                ->whereDate('horoscope_info.end_week','>=', date('Y-m-d', strtotime('next tuesday')))
                ->orderBy('horoscope_info.horoscope_zodiac_signs_id')
                ->get();


                if(!$weeks){

                    $weeks = HoroscopeInfo::
                    // ->where('horoscope_info.horoscope_zodiac_signs_id',1)
                     leftJoin('horoscope_zodiac_signs', 'horoscope_info.horoscope_zodiac_signs_id', '=', 'horoscope_zodiac_signs.id')
                    ->whereDate('horoscope_info.start_week','<=', date('Y-m-d'))
                    ->whereDate('horoscope_info.end_week','>=', date('Y-m-d'))
                    ->orderBy('horoscope_info.horoscope_zodiac_signs_id')
                    ->get();

                }


                $signs = array();
                foreach($weeks as $week){
                
                    $index = ($week->horoscope_zodiac_signs_id-1);
                    $signs[$index]['id'] = $week->horoscope_zodiac_signs_id;
                    $signs[$index]['name'] = $week->name;
                    $signs[$index]['text'] = $week->content;
                    $signs[$index]['date'] = "(".$this->dateF($week->start_period,'M d','m/d')." - ".$this->dateF($week->end_period,'M d','m/d').")";
                }

                
                
                
                $subject = $signs ? 'Your Weekly Horoscope | '.$this->dateF($weeks[0]->start_week,'F d, Y') : 'Your Weekly Horoscope';


                 //EmailUtils::weekly_hroscope_email($user, ($config->subject ?? 'Your Weekly Horoscope') . " | Week of $month $day", $signs);
                 EmailUtils::weekly_hroscope_email($user, $subject, $signs);
            }
        }
        
        return response('sent');

    }


    public function sendSignEmail(Request $request){

        
        if($config = HoroscopeAdminConfig::first()){
            
            foreach (\explode(',', $config->emails) as $email) {

                $email = str_replace(' ', '', $email);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    continue;
                  }

                if(!($user = User::where('email', $email)->first())){

                 if($user = User::where('test_user', 1)->first())
                  $user->email = $email;
                  else{
                    $user = User::first();
                    $user->email = $email;
                  } 
                  $user->userProfile->name = 'Test Name';
                }
                $date = new Carbon();
                $month = $date->format('F');
                $day = $date->format('d');
                
                $signs = HoroscopeZodiacSigns::get();


                
                $week = HoroscopeInfo::
                 leftJoin('horoscope_zodiac_signs', 'horoscope_info.horoscope_zodiac_signs_id', '=', 'horoscope_zodiac_signs.id')
                ->where('horoscope_info.horoscope_zodiac_signs_id',$request->id)
                ->whereDate('horoscope_info.start_week','<=', date('Y-m-d'))
                ->whereDate('horoscope_info.end_week','>=', date('Y-m-d'))
                ->get()->first();

                if(!$week){


                    $week = HoroscopeInfo::
                    leftJoin('horoscope_zodiac_signs', 'horoscope_info.horoscope_zodiac_signs_id', '=', 'horoscope_zodiac_signs.id')
                    ->where('horoscope_info.horoscope_zodiac_signs_id',$request->id)
                    ->get()->first();

                }


                    $signs = array();
                    $signs['id'] = $week->horoscope_zodiac_signs_id;
                    $signs['name'] = $week->name;
                    $signs['url'] = strtolower($week->name);
                    $signs['text'] = $week->content;
                    $signs['date'] = $this->dateF($week->start_period,'M d','m/d')." - ".$this->dateF($week->end_period,'M d','m/d');

                $subject = " here is what's in the stars for you this week...";

                 EmailUtils::weekly_horoscope_sign_email($user, $subject, $signs);
            }
        }
        
        return response('sent');

    }

    public function saveHoroscopeSigns(Request $request){

        $input = $request->all();

        HoroscopeZodiacSigns::find($input['id'])->update($input);
        
        return response('saved');

    }


    public function deleteHoroscopeInfo(Request $request){

        
        HoroscopeInfo::find($request['id'])->delete();
        return response('ok');

    }


    public function deleteUserHoroscope(Request $request){

        
        UserHoroscope::find($request['id'])->delete();
        return response('ok');

    }

    private $signs = [
        [
        'name' => 'Aries',
        'text' => 'Pressure will be exerted one way or another for you to get something sorted in an orderly manner. This might mean you should consider whether it would generate greater peace of mind to let go of certain commitments. There may be some way of altering the way matters have been structured to open up greater opportunity.'
        ],
        [
            'name' => 'Taurus',
            'text' => 'Opportunities could arise without warning that will enable you to turn something around in relation to a matter, which is an important priority. Don’t be tempted to take outlandish risks, as that will not be necessary. Instead, you need to look at what should be let go, especially if you have been disappointed with its results.'
        ],
        [
            'name' => 'Gemini',
            'text' => 'You could feel bombarded when it comes to the expectations of others, particularly if they have any authority, when it comes to what you may need to restructure. You may wonder if they are clear on the position they are taking. There could be an unexpected turnaround. Don’t let frustration tempt you to spend unnecessarily.'
        ],
        [
            'name' => 'Cancer',
            'text' => 'You could realise you have made greater progress than you imagined since 8th August when it comes to your dealings with others. You will discover that lines of communication have opened up dramatically, so don’t be backward in putting your ideas forward this week. You are very ready to cope with any niggling annoyances.'
        ],
        [
            'name' => 'Leo',
            'text' => 'A good time to scrutinize where your money goes and perhaps get rid of unnecessary spending that adds up when you look into it. Don’t be too quick to change something that has represented security because a more exciting alternative pops up. You need to look into the details very thoroughly to see the whole picture.'
        ],
        [
            'name' => 'Virgo',
            'text' => 'Stay focussed on changes you want to make in the long term and put any pressure from the expectations of others to one side. You could begin to realise that somebody else is not as certain as they may have seemed. A sense of being on the right track with whatever has required your focus since 20th August is guiding you.'
        ],
        [
            'name' => 'Libra',
            'text' => 'You could see the sense in getting rid of aspects of something that has been in place for quite a while, especially if generates more balance with commitments you need to handle. This may not make somebody else happy but that is not your problem. In truth it could come down to more freedom for you rather than them.'
        ],
        [
            'name' => 'Scorpio',
            'text' => 'Any sudden changes involving somebody else could seem exciting to begin with. However there can be more to them than is evident which could disrupt things in the future running smoothly for you. This will test you to remain focussed on matters of importance to you without being tempted to take an unrealistic view.'
        ],
        [
            'name' => 'Sagittarius',
            'text' => 'You could get a more stable result from somebody else simply because you demand it. They might have to realise you are serious. This can open up the opportunity to discuss commitments. If something doesn’t suit you, don’t let it slide – you should confront it straight away and work through any difficulties it might initially generate.'
        ],
        [
            'name' => 'Capricorn',
            'text' => 'A greater sense of stability can become established between you and somebody else, giving you a better view of future possibilities. It could ease any lack of clarity or uncertainties you have had. It might mean you need to embrace something out of the ordinary but there is no reason as to why you cannot enjoy the experience.'
        ],
        [
            'name' => 'Aquarius',
            'text' => 'There can be a turning point when it comes to what is important to get in place and establish. This can include home or family matters. You could realise you need to be more forthright with your ideas and what you have to say, especially if finances are involved. You may not get an instant response but that isn’t the priority.'
        ],
        [
            'name' => 'Pisces',
            'text' => 'The Full Moon this week occurs in your sign that can bring a turnaround with any matters that have been in play or developing over the last 18 months. You could now make some decisions you never thought would be the case. This could be encouraged by support you know is there where other people are concerned.'
            ]
    ];

    
}

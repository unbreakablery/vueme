<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Review;
use App\Services\EmailUtils;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;
use App\Models\EmailAdminConfig;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\PsychicEmailAdminResource;

class EmailController extends Controller
{
    public function getTopRateConfig(){

        $config = null;

        if($config = EmailAdminConfig::where('type', 'top-rated')->first()){
            
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

        // $users = User::select('user.*')//->join('review', 'review.psychic_id', '=', 'user.id')
        // ->join('user_profile', 'user_profile.user_id', '=', 'user.id')
        // ->whereNotNull('user_profile.cover_path')->whereNotNull('user_profile.haedshot_path')
        // ->whereNotNull('user_profile.description')->where('user.account_status', 'ACTIVE')
        // ->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)
        // ->groupBy('user.id')->distinct();
        
        return response()->json(['timezones' => \timezone_identifiers_list(), 'config' => $config ?? [ 'timezone' => 'America/Los_Angeles'] ]);


    }

    public function getUserForSelect(Request $request){

        $users = User::select('user.*')->join('review', 'review.psychic_id', '=', 'user.id')
        ->join('user_profile', 'user_profile.user_id', '=', 'user.id')
        ->whereNotNull('user_profile.cover_path')->whereNotNull('user_profile.haedshot_path')
        ->whereNotNull('user_profile.description')->where('user.account_status', 'ACTIVE')
        ->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)
        ->groupBy('user.id')->distinct();

        return  PsychicEmailAdminResource::collection($users->paginate(100));
    }

    public function saveTopRateConfig(Request $request){

        $config = EmailAdminConfig::firstOrNew(['type' => 'top-rated']);

        $config->emails = $request->emails;
        $config->subject = $request->subject;
        $config->timezone = $request->timezone;
        
        if($request->date || $request->time){
          $config->date = new Carbon($request->date . " " . $request->time);//new \DateTime($request->date . " " . $request->time, new \DateTimeZone($request->timezone ?? date_default_timezone_get()));
        }

        $config->users = $request->users;
        $config->save();
        
        return response()->json(['config' => $config]);

    }

    public function sendEmailTopRate(Request $request){

        if($config = EmailAdminConfig::where('type', 'top-rated')->first()){

            $users = User::selectRaw('user.*, review.id as review')->join('review', 'review.psychic_id', '=', 'user.id')
            ->whereIn('review.id', \collect($config->users)->map(function($item){return $item['review'];}))->get()->all();

            
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

                  EmailUtils::send_email_to_user_top_rate_psychics($user, $config->subject ?? 'Top Rated Models', $users);
            }
        }
        
        return response('sent');

    }

    public function getFeaturedConfig(){

        // $users = User::select('user.*')->join('user_profile', 'user_profile.user_id', '=', 'user.id')->join('review', 'review.psychic_id', '=', 'user.id')
        // ->whereNotNull('user_profile.cover_path')->whereNotNull('user_profile.haedshot_path')
        // ->whereNotNull('user_profile.description')->where('user.account_status', 'ACTIVE')
        // ->where('user.fraud', 0)->where('user.test_user', 0)->where('user.email_validated', 1)
        // ->where('user.role_id', WhiteLabel::roleId('Model'))->groupBy('user.id')->distinct();

        $config = null;

        if($config = EmailAdminConfig::where('type', 'featured')->first()){
            
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

                // if(!empty($config->users)){
                //     $ids = \collect($config->users)->filter(function($item){return isset($item['used']);})->map(function($item){ return $item['id'];});
                //     $users->whereNotIn('user.id', $ids);
                // }
        }

        return response()->json(['timezones' => \timezone_identifiers_list(), 'config' => $config ?? [ 'timezone' => 'America/Los_Angeles'] ]);
    }

    public function saveFeaturedConfig(Request $request){

        $config = EmailAdminConfig::firstOrNew(['type' => 'featured']);

        $config->emails = $request->emails;
        $config->subject = $request->subject;
        $config->timezone = $request->timezone;
        
        if($request->date || $request->time){
          $config->date = new Carbon($request->date . " " . $request->time);
        }
 
        
           $used = \collect($config->users)->filter(function($item){ return isset($item['used']);})->all();
           $data = $request->users[0];
           $data['description'] = \str_limit($data['description'], 100);
           $config->users = \array_merge([$data], $used);
        
        $config->save();
        
        return response()->json(['config' => $config]);

    }

    public function sendEmailFeatured(Request $request){

        if($config = EmailAdminConfig::where('type', 'featured')->first()){

            $psychic = \collect($config->users)->filter(function($item){ return !isset($item['used']);})->first();
            
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

                  EmailUtils::send_email_to_user_features_psychics($user, $config->subject ?? 'Featured Model of the Week!', $psychic);
            }
        }
        
        return response('sent');

    }

    

    
}

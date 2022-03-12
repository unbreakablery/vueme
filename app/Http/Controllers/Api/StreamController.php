<?php namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\ApiUtils;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class StreamController extends Controller {

    public function __construct()
    {
        $this->middleware('auth:api');       
        $this->middleware('verifield');
        $this->middleware('role:1')->except(['collect_channel_user']);
       
    }
    public function create_channel(Request $request){

        $user = Auth::user();
        $channel_still_live = $user->appointments()->where('status','LIVE')->first();

        if(!$channel_still_live){
            $channel = uniqid(ApiUtils::generate_token());
               $channel_still_live = $user->appointments()->create([                    
                'service_id' => 2,
                'status' => 'LIVE',
                'channel' => $channel
        ]);
        }
       
        $diaplay_name = $user->userProfile->display_name;  
        //Send notification to user is live
        $user->is_streaming_live = 1;
        $user->appointment_live = $channel_still_live->id;
        $user->save();     

        return [
            'status' => true,
            'channel' =>  route('live_stream',['channel'=>$channel_still_live->channel,$diaplay_name])            
        ];
        
    }
    public function end_channel($channel, Request $request){
        $user = Auth::user();
        $users_id = $request->collect;
        $channel_still_live = $user->appointments()->where('status','LIVE')->where('channel',$channel)->first();
        if(!$channel_still_live){
            return ApiUtils::response_fail('Live Not Found');
        }
        $channel_still_live->channel_live_collect($users_id);
        $channel_still_live->end_channel_live();

        return ApiUtils::response_success(true);
    }
    public function collect_channel($channel,Request $request){
        $user = Auth::user();
       
        $users_id = $request->collect;       
        $channel_still_live = $user->appointments()->where('status','LIVE')->where('channel',$channel)->first();
        if(!$channel_still_live){
            return ApiUtils::response_fail('Live Not Found');
        }
        $channel_still_live->channel_live_collect($users_id);
        return ApiUtils::response_success(true);

    }
    public function collect_channel_user($channel){

        $user = Auth::user();       
        $users_id = [$user->id];       
        $channel_still_live = Appointment::where('status','LIVE')->where('channel',$channel)->first();
        if(!$channel_still_live){
            return ApiUtils::response_fail('Live Not Found');
        }
        $byUser = true;
        $channel_still_live->channel_live_collect($users_id, $byUser);
        return ApiUtils::response_success(true);

    }
    
    
  

  

}

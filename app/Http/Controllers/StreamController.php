<?php

namespace App\Http\Controllers;

use App\Http\Resources\v1\PsychicResource;
use App\Models\Appointment;
use App\Models\AppointmentUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AgoraUtils;

class StreamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');      
        $this->middleware('verifield');
        $this->middleware('verifyphone');
    }
    public function live_stream($display_name,$channel) {        

        $user = Auth::user();       
        $live_stream = Appointment::where('status','LIVE')->where('channel',$channel)->first();        
        if (is_null($user) || is_null($live_stream)) {
            return $user->role_id == 1 ? redirect("/dashboard") : redirect("/".$display_name);
        }        
        if(!$user->has_access($live_stream)){
            //Show information subscribe o something
            return $user->role_id == 1 ? redirect("/dashboard") : redirect("/".$display_name); 
        }
        AppointmentUsers::add_user_appointment_streaming($user,$live_stream); 

        $token_rtc = AgoraUtils::generate_access_token_agora_rtc($live_stream,$user);
        $token_rtm = AgoraUtils::generate_access_token_agora_rtm($live_stream,$user);
       //$token_rtm = '';
        $profile_bio = substr($user->user_profile->description, 0, 157) . '...';
        return view('frontend.live')->with(['profile_bio' => $profile_bio,'profile_name' => $user->user_profile->display_name,'channel'=>$channel,'token'=>$token_rtc,'token_rtm'=>$token_rtm,'model'=>new PsychicResource($live_stream->psychic)]);
        
    }
    public function on_publish(Request $request) {
        $user = User::select('user.id')
        ->where('user.streaming_key', "=", $request->name)
        ->get()->first();
        if ($user && $user->id) {
                $user->is_streaming_live = true;
                $user->save();
                return response('Good', 200)->header('Content-Type', 'text/plain');
        } else {
                return response('No', 400)->header('Content-Type', 'text/plain');
        }
    }
}
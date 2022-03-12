<?php namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Services\ChatAuth;
use App\model_chat_show;
use App\Models\fan_chat_room;
use App\Models\model_chat_room;
use App\Models\User;
use App\Models\Review;
use App\Models\user_1_1_chat_request;
use App\Services\ChatRoomUtils;
use App\Services\NotificationUtils;
use App\Services\WhiteLabel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\v1\UserChatRequestResource;

use App\Events\VideoPrivateSent;
use App\Events\ModelAcceptTokboxChat;
use App\Events\ModelCancelsTokboxChat;
use App\Events\FanCancelsTokboxChat;
use App\Events\NotificationsInAppEvent;
use App\Events\PsychicCheckIsInReadingProgress;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\v1\ChatResource;
use App\Services\ApiUtils;
use App\Services\EmailUtils;
use App\Services\TwilioUtils;


use App\Http\Resources\v1\UserCreditLogsResourceCollection;
use App\Models\Appointment;
use App\Models\chat;
use App\Models\chat_in;
use App\Models\UserCreditLog;
use App\Models\UserOpinion;
use App\Services\NotificationsInAppUtils;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller {

    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api')->except('verifyUser');
        $this->middleware('verifield');
        $this->auth = $auth;
    }

    public function credits() {
        return $this->response_success(['credits' => Auth::user()->credits]);
    }


    public function saveFavorite(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|integer',
            'type'=> 'required|string'
        ]);

        $user = Auth::user();
        $user = User::find($user->id);

        if(!($model = User::find($request->id))){
            return response(['message'=> 'invalid model id'], 400);
        }

        //save model
        if($request->type == "save"){
            $data_count = DB::table("user_favorite_psychics")
            ->select("psychic_id")
            ->where("user_id",$user->id)
            ->where("psychic_id",$model->id)
            ->get();
            if(count($data_count) ==0){
                $user->favorites()->attach($model->id);
            }
        }elseif ($request->type == "remove"){
            $user->favorites()->detach($model->id);
            $data_count = DB::table("user_favorite_psychics")
            ->where("user_id",$user->id)
            ->where("psychic_id",$model->id)
            ->delete();
        }


        return response(['message'=> 'Done'], 200);

    }

    
    public function getfavoritiessuer(Request $request){
        $user = Auth::user();
        $data = DB::table("user_favorite_psychics")
        ->where("user_id",$user->id)->pluck('psychic_id')
        ->toArray();
        return array("data"=>$data);
    }

    public function saveHelpfuls(Request $request)
    {

        $this->validate($request, [
            'id' => 'required|integer',
            'type'=> 'required|string'
        ]);

        $user = Auth::user();
        $id =  $request->input('id');
        $type =  $request->input('type');

        $model = Review::where('id', '=', $id)->first();

        if(is_null($model)){
            return response(['message'=> 'invalid model id'], 400);
        }

        //save model
        if($type == "save"){
            $user->helpfuls()->attach($model->id);
            $model->helpful = $model->helpful + 1;
            $model->save();
        }elseif ($type == "remove"){
            $user->helpfuls()->detach($model->id);
            $model->helpful = $model->helpful - 1; 
            $model->save();
        }
        


        return response(['message'=> 'Model was successfully saved'], 200);

    }

    public function user_credit_logs(){

        
        $credit_logs =  Auth::user()->user_credit_logs()->orderBy('created_at','DESC')->get();
      
        $logs = new UserCreditLogsResourceCollection($credit_logs);
        return $logs;
    }

    public function vchat_request($slug, $service_id, Request $request){

        $model = User::getModelByIdOrDisplayName($slug, null);

        if (!$model){
            return $this->response_fail('Invalid model_id.',200);
        }

        //verify if service is available
        $chat_service = $model->userService()->where('service_id', '=', $service_id)->first();

        if (!$chat_service->active) {
            return $this->response_fail($model->userProfile()->first()->display_name.' is not available for video chat.',200);
        }

        /*if ($request->has('duration')){
            $duration=$request->get('duration');
        } else {
            $duration = WhiteLabel::config('chat_1_1')->video_chat_1_1_default_minutes;
        }*/

        $duration = $chat_service->min_duration;
        $max_duration  = $chat_service->get_available_time();

        $data = ['model'=>$model
            ,'user'=>Auth::user()
            ,'duration'=> $duration
            ,'service_id'=> $service_id
            ,'max_minutes'=> $max_duration
            ,'rate'=> $chat_service->rate
        ];

        $result = user_1_1_chat_request::vchat_request($data);

        if (empty($result[0])) {
            return $this->response_fail($result[1],200);
        }     
      
        broadcast(new VideoPrivateSent($result[1]))->toOthers();
        //NotificationUtils::vchat_1_1_requested(Auth::user(),$model);

        return $this->response_success( $result[1], 200 );

    }

    public function vchat_request_with_appointment($slug, $service_id, $appointment_id, Request $request) {

        $model = User::getModelByIdOrDisplayName($slug, null);

        if (!$model){
            return $this->response_fail('Invalid model_id.',200);
        }

        //verify if service is available
        $chat_service = $model->userService()->where('service_id', '=', $service_id)->first();

        if (!$chat_service->active) {
            return $this->response_fail($model->userProfile()->first()->display_name.' is not available for video chat.',200);
        }

        /*if ($request->has('duration')){
            $duration=$request->get('duration');
        } else {
            $duration = WhiteLabel::config('chat_1_1')->video_chat_1_1_default_minutes;
        }*/

        $duration = $chat_service->min_duration;
        $max_duration  = $chat_service->get_available_time();

        $data = ['model'=>$model
            ,'user'=>Auth::user()
            ,'duration'=> $duration
            ,'service_id'=> $service_id
            ,'max_minutes'=> $max_duration
            ,'rate'=> $chat_service->rate
            ,'appointment_id' => $appointment_id
        ];

        $result = user_1_1_chat_request::vchat_request($data);

        if (empty($result[0])) {
            return $this->response_fail($result[1],200);
        }        
         EmailUtils::send_to_psychic_when_user_request_service($result[1]['request'], 'now');
         TwilioUtils::send_sms_to_psychic_request_now_received($result[1]['request'], 'now');
         broadcast(new VideoPrivateSent($result[1]))->toOthers();
        //NotificationUtils::vchat_1_1_requested(Auth::user(),$model);

        return $this->response_success( $result[1], 200 );

    }

    public function vchat_request_cancel($slug, Request $request){

        $model = User::getModelByIdOrDisplayName($slug, null);
      
        if (!$model){
            return $this->response_fail('Invalid model_id.',200);
        }
       

        $data = ['model_id'=>$model->id
            ,'user_id'=>Auth::user()->id           
        ];

        $result = user_1_1_chat_request::where($data)->whereIn('state',['ENQUEUED','WAITING'])->first();

       
        if ($result) {
            $result->cancel();
            model_chat_room::where($data)->whereIn('state',['WAITING'])->update(['state'=>'CANCELLED']);
            $result->canceled_by = Auth::user()->id;
            $result->save();
            NotificationsInAppUtils::f_to_psychic_when_user_canceled_request($result, 'psychic');

            broadcast(new FanCancelsTokboxChat( new UserChatRequestResource( $result )  ))->toOthers();
        }else{
            return $this->response_fail('Invalid request.',200);
        }
        
       
        return $this->response_success(['message' => "The chat request was cancelled"],200);
       // return $this->response_success();


    }

    public function vchat_available(){

        $user = Auth::user();

        $available_rooms = user_1_1_chat_request::user_requests($user);

        if ($available_rooms->count()<=0)
        {
            return $this->response_success('No chats available');
        }

        $rooms = [];

        foreach ($available_rooms as $available_room)
        {

            $model_chat_room = $available_room->model_chat_room;
            $model = $available_room->model;
            if (!$model_chat_room || !$model){
                return $this->response_fail('Error in locating chat room');
            }
            $session_id = $model_chat_room->tokbox_session_id;
            $options = [
                'profile_name' => $model->userProfile()->first()->profile_name
                ,'model_id' => $model->id
                ,'user_id' => $available_room->user_id
                ,'credits_per_minute' => $model_chat_room->credits_per_minute
                ,'minutes_minimum' => $model_chat_room->minutes_minimum
                ,'minutes_requested' => $available_room->minutes_requested
            ];

            $token = ChatRoomUtils::get_token($session_id,$options);
            if (!$token[0]){
                return $this->response_fail($token[1]);
            } else {
                $token = $token[1];
            }


            $fan_chat_room = fan_chat_room::where([
                'user_id' => $user->id
                ,'model_chat_room_id'=>$model_chat_room->id
            ])->first();

            if (!$fan_chat_room )
            {
                $fan_chat_room = fan_chat_room::create([
                    'user_id'            => $user->id
                    ,'model_chat_room_id' => $model_chat_room->id
                    ,'tokbox_user_token' => $token
                    ,'state'             => 'WAITING'
                ]);

                if (!$fan_chat_room){
                    return $this->response_fail('Error in connection to chat room');
                }

            }

            $rooms[]=[
                'model_id'=>$available_room->model_id
                ,'session_id'=>$model_chat_room->tokbox_session_id
                ,'token'=>$token
                ,'model_chat_room_id' => $model_chat_room->id
                ,'user_chat_room_id' => $fan_chat_room->id
            ];

            $available_room->state = $model_chat_room->state = 'WAITING';
            $available_room->save();
            $model_chat_room->save();
        }

        return $this->response_success($rooms);

    }

    public function vchat_end($user_chat_room_id){
        $chat_killed = fan_chat_room::end_chat($user_chat_room_id);
        if (!$chat_killed[0]){
            return $this->response_fail($chat_killed[1],200);
        }

        return $this->response_success($chat_killed[1]);
    }

    public function vchat_extend($user_chat_room_id,$minutes){
        $chat_extended = fan_chat_room::extend_chat($user_chat_room_id,$minutes);
        if (!$chat_extended[0]){
            return $this->response_fail($chat_extended[1],200);
        }

        return $this->response_success($chat_extended[1]);
    }

    public function model_vchat_start($chat_request_id){
        $model = Auth::user();
        $model_id = $model->id;

        $user_1_1_chat_request = user_1_1_chat_request::where('id',$chat_request_id)->first();
//      Log::debug(print_r($user_1_1_chat_request,true));

        if (!$user_1_1_chat_request){
            return $this->response_fail("No enqueued chat request with that id $chat_request_id",200);
        }

       
        $user = $user_1_1_chat_request->user;
        $max_minutes = $user_1_1_chat_request->max_minutes;
        $minimum_minutes = $user_1_1_chat_request->minimum_minutes;
        $rate = $user_1_1_chat_request->rate;

        $chat_service = $model->userService()->where('service_id', '=', $user_1_1_chat_request->service_id)->first();

        if(!$chat_service->active){
            return [false,WhiteLabel::config('star')->alias." is not available for video chat."];
        }

        $chat_room_res = model_chat_room::create_model_chat_room(
            ['model_id'=>$model_id
                ,'user'=>$user
                ,'minutes_max'=>$max_minutes
                ,'minimum_minutes'=>$minimum_minutes
                ,'rate'=>$rate
            ]);
        if (!$chat_room_res[0]) {
            return $this->response_fail($chat_room_res[1],200);
        }
        $chat_room = $chat_room_res[1];

        // Update the request to let user know the creator is waiting.
        $user_1_1_chat_request->state = 'WAITING';
        $user_1_1_chat_request->model_chat_room_id = $chat_room['model_chat_room']->id;
        $user_1_1_chat_request->save();

        $appointment = $user_1_1_chat_request->appointment;
        $appointment->status = 'Confirmed';
        $appointment->save();

        $out = [];
        $out['request_id'] = $user_1_1_chat_request->id;
        $out['session_id'] = $chat_room['model_chat_room']->tokbox_session_id;
        $out['token'] = $chat_room['model_chat_room']->tokbox_model_token;
        $out['model_chat_room_id'] = $chat_room['model_chat_room']->id;
        $out['service_id'] = $user_1_1_chat_request->service_id;
        $out['model_id'] = $model_id;

        
        broadcast(new PsychicCheckIsInReadingProgress($model)); 
        broadcast(new ModelAcceptTokboxChat( new UserChatRequestResource($user_1_1_chat_request)  ))->toOthers();
        EmailUtils::send_to_user_when_psychic_is_ready_to_initiate_service($user_1_1_chat_request);
        TwilioUtils::send_sms_psychic_is_ready_to_initiate_service($user_1_1_chat_request);


        // NotificationUtils::vchat_1_1_star_joined($user,$model,Auth::user());

        return $this->response_success($out);
    }

    public function model_vchat_request_cancel($chat_id, Request $request)
    {
        $model_id = Auth::user()->id;

        $data = [
            'id'      => $chat_id,
            'model_id' => $model_id,
            'state'   => 'ENQUEUED',
        ];

        $result = user_1_1_chat_request::where($data)->first();
        
        if ($result && $result->cancel())
        {
            
            $result->canceled_by = $model_id;
            $result->save();
            $data = NotificationsInAppUtils::f_to_user_when_psychic_canceled_request_or_expired($result,'user','canceled');
            //broadcast(new ModelCancelsTokboxChat( new UserChatRequestResource( $result )  ))->toOthers();
            
            
            //EmailUtils::send_to_user_when_psychic_is_ready_to_initiate_service($result);
            //TwilioUtils::send_sms_to_user_when_psychic_appointment_cancel($result);
            return $this->response_success("Cancelled request $chat_id");
        } else {
            return $this->response_fail("Invalid chat id $chat_id",200);
        }

        return $this->response_fail("Error in cancelleing 1-1 chat request $chat_id");
    }

    public function model_vchat_end($model_chat_room_id){
        $star = Auth::user();
       
        $chat_killed = model_chat_room::end_chat($model_chat_room_id, $star);

        if (!$chat_killed[0]){
            return $this->response_fail($chat_killed[1],200);
        }

        $model_room=model_chat_room::find($model_chat_room_id);       
        broadcast(new ModelCancelsTokboxChat( new UserChatRequestResource( $model_room->user_1_1_chat_request )  ))->toOthers();
        return $this->response_success($chat_killed[1]);
    }
    public function removeNotifications(Request $request){

        $user = Auth::user();

        
        if($request->type == 'to_psychic_user_canceled_request'){
          
            $result = $user->modelChatRequests()->where('id','=',$request->notification_id)->first();            
            if($result){
                $result->canceled_notify_view = 1;
                $result->save();                
            }  
        }
        if($request->type == 'to_psychic_schedule_appointment_cancelled'){
          
            $result = $user->appointments()->where('id','=',$request->notification_id)->first();            
            if($result){
                $result->canceled_notify_view = 1;
                $result->save();                
            }  
        }
        if($request->type == 'to_user_model_confirm_appointment'){
          
            $result = $user->user_appointments()->where('id','=',$request->notification_id)->first();            
            if($result){
                $result->confirmation_view = 1;
                $result->save();                
            }  
        }
        if($request->type == 'expired_request'){
          
            $result = $user->userChatRequests()->where('id','=',$request->notification_id)->first();            
            if($result){
                $result->user_view_expired = 1;
                $result->save();                
            }  
        } 
        if($request->type == 'to_psychic_request_expired'){
          
            $result = $user->modelChatRequests()->where('id','=',$request->notification_id)->first();            
            if($result){
                $result->psychic_view_expired = 1;
                $result->save();                
            }  
        } 
        if($request->type == 'to_psychic_online_rules'){
          
            $user->online_rules_view = 1;  
            $user->save();         
            
        } 
        

        if($request->type == 'to_all_announcement'){
          
            $user->online_announcement_view = 1;  
            $user->save();         
            
        } 
        
                
        




        if($request->type == 'schedule_appointment'){
          
            $appointment = $user->appointments()->where('id','=',$request->notification_id)->first();            
            if($appointment){
                $appointment->psychic_notifiacion_view = 1;
                $appointment->save();                
            }  
        }
        

        if($request->type == 'model_canceled_request'){
          
            $result = $user->userChatRequests()->where('id','=',$request->notification_id)->first();            
            if($result){
                $result->canceled_notify_view = 1;
                $result->save();                
            }  
        }
       
        if($request->type == 'model_canceled_appointment'){
          
            $result = $user->user_appointments()->where('id','=',$request->notification_id)->first();            
            if($result){
                $result->canceled_notify_view = 1;
                $result->save();                
            }  
        }

       
        
        //model_canceled_request 

        return response()->json(['ok']); 
    
    }
    public function getNotifications(){

        $user = Auth::user();
                //return  $user->getUserNotificationsAttribute();
        return [
            'userNotifications' => $user->getUserNotificationsAttribute(), 
            'userChatNotifications'=> $user->getUserChatRequestsAttribute(),
            'psychicChatNotifications'=>$user->getModelChatRequestsAttribute()];
        }
        public function sent_opinion_after_service(Request $request){

            $this->validate($request, [              
                'room'=> 'required|exists:fan_chat_room,id',
                'opinion' => ['required', Rule::in(["POSITIVE", "NEGATIVE"])],
            ]);
            $user = Auth::user();

            $fan_chat_room = $user->user_chat_room()->where(['id'=>$request->room,'user_id'=>$user->id])->first();
            if (!$fan_chat_room) {
                return ApiUtils::response_fail("User Not Found");
            }

            $user_opinion = UserOpinion::create([
                'opinion'=>$request->opinion,
                'fan_chat_room_id'=>$request->room,
                'user_id'=> $user->id]);
            if($user_opinion){
                return ApiUtils::response_success('opinion');
            }
            return ApiUtils::response_fail(); 
           
        }    

        public function sendTip(Request $request)
        {
          $input = $request->all();
          $user = Auth::user();
    
            if(! $user->check_credits($input['credits'], true)){
                return $this->response_success(['error' => [false, ['message'=> 'Not enough credits']]]);
            }
    
    
          $credit_log = new UserCreditLog(array_merge($request->all(), ['user_id' => $user->id, 'action' => 'Tip'])); 
          $credit_log->save();
    
          $user->credits = $user->credits - $input['credits'];
          $user->save();
    
          $result = $this->save_tip_as_message($request);
           
          //TwilioUtils::send_sms_to_fan_when_send_tip($credit_log);
         
          return $this->response_success(['success',$result], 200);
        }
        private function save_tip_as_message(Request $request){
    
    
            $user = Auth::user();  
            $chat  = new chat();
            $chat->receiver_id = $request->model_id;
            $chat->ip = WhiteLabel::getIpAddress();
            $receiver = User::where('id',$chat->receiver_id)->first();
            if(!$receiver){
                return ApiUtils::response_fail('Not Allowed');
            }
    
            $chat->message = $request->credits;
            $chat->type = 'TIP';           
            $chat_in = chat_in::where([['user_id', '=', $user->id],['receiver_id','=',$chat->receiver_id]])->first(); 
            if($chat_in){
                // Update the "updated_at" column only
                $chat_in->touch();
            }else{
                $chat_in = chat_in::create(array('user_id' => $user->id,'receiver_id' => $chat->receiver_id));
            }          
            
            $user->chats()->save($chat);        
    
            $chat_resource = new ChatResource($chat->load('user'));      
            
            NotificationsInAppUtils::f_show_tip_notify_in_app_and_in_chat($chat_resource); 
            return $chat_resource;
           
        }



}

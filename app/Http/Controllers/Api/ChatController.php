<?php

namespace App\Http\Controllers\Api;

use DB;
use Exception;
use App\Models\chat;
use App\Models\User;
use App\Events\SMSChat;
use App\Models\chat_in;
use App\Services\ApiUtils;
use App\Models\UserService;
use App\Services\WhiteLabel;
use Illuminate\Http\Request;
use App\Models\UserCreditLog;
use App\Services\TwilioUtils;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\MediaPurchaseUtils;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Events\MessageChatPrivateSent;
use App\Http\Resources\v1\ChatResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Events\MessageChatAddNotifications;
use App\Events\MessageChatRemoveNotifications;
use App\Http\Resources\v1\UserBasicChatResource;
use App\Http\Resources\v1\ChatResourceCollection;
use App\Http\Resources\v1\UserBasicChatResourceCollection;

class ChatController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->middleware('auth:api');
        $this->auth = $auth;
    }
   public function index(Request $request,User $user){


            $page = $request->page; 
            if($request->offset == 0){

       $receiver_id = $user->id;
       $privateMessages= chat::with('user')
           ->where(['user_id'=> auth()->id(), 'receiver_id'=> $receiver_id])
           ->orWhere(function($query) use($receiver_id){
               $query->where(['user_id' => $receiver_id, 'receiver_id' => auth()->id()]);
           })->orderByDesc('id')

           ->paginate(10);

       $this->read_messages($user);
           broadcast(new MessageChatRemoveNotifications());


       return new ChatResourceCollection($privateMessages);

   }else{
       $offset = ((10 * ($page - 1)) +  $request->offset);


       $receiver_id = $user->id;
       $privateMessages= chat::with('user')
           ->where(['user_id'=> auth()->id(), 'receiver_id'=> $receiver_id])
           ->orWhere(function($query) use($receiver_id){
               $query->where(['user_id' => $receiver_id, 'receiver_id' => auth()->id()]);
           })->orderByDesc('id')
           ->skip($offset)
           ->limit(10)->get();

       $this->read_messages($user);
       return new ChatResourceCollection($privateMessages);

   }

   }


   function get_messages_from_search(Request $request){
      
                $text = $request->text;
                $user  = Auth::user();
                $chat= chat::where('id','=',$request->id)->first();              


                $privateMessages= chat::with('user')
                ->where(['user_id'=> $chat->user_id, 'receiver_id'=> $chat->receiver_id])
                ->orWhere(function($query) use($chat){
                    $query->where(['user_id' => $chat->receiver_id, 'receiver_id' => $chat->user_id]);
                });    
                
                $messages =  $privateMessages->orderByDesc('chat.id')->get();
                $to_return = $messages->reject(function($value, $key){       
                     return $value->chat_in()->blocked;
                });  
               

                return new ChatResourceCollection($to_return);
   }
   
  public function get_search_messages(Request $request){

    
    $text = $request->text;
    $id = $request->id;
    $user  = Auth::user();
    $chat = chat::where(['id'=>$id])->get();

    $privateMessages= chat::with('user')
    ->where([
        ['chat.user_id','=', $user->id],
        ['chat.message','<>',null],
        ['chat.message','like','%'.$text.'%']
        ])
        
        ->orWhere([
        ['chat.receiver_id','=', $user->id],
        ['chat.message','<>',null],
        ['chat.message','like','%'.$text.'%']]);
       
    $messages =  $privateMessages->orderByDesc('chat.id')->get();
    $to_return = $messages->reject(function($value, $key){       
         return $value->chat_in()->blocked;
    });  

    return new ChatResourceCollection($to_return);
  }


   public function update(chat $chat){
       $chat->view = 1;
       $chat->save();
       return ApiUtils::response_success(null,\Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
   }
    public function users(){

           $user = Auth::user();
           $users = $user->users_to_chat()->get();
          
        return new UserBasicChatResourceCollection($users);      

    }
    public function store(Request $request){


        $user = Auth::user();  
        $chat  = new chat();
        $chat->receiver_id = $request->receiver;
        $chat->ip = WhiteLabel::getIpAddress();
        $receiver = User::where('id',$chat->receiver_id)->first();
        $service = new UserService();


        if(!$receiver){
            return ApiUtils::response_fail('Not Allowed');
        }
        if(!$receiver->email_validated){
            $name = $receiver->role_id == 2 ? $receiver->UserProfile->name : $receiver->UserProfile->display_name;
            return ApiUtils::response_fail($name.' is not accepting new messages');
        }

        if($user->isPsychic()){
            
            $service = UserService::where([
                ['user_id','=',$user->id],
                ['service_id','=',2],
                ['active','=',1],
            ])->first();        

            if(!$service){               
                return ApiUtils::response_fail('You do not have this service enabled.');
            }
        }

                   

                          

        if($user->isUser()){

            $chat_in_check = chat_in::where([['user_id', '=' ,$user->id],['receiver_id', '=', $receiver->id]])->first();
            if(!$chat_in_check){
                return ApiUtils::response_fail('Not Allowed');
            } 
               
                $service = UserService::where([
                            ['user_id','=',$receiver->id],
                            ['service_id','=',2],
                            ['active','=',1],
                        ])->first();

                if(!$service || $service->rate === NULL){
                    $displayName = $receiver->getUserProfileAttribute()->display_name;
                    return ApiUtils::response_fail($displayName .' does not have this service enabled.');
                } 

                // $last_chat_user = chat::where(
                //     [['user_id', '=',$user->id],            
                //     ['receiver_id','=',$chat->receiver_id]])
                //     ->whereIn('type',['TEXT','IMAGE','AUDIO','VIDEO'])
                //     ->first();
        
                //  if(!$last_chat_user){
                //     if($request->has('file')){
                //         return ApiUtils::response_fail('Not Allowed');       
                //     }               
                //     return $this->save_first_message($request);
                //  }

               

        }  
        
        $last_chat_aux = chat::where([['user_id', '=', $user->id],['receiver_id','=',$chat->receiver_id]])
        ->latest('id')->first();

        $last_end_chat= chat::with('user')
           ->where(['user_id'=> $user->id, 'receiver_id'=> $chat->receiver_id])
           ->orWhere(function($query) use($chat,$user){
               $query->where(['user_id' => $chat->receiver_id, 'receiver_id' => $user->id]);
           })->latest('id')->first();
       
        if($last_chat_aux && $last_chat_aux->type == 'TEXT' && $request->text && $last_chat_aux->id == $last_end_chat->id){
           

            $message_seending = strtolower(str_replace(' ', '', $request->text));
            $last_message = strtolower(str_replace(' ', '', $last_chat_aux->message));

            if($message_seending == $last_message){

                $last_chat_aux->status = "DUPLICATED";
                $user->chats()->save($last_chat_aux);               
                return new ChatResource($last_chat_aux->load('user'));
            }                     
        } 
        
        $user_credit_log = new UserCreditLog();
        $credit_log = false;
        if($user->isUser()){
     // if($user->isUser() && !$receiver->chat_free){              


            if($user->credits < $service->rate){
                $last_chat_user = chat::where(
                    [['user_id', '=',$user->id],            
                    ['receiver_id','=',$chat->receiver_id]])
                    ->whereIn('type',['TEXT','IMAGE','AUDIO','VIDEO'])
                    ->first();
        
                //  if(!$last_chat_user){
                //     if($request->has('file')){
                //         return ApiUtils::response_fail('Not Allowed');       
                //     }               
                //     return $this->save_first_message($request);
                //  }
                 return Response::json(['error' => 'buy credits', 
                                        'data' => null,
                                       'firstMessage' => !((bool) $last_chat_user),
                                       'buyCreditOpcion' => $user->BuyCredits['buyCreditOpcion']], 400);
                // return ApiUtils::response_fail('buy credits');
            }            

            $user_credit_log = new UserCreditLog();
            $user_credit_log->site_id = WhiteLabel::site_id();
            $user_credit_log->credits = $service->rate;
            $user_credit_log->action = 'Chat';
            $user_credit_log->service_id = 2;
            $user_credit_log->credits_old = $user->credits;
            $user_credit_log->psychic_id = $receiver->id;
            $user->user_credit_logs()->save($user_credit_log);
            $credit_log = true;

        
            Log::info('From chat message -- User credit old: $'.$user->credits. ' Chat service rate: $'.$service->rate.' User ID:'.$user->id);
            $user->credits -= $service->rate;

            
            $chat->min_to_expire = $this->min_to_expire($receiver);


            

        }else{
            $chat->free_message = 1;
        }


       if($request->has('file')){

           $mime = $request->file->getClientMimeType();
           $type = MediaPurchaseUtils::mime_to_type($mime); 
            if($type != 'IMAGE' && $type != 'AUDIO'){              
                $type = 'VIDEO';
            }

           $filename = Storage::disk('text_chat')->put($user->id,$request->file);           
           $chat->image = $filename;
           $chat->type = $type;

       }else{
           $chat->message = $request->text;
           $chat->type = "TEXT";
       }
        // Retrieve the model

        if($user->isUser()){
            $user_id = $user->id;
            $receiver_id = $chat->receiver_id;

        }else{
            $user_id = $chat->receiver_id;                              
            $receiver_id = $user->id;
        }
       
        $chat_in = chat_in::where([['user_id', '=' ,$user_id],['receiver_id', '=', $receiver_id]])->first();
        // Update the "updated_at" column only
        if($chat_in){
            $chat_in->touch();   
        }
          
        $last_chat = null;
        if($last_chat_aux){
             $last_chat = clone($last_chat_aux);
        }                   
       
        $user->chats()->save($chat);
        $user->save();
        Log::info('From chat message -- User credit new: $'.$user->credits.' User ID:'.$user->id);
        if($credit_log){
            $user_credit_log->chat_id= $chat->id;
            $user_credit_log->save();
        }
        
        $resource = new ChatResource($chat->load('user'));
        $userResource = new UserBasicChatResource($user);
        broadcast(new MessageChatPrivateSent($resource))->toOthers();
        broadcast(new MessageChatAddNotifications($userResource,$chat->receiver_id))->toOthers();
        event(new SMSChat($chat,$last_chat)); 

        return $resource;      
    }
    public function get_notifications(){
        $users = User::select('user.*')
        ->join('chat', 'user.id','=','chat.user_id')

        ->where([
            ['chat.view','=',0],
            ['chat.receiver_id','=',Auth::user()->id]
        ])->distinct()->get();

    return new UserBasicChatResourceCollection($users);
    }
    public function user_chat_leave(User $user){
        $user->last_chat_utc = gmdate("Y-m-d\TH:i:s\Z");
        $user->save();
        return ApiUtils::response_success(null,\Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT);
    }
    public function check_first_message(Request $request){
        $user = Auth::user();
        $chats = $user->chats()->where(['receiver_id'=>$request->receiver])->first();
        return $chats ? "true" : "false";
    }
    // public function save_first_message(Request $request){


    //     $user = Auth::user();  
    //     $chat  = new chat();
    //     $chat->receiver_id = $request->receiver;
    //     $chat->ip = WhiteLabel::getIpAddress();
    //     $receiver = User::where('id',$chat->receiver_id)->first();
    //     if(!$receiver){
    //         return ApiUtils::response_fail('Not Allowed');
    //     }
    //     if(!$receiver->email_validated){
    //         $name = $receiver->role_id == 2 ? $receiver->UserProfile->name : $receiver->UserProfile->display_name;
    //         return ApiUtils::response_fail($name.' is not accepting new messages');
    //     }

       
    //     $last_chat_aux = chat::where([['user_id', '=', $user->id],['receiver_id','=',$chat->receiver_id]])
    //     ->latest('id')->first();

    //      if($last_chat_aux ){
    //         return ApiUtils::response_fail('Not Allowed');
    //      }


    //         if($user->isUser() && !$receiver->chat_free){
    //             $service = UserService::where([
    //                 ['user_id','=',$receiver->id],
    //                 ['service_id','=',2],
    //                 ['active','=',1],
    //             ])->first();
    
    //             if(!$user->isUser() || !$service || $service->rate === NULL){
    //                 $displayName = $receiver->getUserProfileAttribute()->display_name;
    //                 return ApiUtils::response_fail($displayName .' does not have this service enabled.');
    //             } 
    
    //         }
    //         $chat->min_to_expire = $this->min_to_expire($receiver);
    //         $chat->message = $request->text;
    //         $chat->free_message = 1;
    //         $chat->type = 'TEXT';           
    //         $chat_in = chat_in::where([['user_id', '=', $user->id],['receiver_id','=',$chat->receiver_id]])->first(); 
    //         if($chat_in){
    //             // Update the "updated_at" column only
    //             $chat_in->touch();
    //         }else{
    //             $chat_in = chat_in::create(array('user_id' => $user->id,'receiver_id' => $request->receiver));
    //         }          
           
    //         $user->chats()->save($chat);




    //         $resource = new ChatResource($chat->load('user'));
    //         $userResource = new UserBasicChatResource($user);
    //         broadcast(new MessageChatPrivateSent($resource))->toOthers();
    //         broadcast(new MessageChatAddNotifications($userResource,$chat->receiver_id))->toOthers();
    //         TwilioUtils::send_sms_to_psychic_first_message_new_chat($chat); 
             
    //         return ['first_chat',$resource];
       
    // }


    private function read_messages($sender){


        $result = chat::where([['view','=',0],['receiver_id','=',auth()->id()],['user_id','=',$sender->id]])->update(['view'=>1]);

        return $result;
    } 
    private function min_to_expire($receiver){

        $min_to_expire = 1440;
            if($receiver->online){                
               
                if($receiver->is_reading_in_progress()){
                    $min_to_expire = 120; 
                }else{
                    $min_to_expire = 30;
                }
            }
            return $min_to_expire;
    }  
}

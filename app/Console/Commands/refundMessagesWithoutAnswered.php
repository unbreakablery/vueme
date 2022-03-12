<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\User;
use App\Models\chat;
use App\Models\refund;
use App\Services\WhiteLabel;
use App\Models\UserCreditLog;
use App\Services\TwilioUtils;
use DB;
use Illuminate\Support\Facades\Log;

class refundMessagesWithoutAnswered extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:refund_messages_without_answered';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refund to Fan messages without answered from Model in 8 hours';

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
       
 
        $query = User::query()->select('user.*')
        ->where('user.role_id','=',2);
        $query->join('chat_in','chat_in.user_id','=','user.id')->groupBy('user.id');  
        echo 'Start'.   ' Date: '.date('Y/m/d h:m:s').  PHP_EOL;
        //Fans with messages sents
        $fans = $query->get();
        foreach($fans as $fan){

            //echo 'inside Fans'.  PHP_EOL;
          $models =  $fan->users_to_chat()->get();
           foreach($models as $model){
            //echo 'inside models'.  PHP_EOL;
            $last_chat= chat::where(['user_id'=> $fan->id, 'receiver_id'=> $model->id])
            ->orWhere(function($query) use($fan,$model){
                $query->where(['user_id' => $model->id, 'receiver_id' => $fan->id]);
            })->latest('id')->first();           

            // 24 hours
            $min_to_expire = 1440;
            $date = new \DateTime();
            if($last_chat && $last_chat->min_to_expire){  
                //minutes to expire, we saved it when chat is created            
                $min_to_expire = $last_chat->min_to_expire;              
            }
            date_sub($date, date_interval_create_from_date_string($min_to_expire.' minutes'));          

            if($last_chat && !$last_chat->refunded && $last_chat->user->isUser() && $last_chat->created_at->lt($date) && $last_chat->user_credit_log) 
            {

                $privateMessages= chat::where(['user_id'=> $fan->id, 'receiver_id'=> $model->id])
                ->orWhere(function($query) use($fan,$model){
                    $query->where(['user_id' => $model->id, 'receiver_id' => $fan->id]);
                })->orderByDesc('id')->get(); 
                // echo $last_chat->created_at.  PHP_EOL;
                // echo print_r($date).  PHP_EOL;

                //echo 'Inside if is mas de 8 horas'.  PHP_EOL;

                 
                   $new_refund = new refund();
                    //echo 'inside si tiene mas de un menssage'.  PHP_EOL;+
                    $i = 0;
                    foreach($privateMessages as $chat){

                        // print_r($chat->user_credit_log);
                        // echo "dddd".PHP_EOL;
                        if($chat->user->isUser() && !$chat->refunded){
                           
                            if($chat->user_credit_log){
                                 $credit_log = $chat->user_credit_log;
                                $credits = $credit_log->credits;
                                $credit_log->refunded  = true;
                                $credit_log->save(); 


                                $user_fan = User::where(['id'=>$fan->id])->first();

                                echo 'User Credit Log Id: '.$chat->user_credit_log->id.' Old Credit Fan: '.$user_fan->credits. ' Chat id: '.$chat->id.' ---User Id: '.$user_fan->id. ' ---Credits: '.$credits. ' Date: '.date('Y/m/d h:m:s').  PHP_EOL;
                               
                                          
                                $new_refund->name= 'CHAT';
                                $new_refund->save();
                                $chat->refund_id = $new_refund->id;
                                $chat->refunded = date('Y-m-d H:i:s');
                                if($chat->receiver->online){
                                    $chat->expired_online = 1;
                                }


                                $chat->save();
                                $user_credit_log = new UserCreditLog();
                                $user_credit_log->site_id = WhiteLabel::site_id();
                                $user_credit_log->credits = $credits;
                                $user_credit_log->action = 'REFUND';
                                $user_credit_log->service_id = 2;
                                $user_credit_log->credits_old = $user_fan->credits;
                                $user_credit_log->psychic_id = $model->id;
                                $user_credit_log->chat_id = $chat->id;                               

                                $fan->user_credit_logs()->save($user_credit_log);
                                
                                Log::info('From refundMessagesWithoutAnswered -- User credit old: $'.$user_fan->credits. ' Amount: $'.$credits.' User ID:'.$user_fan->id);
                            
                            
                                $user_fan->credits += $credits; 
                                $user_fan->save();
                                
                                Log::info('From refundMessagesWithoutAnswered -- User credit new: $'.$user_fan->credits.' User ID:'.$user_fan->id);
                                //Refund Chat and create user credit log refund chat
                                if($i == 0){
                                    TwilioUtils::send_to_psychic_when_request_expired($model); 
                                }
                                $i++;
                               
                            }
                           

                        }else{
                            //echo 'Inside break'.  PHP_EOL;
                            break;
                        }
                    }
                


            }
            
           
           
           }

        }

        //echo 'Finished'.  PHP_EOL;
        
    } 
    
}

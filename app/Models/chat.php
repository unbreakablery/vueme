<?php

namespace App\Models;

use App\Services\WhiteLabel;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class chat extends Model
{
   protected $table = 'chat';

   public function user(){

       return $this->belongsTo(\App\Models\User::class,'user_id');
   }
    public function urlMedia()
    {
       return WhiteLabel::config('media')->media_purchase['url_cdn'] . '/' . $this->image;

    }
    public function receiver()
	{
		return $this->belongsTo(\App\Models\User::class, 'receiver_id');
    }
    public function user_credit_log()
	{        
		return $this->hasOne(\App\Models\UserCreditLog::class, 'chat_id');
    }
    public function chat_in()
	{     
       if($this->user->role_id == 2){
           return chat_in::where(['user_id'=>$this->user->id,'receiver_id'=>$this->receiver->id])->get()->first();
       }else{
        return chat_in::where(['user_id'=>$this->receiver->id,'receiver_id'=>$this->user->id])->get()->first();
       }
		
    }
    
    public function save(array $options = [])
    {
        if($this->receiver_id){

         if($this->expired_online && $this->refund_id){
            
            if($user = User::find($this->receiver_id)) $user->update(['lost_requests' => $user->lost_requests + 1]);
         }
         else if($user = User::find($this->receiver_id)) {

          if($user->lost_requests) $user->update(['lost_requests' => $user->lost_requests - 1]);
         }
        }
        return parent::save();
    }
}

<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use App\Models\chat;
use App\Models\chat_in;
use App\Services\NotificationUtils;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBasicChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        $id= $this->id;
        $privateMessages = chat::where(['user_id'=> auth()->id(), 'receiver_id'=> $id])
            ->orWhere(function($query) use($id){
                $query->where(['user_id' => $id, 'receiver_id' => auth()->id()]);
            })->orderByDesc('id')
            ->first();
        $last_chat ='no-data';
        if($privateMessages){
            $last_chat = [
                'created_at' => $privateMessages->created_at,
                'message' => $privateMessages->message,
                'type' => $privateMessages->type];
        }else{
            
            if($this->role_id == 2){
                $user_id = $this->id;
                $receiver_id = auth()->id();
    
            }else{
                $user_id = auth()->id();                              
                $receiver_id = $this->id;
            }

            $last_chat = [
                'created_at' => '',
                'message' => '',
                'type' => ''];
           
           
        }

        $view_profile = false;
        $show_name = $this->userProfile()->first()->name;
        $profile_link = '';
        if($this->role_id == 1){
            $view_profile = true;
            $show_name = $this->userProfile()->first()->display_name;
            $profile_link = $this->userProfile()->first()->profile_link;
        } 

        if($this->online && $this->last_log_in < now()->subHours(30)){
            $user = User::find($this->id);
            $user->online = 0;
            $user->save();
        }

        return [
            'id' => $this->id,           
            'view_profile'=> $view_profile,
            'show_name' => $show_name,
            'profile_headshot_url' => $this->userProfile()->first()->haedshot_path,
            'profile_link' => $profile_link, 
            'credits' => $this->credits,
            'unread_messages' => NotificationUtils::unread_messages($this->id),
            'last_chat_utc' => $this->last_chat_utc,
            'last_chat' => $last_chat,
            'chat_free' => $this->chat_free,
            'online' => $this->online || $this->scheduleActiveNow(),


        ];
    }
}

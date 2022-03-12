<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use App\Services\WhiteLabel;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
         $bucket = 'text_chat';
         $url = WhiteLabel::getUrlMediaChat($this,$bucket);
        
         if($this->receiver()->first()->online && $this->receiver()->first()->last_log_in < now()->subHours(30)){
            $user = User::find($this->receiver()->first()->id);
            $this->receiver()->first()->online = 0;
            $user->save();
        }



       return [
            'created_at' => $this->created_at,
            'id' => $this->id,
            'message' => $this->message,
            'image' => $url,
            'receiver_id' => (int)$this->receiver_id,  
            'receiver_haedshot_path' => $this->user()->first()->UserProfile()->first()->haedshot_path,            
            'user' => new UserBasicChatResource($this->user),
            'user_id' => $this->user_id,
            'receiver_profile' => $this->receiver()->first()->UserProfile()->first()->haedshot_path,  
            'receiver_online' => $this->receiver()->first()->online || $this->receiver()->first()->scheduleActiveNow(),
            'type' => $this->type,
            'status' => $this->status,
            'min_to_expire' => $this->min_to_expire             

        ];


    }

}

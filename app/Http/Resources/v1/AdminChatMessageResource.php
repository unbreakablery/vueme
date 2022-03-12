<?php

namespace App\Http\Resources\v1;

use App\Services\WhiteLabel;
use App\Models\UserCreditLog;
use App\Http\Resources\v1\UserBasicChatResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $user = $this->user;
        $receiver = $this->receiver;
        $credit = UserCreditLog::where('chat_id', $this->id)->first();

        $bucket = 'text_chat';
         $url = WhiteLabel::getUrlMediaChat($this,$bucket);


       return [
            // 'created_at' => $this->created_at,
            // 'user' => $user,
            // 'receiver' => $receiver,
            // 'image' => $this->image,
            // 'message' => $this->message,
            // 'credit' => $credit ? $credit->credits : null,

            'created_at' => $this->created_at,
            'id' => $this->id,
            'message' => $this->message,
            'image' => $url,
            'user' => $user,
            'receiver' => $receiver,
            'type' => $this->type,
            'status' => $this->status,
            'credit' => $credit ? $credit->credits : null,
            'ip' => $this->ip

        ];


    }

}

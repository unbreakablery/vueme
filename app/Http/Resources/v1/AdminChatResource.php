<?php

namespace App\Http\Resources\v1;

use App\Services\WhiteLabel;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        $userClass = $this->user()->first();
        $userClass2 = $this->receiver()->first();
        $user = $userClass->UserProfile()->first();
        $receiver = $userClass2->UserProfile()->first();
       return [
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'user_ip' => $userClass->device ? $userClass->device->ip : null,
            'receiver_id' => $this->receiver_id,
            'receiver_ip' => $userClass2->device ? $userClass2->device->ip : null,
            'user_username' => $user->name . ' ' . $user->last_name,
            'receiver_username' => $receiver->display_name,
            'user_haedshot_path' => $user->haedshot_path,              
            'receiver_haedshot_path' => $receiver->haedshot_path,
            'user_profile_link' => $user->profile_link,
            'receiver_profile_link' => $receiver->profile_link,
            'type' => $this->type,
            'user_timezone' => $user->timezone,
            'receiver_timezone' => $receiver->timezone,

        ];


    }

}

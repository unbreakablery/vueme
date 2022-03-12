<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use App\Services\WhiteLabel;
use App\Http\Trails\ServiceTrail;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAdminServiceResource extends JsonResource
{
    use ServiceTrail;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $profile = $this->userProfile()->first();

        $date = new Carbon($this->created_at);
        $now = Carbon::now();

        $days = $date->diffInDays($now);

        $service = $type = WhiteLabel::roleId('Model') == $this->role_id ? $this->psychicService($this, $days) : $this->clientService($this, $days);

        return [
            'id' => $this->id,
            'role_id' => $this->role_id,
            'photo' => $profile->haedshot_path,
            'name' => $profile->name,
            'last_name' => $profile->last_name,
            'full_name' => $profile->name . ' ' . $profile->last_name,
            'display_name' => $profile->display_name,
            'profile_link' => $profile->profile_link,
            'profile_percent' => $this->profile_percent,
            'phone_numbers' => $this->user_mobile_nums()->first() ?? ['number' => null, 'code2' => null],
            'email' => $this->email,
            'created_at' => $this->created_at,
            'avg_session' => $service['avg_session'],
            'avg_video' => $service['avg_video'],
            'avg_call' => $service['avg_call'],
            'avg_chat' => $service['avg_chat'],
            'avg_service' => $service['avg_service'],

        ];
    }
}

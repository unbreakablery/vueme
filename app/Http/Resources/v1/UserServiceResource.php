<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;



class UserServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'service' => $this->service()->first(),
            'rate' => $this->formatRate(),
            'active' => $this->active,
            'duration'=> $this->min_duration,
            'time_available' => $this->get_available_time(),
            'chat_request' => $this->get_pending_request()
        ];
    }
}

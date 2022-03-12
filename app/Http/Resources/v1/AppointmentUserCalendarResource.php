<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AppointmentUserCalendarResource extends JsonResource
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
            'text' => $this->text,
            'date' => $this->date,
            'start' => $this->convertTime(
                $this->start_hour, 
                $this->user()->first()->userProfile()->first()->timezone, 
                Auth::user()->userProfile->timezone
            ),
            'end' => $this->convertTime(
                $this->end_hour, 
                $this->user()->first()->userProfile()->first()->timezone, 
                Auth::user()->userProfile->timezone
            ),
            'duration' => $this->status == 'Completed' && $this->user_1_1_chat_request && $this->user_1_1_chat_request->user_credit_log ? $this->user_1_1_chat_request->user_credit_log->duration : $this->duration,
            'user' => new UserBasicResource($this->user()->first()),
            'name' => $this->psychic()->first()->userProfile()->first()->display_name,
            'psychic'=> new UserBasicResource($this->psychic()->first()),
            'service' => new ServiceResource($this->service()->first()),
            'category' => new CategoryResource($this->category()->first()),
            'details' => "",
            'reviewed' => $this->reviewed,
            'price'=> $this->getPrice(),
            'status'=> $this->status,
            'color'=> $this->getStatusColor()
        ];
    }
}

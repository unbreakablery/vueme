<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AppointmentCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function convertTime($time, $fromTimezone='America/New_York', $toTimezone="America/Los_Angeles") {

        
        $date = new \DateTime($time, new \DateTimeZone($fromTimezone));
        
        $date->setTimezone(new \DateTimeZone($toTimezone));

        $_return = $date->format('Y-m-d H:i:s');

        return $_return;


    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'date' => $this->date,
            'start'=> self::convertTime(
                $this->start_hour, 
                $this->user()->first()->userProfile()->first()->timezone, 
                Auth::user()->userProfile->timezone
            ),
            'end'=>self::convertTime(
                $this->end_hour, 
                $this->user()->first()->userProfile()->first()->timezone, 
                Auth::user()->userProfile->timezone
            ),
            'duration' => $this->status == 'Completed' && $this->user_1_1_chat_request && $this->user_1_1_chat_request->user_credit_log ? $this->user_1_1_chat_request->user_credit_log->duration : $this->duration,
            'duration_show' => $this->duration > 1 ? $this->duration.' mins' : $this->duration. ' min',
            'user' => new UserBasicResource($this->user()->first()),
            'name' => $this->user()->first()->userProfile()->first()->name,
            'psychic'=> new UserBasicResource($this->psychic()->first()),
            'service' => new ServiceResource($this->service()->first()),
            'category' => new CategoryResource($this->category()->first()),
            'details' => $this->text,
            'price'=> $this->getPrice(),
            'status'=> $this->status,
            'review_requested'=> $this->review_requested,
            'color'=> $this->getStatusColor(),
            'request' => $this->user_1_1_chat_request ? $this->user_1_1_chat_request->id : 0,
            'type' => $this->type
        ];
    }
}

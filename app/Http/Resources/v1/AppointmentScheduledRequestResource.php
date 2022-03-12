<?php

namespace App\Http\Resources\v1;

use App\Services\NotificationsInAppUtils;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AppointmentScheduledRequestResource extends JsonResource
{

    public function convertTime($time, $fromTimezone='America/New_York', $toTimezone="America/Los_Angeles") {

       
        $date = new \DateTime($time, new \DateTimeZone($fromTimezone));
      
        $date->setTimezone(new \DateTimeZone($toTimezone));

        $_return = $date->format('Y-m-d H:i:s');

        return $_return;


    }
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
            'date' => $this->date,
            'start'=> self::convertTime(
                $this->start_hour, 
                $this->user()->first()->userProfile()->first()->timezone, 
                Auth::user()->userProfile->timezone
            ), 
            'duration' => $this->duration > 1 ? $this->duration.' Minutes' : $this->duration. ' Minute',           
            'client_name' => $this->user()->first()->userProfile()->first()->name,            
            'service_name' => $this->service()->first()->name,
            'notification' => NotificationsInAppUtils::f_array_to_psychics_when_new_scheduled_appointment($this,'psychic'),
            
        ];
    }
}

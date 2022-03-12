<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserHoroscopeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */


    public function toArray($request)
    {


        $birth_date = $this->birth_date;
        if($this->birth_date <>'0000-00-00'){
            $date = new \DateTime($this->birth_date);
            $birth_date  = $date->format('m/d/Y');
        }


        return [            
            'id' => $this->id,
            'name' => $this->name,
            'birth_date' => $birth_date,
            'sign' => $this->sign,
            'email' => $this->email,
            'number' => $this->number,
            'horoscope' => $this->birth_date,

        ];
    }
}

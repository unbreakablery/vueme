<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class HoroscopeZodiacSignsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function dateF($data){
        $date = new \DateTime();
        $date = $date::createFromFormat('m/d',trim($data));
        return $date->format('M d');
        
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'about' => $this->about,
            'slug' => $this->slug,
            'logo' => $this->logo,
            'start_period' => $this->dateF($this->start_period),
            'end_period' => $this->dateF($this->end_period),
            'glance_1' => $this->glance_1,
            'glance_2' => $this->glance_2,
            'glance_3' => $this->glance_3,
            'glance_4' => $this->glance_4,
            'glance_5' => $this->glance_5,
            'glance_6' => $this->glance_6,
            'glance_7' => $this->glance_7,
            'glance_8' => $this->glance_8,
            'glance_9' => $this->glance_9,
            'glance_10' => $this->glance_10,
            'glance_11' => $this->glance_11,
            'glance_12' => $this->glance_12,
            

        ];
    }
}

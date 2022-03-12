<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class HoroscopeInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function dateF($data,$format){
        $date = new \DateTime();
        $date = $date::createFromFormat('Y-m-d',trim($data));
        return $date->format($format);
        
    }
    public function toArray($request)
    {
        return [            
            
            'id' => $this->id,
            'start_week' => $this->dateF($this->start_week,'m/d/Y'),
            'startWeek' => $this->dateF($this->start_week,'F d, Y'),
            'end_week' => $this->dateF($this->end_week,'m/d/Y'),
            'horoscope_zodiac_signs_id' => $this->horoscope_zodiac_signs_id,
            'horoscope_name' => new HoroscopeZodiacSignsResource($this->horoscope_zodiac_signs()->first()),
            'content' => $this->content,
            'match_id1' => $this->match_id1,
            'match1' => new HoroscopeZodiacSignsResource($this->match1()->first()),
            'subject1' => $this->subject1,
            'match_id2' => $this->match_id2,
            'match2' => new HoroscopeZodiacSignsResource($this->match2()->first()),
            'subject2' => $this->subject2,
            'match_id3' => $this->match_id3,
            'match3' => new HoroscopeZodiacSignsResource($this->match3()->first()),
            'subject3' => $this->subject3,
            'hustle' => $this->hustle,
            'love' => $this->love,
            'outlook' => $this->outlook,
            'vibe' => $this->vibe,
            'archived' => $this->archived,
          
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use App\Models\Review;
use App\Models\UserSchedule;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PsychicBasicProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $description = is_null($this->description) || empty($this->description) ? '' : mb_substr(preg_replace("([^A-Za-z0-9 ,.!'?])",'',str_replace("’","'",$this->description)), 0, 50)."..." ;
        
        $ext = pathinfo(storage_path($this->intro_video_path), PATHINFO_EXTENSION);
        $intro_video_thumbnail = str_replace('.'.$ext,'.jpg',$this->intro_video_path);
        
        


        return [
            'id' => $this->id,
            'display_name' => $this->display_name,
            'profile_link' => $this->profile_link,
            'profile_headshot_url' => $this->haedshot_path,
            'cover_path' => $this->cover_path,
            'intro_video_path' => $this->intro_video_path,
            'intro_audio_path' => $this->intro_audio_path,
            'intro_video_thumbnail' => $intro_video_thumbnail,
            'tagline' => is_null($this->tagline) || empty($this->tagline)  ? $description : $this->tagline,  
            'years_experience' => $this->years_experience,
            't_clients' => $this->t_clients
        ];
    }
}

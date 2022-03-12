<?php

namespace App\Http\Resources\v1;

use App\Models\Review;
use App\Models\UserSchedule;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PsychicAdminProfileResource extends JsonResource
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
            'display_name' => $this->display_name,
            'profile_link' => $this->profile_link,
            'profile_headshot_url' => $this->haedshot_path,
            'description' => $this->description
        ];
    }
}

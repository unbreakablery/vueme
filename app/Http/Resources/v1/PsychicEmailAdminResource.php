<?php

namespace App\Http\Resources\v1;

use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\ReviewAdminResourceCollection;

class PsychicEmailAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {      
       $profile = $this->userProfile()->first();
        return [
            'id' => $this->id,
            'profile' => new PsychicAdminProfileResource($profile),
            'categories'=> CategoryBasicResource::collection($this->categories()->get()),
            'reviews' => new ReviewAdminResourceCollection($this->reviews()->get()),
            'url' => route('specialtie.profile', $profile->profile_link),
            'users' => $this->users
        ];
    }
}

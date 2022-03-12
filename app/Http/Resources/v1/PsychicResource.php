<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class PsychicResource extends JsonResource
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
       
       if($this->online && $this->last_log_in < now()->subHours(30)){
           $user = User::find($this->id);
           $user->online = 0;
           $user->save();
       }
        return [
            'id' => $this->id,
            'profile' => new PsychicBasicProfileResource($profile),
            'categories'=> CategoryBasicResource::collection($this->categories()->get()),
            'reviews' => $this->reviews()->where('status', 'Posted')->count(),
            'reviews_rating' => Review::where('psychic_id', '=', $this->id)->where('status', 'Posted')->avg('rating'),
            'favorite' => $this->isSaved(),
            'url' => route('specialtie.profile', $profile->profile_link),
            'online' => $this->online || $this->scheduleActiveNow(),
            'reading_in_progress' => $this->is_reading_in_progress(),
            'services'=>  new UserServiceResourceCollection($this->userService()->get()),
            'is_streaming_live' => $this->is_streaming_live,
            'featured' => $this->featured,
        ];
    }
}

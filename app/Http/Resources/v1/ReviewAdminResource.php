<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $this->user()->first()->userProfile()->first();
        $psychic = $this->psychic()->first()->userProfile()->first();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'rating' => $this->rating,
            'psychic_display_name' => $psychic->display_name,
            'user_display_name' => $user->display_name,
            'psychic_link' => $psychic->profile_link,
            'user_link' => $psychic->profile_link,
            'created_at' => $this->created_at,
            'posted_at' => $this->posted_at,
            'status'=> $this->status,
            'replies'=> ReviewReplyBasicResource::collection($this->replies()->get()),
            'loading' => false
        ];
    }
}

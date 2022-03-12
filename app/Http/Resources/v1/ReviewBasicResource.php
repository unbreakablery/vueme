<?php

namespace App\Http\Resources\v1;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class ReviewBasicResource extends JsonResource
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
            'title' => $this->title,
            'text' => $this->text,
            'rating' => $this->rating,
            'user' => new UserBasicResource($this->user()->first()),
            'psychic' => new UserBasicResource($this->psychic()->first()),
            'service' => new ServiceResource($this->service()->first()),
            'category' => new CategoryResource($this->category()->first()),
            'created_at' => $this->created_at,
            'posted_at' => $this->posted_at,
            'status' => $this->status,
            'replies' => ReviewReplyBasicResource::collection($this->replies()->get()),
            'helpful' => $this->helpful,
            'helpfuls' => Auth::guard('api')->user() ? ( $this->userHelpfuls()->where('user_id',Auth::guard('api')->user()->id)->get()->count() ? true : false ) : false,
            
        ];
    }
}

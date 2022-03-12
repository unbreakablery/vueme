<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewReplyBasicResource extends JsonResource
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
            'text' => $this->text,
            'psychic'=> new UserBasicResource($this->psychic()->first()),
            'created_at' => $this->created_at,
            'posted_at' => $this->posted_at,
            'status'=> $this->status,
        ];
    }
}

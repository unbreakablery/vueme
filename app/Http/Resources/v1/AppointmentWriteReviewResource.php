<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentWriteReviewResource extends JsonResource
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
            'date' => $this->date,             
            'psychic'=> new UserBasicResource($this->psychic()->first()),
            'service' => new ServiceResource($this->service()->first()),
            'category' => new CategoryResource($this->category()->first()),           
            'reviewed' => $this->reviewed,            
            'token'=> $this->token_review,
            
        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentBasicResource extends JsonResource
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
            'date' => $this->date,
            'start'=> $this->start_hour,
            'end'=> $this->end_hour,
            'duration' => $this->duration,
            'user' => new UserBasicResource($this->user()->first()),
            'psychic'=> new UserBasicResource($this->psychic()->first()),
            'service' => new ServiceResource($this->service()->first()),
            'category' => new CategoryResource($this->category()->first()),
            'created_at' => $this->created_at,
            'status'=> $this->status,
        ];
    }
}

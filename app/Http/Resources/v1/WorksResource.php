<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class WorksResource extends JsonResource
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
            'position' => $this->position,
            'from_year'=> $this->from_year,
            'to_year' => $this->to_year,
            'company' => $this->company,
            'description' => $this->description,

        ];
    }
}

<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CredentialResource extends JsonResource
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
            'institution_name' => $this->institution_name,
            'from_year'=> $this->from_year,
            'to_year' => $this->to_year,
            'degree' => $this->degree,
            'area_of_study' => $this->area_of_study,
            'description' => $this->description,

        ];
    }
}

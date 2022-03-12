<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecialResource extends JsonResource
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
            'name' => $this->name,
            'slug'=> $this->slug,
            'path' => $this->path,
            //'models' => $this->users()->count(),
            'url' => route('get_specialties', $this->slug),
            'color' => $this->color,
            
        ];
    }
}

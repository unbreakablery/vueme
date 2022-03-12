<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\GenericResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'description' => $this->description,
            'slug'=> $this->slug,
            'image' => new GenericResource($this->image, ['path']),
            'path' => $this->path,
            'url' => route('specialty', $this->slug),
            //'users_count' => $this->users_count,
            "users_count"=>$this->users_activos($this->id),
            'online' => $this->users()->where('online', true)->count(),
        ];
    }
}

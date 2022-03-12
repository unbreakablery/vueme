<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CategorySearchResource extends JsonResource
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
            'id'=> $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'seo_headline' => $this->seo_headline,
            'seo_img_path' => $this->seo_img_path,
            'seo_content' => $this->seo_content,
            'seo_hero_path' => $this->seo_hero_path,
            'seo_hero_content' => $this->seo_hero_content,
            
        ];
    }
}

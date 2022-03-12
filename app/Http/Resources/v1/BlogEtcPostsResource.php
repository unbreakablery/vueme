<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogEtcPostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function dateFY($data,$format){
        $date = new \DateTime();
        $date = $date::createFromFormat('Y-m-d H:i:s',trim($data));
        return $date->format($format);
        
    }
    

    public function toArray($request)
    {

        $sub_title = is_null($this->post_body) || empty($this->post_body) ? '' : mb_substr(strip_tags(html_entity_decode($this->post_body)), 0, 130)."..." ;



        return [            
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'sub_title' => $sub_title,
            'categories' => $this->Categories(),
            'date' =>  is_null($this->posted_at) ? '' : $this->dateFY($this->posted_at,'F d, Y'),
            'image' => $this->image_large,
            'url' => $this->slug,
        ];
    }
}

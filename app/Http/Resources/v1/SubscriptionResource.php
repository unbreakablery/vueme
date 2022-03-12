<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'price' => $this->price,
            'status' => $this->status,
            'type'=> $this->type,
            'created_at'=> date('n/j/Y',strtotime($this->created_at)),
            'user_id' => $this->user_id,
        ];
    }
}

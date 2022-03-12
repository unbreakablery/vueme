<?php

namespace App\Http\Resources\v1;

use Faker\Provider\DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReferralInfoResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'last_name' => $this->last_name,
            'display_name' => $this->display_name,
        ];
    }
}

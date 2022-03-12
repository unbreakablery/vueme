<?php

namespace App\Http\Resources\v1;

use App\Models\Review;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserScheduleResource extends JsonResource
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
            'day' => $this->day,
            'from' => $this->from,
            'till'=> $this->till,
        ];
    }
}

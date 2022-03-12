<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\AccessType;

class AccessTypesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (AccessType $accessType) {
            return (new AccessTypesResource($accessType));
        });
       return parent::toArray($request);
    }
}

<?php

namespace App\Http\Resources\v1;

use App\Http\Trails\PayoutTrail;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserAdminPayoutResourceCollection extends ResourceCollection
{
    use PayoutTrail;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        
        return [
            'meta' => [
                'pay_period' => $this->payPeriod(),
            ],
        ];
    }
}

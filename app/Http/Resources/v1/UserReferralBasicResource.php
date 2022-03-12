<?php

namespace App\Http\Resources\v1;

use Faker\Provider\DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReferralBasicResource extends JsonResource
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
            'action' => $this->action,
            'referral_email' => $this->referral_email,
            'user_id' => $this->user_id,
            'referral_id' => $this->referral_id,
            'user_referral' => $this->referral_id ? new UserReferralInfoResource($this->referral($this->referral_id)) : '',
            'joined' => $this->referral_email ?  $this->joined($this->referral_email) : 'false',
        ];
    }
}

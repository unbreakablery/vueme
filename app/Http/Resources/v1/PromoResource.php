<?php

namespace App\Http\Resources\v1;

use App\Models\UserCreditLog;
use Illuminate\Http\Resources\Json\JsonResource;

class PromoResource extends JsonResource
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
            'credits' => $this->credits,
            'code' => $this->code,
            'active' => $this->active,
            'users' => UserCreditLog::join('user', 'user.id', '=', 'user_credit_log.user_id')
            ->where('user.fraud', 0)->where('user.test_user', 0)->where('user_credit_log.action', 'BUY_CREDIT')
            ->where('user_credit_log.promo_id', $this->id)->count()         

        ];


    }

}

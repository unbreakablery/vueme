<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\v1\CategoryResourceCollection;
use App\Http\Resources\v1\CredentialResourceCollection;
use App\Http\Resources\v1\UserProfileBasicResource;
use App\Http\Trails\PayoutTrail;
use App\Models\User;
use App\Models\UserCreditLog;
use App\Services\WhiteLabel;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAdminTransactionResource extends JsonResource
{
    use PayoutTrail;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {        
        $profile = $this->user()->first()->userProfile()->first();
        return [
                'id' => $this->id,
                'photo' => $profile->haedshot_path,
                'display_name' => $this->name . ' ' . $this->last_name,
                'email' => $this->email,
                'amount' => $this->amount,
                'link' =>  $this->profile_link,
                'date' => $this->created_at,
                'result_text' => $this->result_text,
                'user_id' => $this->user_id
        ];
    }
}

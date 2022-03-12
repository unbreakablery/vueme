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

class UserAdminPayoutResource extends JsonResource
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
        $profile = $this->userProfile()->first();
        $payout = $this->payout(User::find($this->id));
        return array_merge(
            [
                'id' => $this->id,
                'photo' => $profile->haedshot_path,
                'full_name' => $profile->name . ' ' . $profile->last_name,
                'display_name' => $profile->display_name,
                'role_id'=> $this->role_id,
                'email' => $this->email,                
                'sending' => false,
                'link' => $profile->profile_link
            ],
            $payout
        );
    }
}

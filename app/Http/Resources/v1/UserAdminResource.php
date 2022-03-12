<?php

namespace App\Http\Resources\v1;

use App\Models\UserDevice;
use App\Models\Country_all;
use App\Models\UserCreditLog;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\UserProfileBasicResource;
use App\Http\Resources\v1\CategoryResourceCollection;
use App\Http\Resources\v1\CredentialResourceCollection;
use Illuminate\Support\Facades\DB;

class UserAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $profile = $this->userProfile()->first();

        if(!($phone = $this->user_mobile_nums()->first())){
            $phone =  ['number' => null, 'code2' => null, 'prefix' => null, 'validated' => null];
        }
        $license = DB::table('user_document')->where('user_id', $this->id)->where('type','Government Issued')->first();
        return [
            'id' => $this->id,
            'role_id' => $this->role_id,
            'photo' => $profile->haedshot_path,
            'name' => $profile->name,
            'last_name' => $profile->last_name,
            'full_name' => $profile->name . ' ' . $profile->last_name,
            'display_name' => $profile->display_name,
            'profile_link' => $profile->profile_link,
            'city' => $profile->city,
            'state' => $profile->state,
            'description' => $profile->description,
            'profile_percent' => $this->profile_percent,
            'phone_numbers' => $phone,
            'email' => $this->email,
            'email_validated'=> $this->email_validated,
            'gender' => $profile->gender,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories'=> new CategoryResourceCollection($this->categories()->get()),
            'credentials'=> new CredentialResourceCollection($this->credentials()->get()),
            'works'=> new WorksResourceCollection($this->works()->get()),
            'languages'=> new LanguagesResourceCollection($this->languages()->get()),
            'credit' => $this->credits,//UserCreditLog::where('user_id', $this->id)->sum('credits'),           
            'featured' => $this->featured,
            'device' => UserDevice::where('user_id', $this->id)->first(),
            'account_status' => $this->account_status,
            'test_user' => $this->test_user,            
            'priority' => $this->priority ?? 0,
            'fraud' => $this->fraud,
            'billing' => $this->biller_edata()->get(),
            'note' => $this->note,
            'referred_by' => $this->referred_by,
            'delete' => !(($this->credits != '0.00' && $this->credits) || $this->user_credit_logs()->count() || $this->psychic_payout_logs->count() || $this->psychic_credit_logs()->count()),
            'licence_checked' => $profile->license_checked,
            'license_info' => $this->governmentIssuedDocument ? ["age" => $license->age, "dob" => $license->dob, "firstName" => $license->firstName, "lastName" => $license->lastName, "address1" => $license->address1, "address2" => $license->address2] : []
             //'license_info' => $this->governmentIssuedDocument ? ["age" => $this->governmentIssuedDocument->getVaultInfo()->age, "dob" => $this->governmentIssuedDocument->getVaultInfo()->dob, "firstName" => $this->governmentIssuedDocument->getVaultInfo()->firstName, "lastName" => $this->governmentIssuedDocument->getVaultInfo()->lastName, "address1" => $this->governmentIssuedDocument->getVaultInfo()->address1, "address2" =>$this->governmentIssuedDocument->getVaultInfo()->address2] : []
             ];
    }
}

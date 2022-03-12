<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBasicResource extends JsonResource
{
    /**
     * Transform the resource into an array. changeUserInfo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array AQUI MAX
     */

     
    public function toArray($request)
    
    {



        if($this->online && $this->last_log_in < now()->subHours(30)){
            $user = User::find($this->id);
            $user->online = 0;
            $user->save();
        }

        return [
            'id' => $this->id,
            'role' => $this->role()->first(),
            'profile' => new UserProfileFormResource($this->userProfile()->first()),
            'phone_numbers' => $this->user_mobile_nums()->get(),
            'email' => $this->email,
            'email_validated'=> $this->email_validated,
            'account_status' => $this->account_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'saved'=> $this->isSaved(),
            'categories'=> new CategoryResourceCollection($this->categories()->get()),
            //'credentials'=> new CredentialResourceCollection($this->credentials()->get()),
            //'works'=> new WorksResourceCollection($this->works()->get()),
            'url' => route('specialtie.profile', $this->userProfile()->first()->profile_link),
            'online' => $this->online || $this->scheduleActiveNow(),
            //'specialties'=> new SpecialResourceCollection($this->specialties()->get()),
            //'tools'=> new ToolsResourceCollection($this->tools()->get()),
            //'styles'=> new StylesResourceCollection($this->styles()->get()),
            //'languages'=> new UserLanguagesResourceCollection($this->languages()->get()),
            'streaming_key' => $this->streaming_key,
        ];
    }
}

//Aquiii MAXx

<?php

namespace App\Http\Resources\v1;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\SubscriptionResourceCollection;

class UserFrontBasicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $posts = new PostResourceCollection(
        //     $this->posts()
        //         ->whereDate('available_after', '<=', date('Y-m-d'))
        //         ->where('status', "PUBLISHED")
        //         ->orderBy('available_after', 'desc')
        //         ->get()
        // );
        
        return [
            'id' => $this->id,
            'role' => $this->role()->first(),
            'profile' => new UserProfileBasicResource($this->userProfile()->first()),
            'phone_numbers' => $this->user_mobile_nums()->get(),
            'services'=> new UserServiceResourceCollection($this->userService()->get()),
            // 'posts'=> $posts,
            'account_status' => $this->account_status,
            'saved'=> $this->isSaved(),
            // 'medias' => $this->media()->count(),
            'online_status' => $this->online_status,
            
            // 'medias' => DB::table('post_media') 
            //     ->rightJoin('post', 'post_media.post_id', '=', 'post.id')
            //     ->whereDate('post.available_after', '<=', date('Y-m-d'))
            //     ->where('post.user_id', $this->id)
            //     ->where('post.status', 'PUBLISHED')
            //     ->count(),

            'user_subscribed' => $this->isFanSubscribed(Auth::guard('api')->user(), 'MEDIA'),
            // 'user_subscribed_snapchat' => $this->isFanSubscribed(Auth::guard('api')->user(), 'SNAPCHAT'),
            'subscriptions'=> new SubscriptionResourceCollection($this->subscriptions()->get()),
            // 'pendingRequest'=> new UserServiceResourceCollection(
            //     UserService::modelServicePending(Auth::guard('api')->user(), $this)
            //     )//$this->getModelPendingRequests(),

        ];
    }
}

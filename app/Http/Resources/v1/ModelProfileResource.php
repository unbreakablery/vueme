<?php

namespace App\Http\Resources\v1;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\v1\SubscriptionResourceCollection;

class ModelProfileResource extends JsonResource
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

        $profile = $this->userProfile;

        $user = Auth::user() ?? Auth::guard('api')->user();
     
        return [
           
            'id' => $this->id,
            'is_streaming_live' => $this->is_streaming_live,           
            'streaming_live' => $this->is_streaming_live ? $this->get_streaming_live_url() : '',
            'profile' => new GenericResource($profile, [
                'display_name',
                 'description',
                 'profile_link',
                 'social_link_one',
                 'social_link_two',
                 'social_link_three',
                 'intro_video_path',
                 'intro_video_thumbnail',
                 ['haedshot_path' => 'profile_headshot_url']]),
            // 'phone_numbers' => $this->user_mobile_nums()->get(),
            'services'=> new UserServiceResourceCollection($this->userService()->get()),
            // 'posts'=> $posts,
            // 'account_status' => $this->account_status,
            'favorite'=> $user ? $user->favorites()->get()->contains($this->id) : false,
            // 'medias' => $this->media()->count(),
            // 'online_status' => $this->online_status,
            
            // 'medias' => DB::table('post_media') 
            //     ->rightJoin('post', 'post_media.post_id', '=', 'post.id')
            //     ->whereDate('post.available_after', '<=', date('Y-m-d'))
            //     ->where('post.user_id', $this->id)
            //     ->where('post.status', 'PUBLISHED')
            //     ->count(),

            'user_subscribed' => $user ? $this->isFanSubscribed($user, 'MEDIA') : false,
            'user_subscribed' => $user ? $this->isFanSubscribed($user, 'MEDIA') : false,
            // 'user_subscribed_snapchat' => $this->isFanSubscribed(Auth::guard('api')->user(), 'SNAPCHAT'),
            'subscriptions'=> new SubscriptionResourceCollection($this->subscriptions()->get()),
            // 'pendingRequest'=> new UserServiceResourceCollection(
            //     UserService::modelServicePending(Auth::guard('api')->user(), $this)
            //     )//$this->getModelPendingRequests(),

        ];
    }
}

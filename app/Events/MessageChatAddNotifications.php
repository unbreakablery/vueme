<?php

namespace App\Events;

use App\Http\Resources\v1\ChatResource;
use App\Http\Resources\v1\UserBasicChatResource;
use App\Models\chat;
use App\Models\User;
use App\Services\WhiteLabel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;

class MessageChatAddNotifications implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // public $chat;
    public $chat_receiver_id;
    public $notifications;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserBasicChatResource $resource,$chat_receiver_id)
    {
        $this->notifications =  Auth::user()->get_notifications(Auth::user()->id);
        // $this->chat = $chat;
        $this->chat_receiver_id = $chat_receiver_id;
        $this->user = $resource;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('privatechat.'.$this->chat_receiver_id);
    }


}

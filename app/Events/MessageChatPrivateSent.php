<?php

namespace App\Events;

use App\Http\Resources\v1\ChatResource;
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

class MessageChatPrivateSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    // public $url;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatResource $resource)
    {
        // $bucket = 'text_chat';
        // $url = WhiteLabel::getUrlMediaChat($resource,$bucket);
        // $this->url = $url;
        $this->chat = $resource;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('privatechat.'.$this->chat->receiver_id);
    }


}

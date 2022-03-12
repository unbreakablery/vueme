<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\chat;

class SMSChat
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $chat;
    public $last_chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(chat $chat,$last_chat)
    {
       $this->chat= $chat;
       $this->last_chat= $last_chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

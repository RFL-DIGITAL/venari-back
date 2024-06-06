<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatMessage $chatMessage;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat-'.$this->chatMessage->chat_id),
        ];
    }
}

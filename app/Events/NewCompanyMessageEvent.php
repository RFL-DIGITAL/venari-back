<?php

namespace App\Events;

use App\DTO\MessageDTO;
use App\Models\CompanyChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewCompanyMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $companyMessage;

    /**
     * Create a new event instance.
     */
    public function __construct(MessageDTO $companyMessage)
    {
        $this->companyMessage = $companyMessage->jsonSerialize();

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('messages-'.CompanyChat::where('id', $this->companyMessage['to_id'])
            ->first()->user_id),
            new PrivateChannel('company-chat-'.$this->companyMessage['to_id']),
        ];
    }
}

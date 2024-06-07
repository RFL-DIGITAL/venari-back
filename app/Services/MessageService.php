<?php

namespace App\Services;

use App\DTO\MessageType;
use App\Events\NewChatMessageEvent;
use App\Events\NewMessageEvent;
use App\Models\ChatMessage;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageService
{
    public function sendMessage(Request $request): array
    {
        $ownerID = $request->user()->id;
        $toID = $request->toID;
        $body = $request->body;
        $type = MessageType::tryFrom($request->type);

        switch ($type)
        {
            case MessageType::message:
                $message = new Message();
                $message->from_id = $ownerID;
                $message->to_id = $toID;
                $message->body = $body;
                $message->save();

                event(new NewMessageEvent($message));

                break;

            default:
                $message = new ChatMessage();
                $message->owner_id = $ownerID;
                $message->chat_id = $toID;
                $message->body = $body;
                $message->save();
                $message->load('owner');

                event(new NewChatMessageEvent($message));
        }

        return $message->toArray();
    }
}

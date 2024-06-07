<?php

namespace App\Services;

use App\DTO\MessageType;
use App\Events\NewChatMessageEvent;
use App\Events\NewMessageEvent;
use App\Models\ChatMessage;
use App\Models\FileMessage;
use App\Models\ImageMessage;
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
        $images = $request->images;
        $files = $request->files;

        switch ($type)
        {
            case MessageType::message:
                if ($body != '')
                {
                    $message = new Message(
                        [
                            'from_id' => $ownerID,
                            'to_id' => $toID,
                            'body' => $body,
                        ]
                    );
                    $message->save();

                    event(new NewMessageEvent($message));
                }

                foreach ($images as $image)
                {
                    $message = new Message(
                        [
                            'from_id' => $ownerID,
                            'to_id' => $toID,
                        ]
                    );
                    $message->save();

                    $this->createImageMessage($message, $image);

                    event(new NewMessageEvent($message));
                }

                foreach ($files as $file){
                    $message = new Message(
                        [
                            'from_id' => $ownerID,
                            'to_id' => $toID,
                        ]
                    );
                    $message->save();

                    $this->createFileMessage($message, $file);

                    event(new NewMessageEvent($message));
                }

                break;

            default:
                if ($body != '') {
                    $message = new ChatMessage(
                        [
                            'owner_id' => $ownerID,
                            'chat_id' => $toID,
                            'body' => $body,
                        ]
                    );
                    $message->save();
                    $message->load('owner');

                    event(new NewChatMessageEvent($message));
                }

                foreach ($images as $image)
                {
                    $message = new ChatMessage(
                        [
                            'owner_id' => $ownerID,
                            'chat_id' => $toID,
                        ]
                    );
                    $message->save();
                    $message->load('owner');

                    $this->createImageMessage($message, $image);

                    event(new NewChatMessageEvent($message));
                }

                foreach ($files as $file){
                    $message = new ChatMessage(
                        [
                            'owner_id' => $ownerID,
                            'chat_id' => $toID,
                        ]
                    );
                    $message->save();
                    $message->load('owner');

                    $this->createFileMessage($message, $file);

                    event(new NewChatMessageEvent($message));
                }
        }

        return $message->toArray();
    }

    private function createFileMessage($message, $file){
        $fileMessage = new FileMessage();
        $fileMessage->file()->associate($file);
        $fileMessage->message()->associate($message);
        $fileMessage->save();
    }

    private function createImageMessage($message, $image){
        $imageMessage = new ImageMessage();
        $imageMessage->image()->associate($image);
        $imageMessage->message()->associate($message);
        $imageMessage->save();
    }
}

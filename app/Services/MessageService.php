<?php

namespace App\Services;

use App\DTO\AttachmentDTO;
use App\DTO\MessageDTO;
use App\DTO\MessageType;
use App\Events\NewChatMessageEvent;
use App\Events\NewMessageEvent;
use App\Models\ChatMessage;
use App\Models\File;
use App\Models\FileMessage;
use App\Models\Image;
use App\Models\ImageMessage;
use App\Models\LinkMessage;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageService
{
    public function sendMessage(Request $request): array
    {
        $ownerID = auth()->id();
        $toID = $request->to_id;

        $body = $request->body;
        $type = MessageType::tryFrom($request->type);

        switch ($type) {
            case MessageType::message:
                if ($body != '') {
                    $message = new Message(
                        [
                            'from_id' => $ownerID,
                            'to_id' => $toID,
                            'body' => $body,
                        ]
                    );
                    $message->save();


                    $messageDTO = new MessageDTO(
                        $message->id,
                        $message->from_id,
                        $message->to_id,
                        $message->owner,
                        $this->createAttachment($message),
                        $message->created_at
                    );

                    event(new NewMessageEvent($messageDTO));
                }

                if ($request->hasFile('images')) {
                    foreach ($request->images as $image) {

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
                }

                if ($request->hasFile('attachments')) {
                    foreach ($request->attachments as $file) {
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

                if ($request->hasFile('images')) {
                    foreach ($request->images as $image) {
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
                }

                if ($request->hasFile('attachments')) {
                    foreach ($request->attachments as $file) {
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
        }

        $return = new MessageDTO(
            $message->id,
            $message->from_id,
            $message->to_id,
            $message->owner,
            $this->createAttachment($message),
            $message->created_at
        );

        return $return->jsonSerialize();
    }

    private function createFileMessage($message, $file)
    {
        $fileMessage = new FileMessage();

        $fileModel = new File(
            [
                'file' => base64_encode(file_get_contents($file))
            ]
        );

        $fileModel->save();

        $fileMessage->file()->associate($fileModel);
        $fileMessage->message()->associate($message);
        $fileMessage->save();
    }

    private function createImageMessage($message, $image)
    {
        $imageMessage = new ImageMessage();

        $imageModel = new Image(
            [
                'image' => base64_encode(file_get_contents($image)),
                'description' => 'Картинка в чате'
            ]
        );
        $imageModel->save();

        $imageMessage->image()->associate($imageModel);
        $imageMessage->message()->associate($message);
        $imageMessage->save();
    }

    // todo: создание сообщений с ссылкой
    private function createLinkMessage($message, $link)
    {
        $linkMessage = new LinkMessage();

        $linkMessage->message()->associate($message);
        $linkMessage->save();
    }

    private function createAttachment($message): AttachmentDTO
    {
        return new AttachmentDTO(
            $message->body,
            $message->fileMessage?->file,
            $message->imageMessage?->image,
            $message->linkMessage?->link,
        );
    }
}

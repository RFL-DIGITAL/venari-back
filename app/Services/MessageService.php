<?php

namespace App\Services;

use App\DTO\AttachmentDTO;
use App\DTO\MessageDTO;
use App\DTO\MessageType;
use App\Events\NewChatMessageEvent;
use App\Events\NewCompanyMessageEvent;
use App\Events\NewMessageEvent;
use App\Models\ChatMessage;
use App\Models\CompanyMessage;
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

        $messageDTO = [];

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
                        $this->createAttachment($body),
                        $message->created_at
                    );

                    event(new NewMessageEvent($messageDTO));
                }

                if ($request->has('image')) {

                        $message = new Message(
                            [
                                'from_id' => $ownerID,
                                'to_id' => $toID,
                            ]
                        );
                        $message->save();

                        $this->createImageMessage($message, $request->get('image'));

                        $messageDTO = new MessageDTO(
                            $message->id,
                            $message->from_id,
                            $message->to_id,
                            $message->owner,
                            $this->createAttachment(
                                image: $message->imageMessage->image->id),
                            $message->created_at
                        );

                        event(new NewMessageEvent($messageDTO));
                }

                if ($request->has('attachment')) {
                        $message = new Message(
                            [
                                'from_id' => $ownerID,
                                'to_id' => $toID,
                            ]
                        );
                        $message->save();

                        $this->createFileMessage($message, $request->get('attachment'));

                        $messageDTO = new MessageDTO(
                            $message->id,
                            $message->from_id,
                            $message->to_id,
                            $message->owner,
                            $this->createAttachment(
                                file: $message->fileMessage->file->id),
                            $message->created_at
                        );

                        event(new NewMessageEvent($messageDTO));
                }
                break;

            case MessageType::chatMessage:
                if ($body != '') {
                    $message = new ChatMessage(
                        [
                            'owner_id' => $ownerID,
                            'chat_id' => $toID,
                            'body' => $body,
                        ]
                    );

                    $message->save();

                    $messageDTO = new MessageDTO(
                        $message->id,
                        $message->owner_id,
                        $message->chat_id,
                        $message->owner,
                        $this->createAttachment($body),
                        $message->created_at
                    );

                    event(new NewChatMessageEvent($messageDTO));
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

                        $this->createImageMessage($message, $image);

                        $messageDTO = new MessageDTO(
                            $message->id,
                            $message->owner_id,
                            $message->chat_id,
                            $message->owner,
                            $this->createAttachment(
                                image: $message->imageMessage->image->id),
                            $message->created_at
                        );

                        event(new NewChatMessageEvent($messageDTO));
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

                        $this->createFileMessage($message, $file);

                        $messageDTO = new MessageDTO(
                            $message->id,
                            $message->owner_id,
                            $message->chat_id,
                            $message->owner,
                            $this->createAttachment(
                                file: $message->fileMessage->file->id),
                            $message->created_at
                        );

                        event(new NewChatMessageEvent($messageDTO));
                    }
                }

                break;

            default:
                if ($body != '') {
                    $message = new CompanyMessage(
                        [
                            'owner_id' => $ownerID,
                            'companyChat_id' => $toID,
                            'body' => $body,
                        ]
                    );

                    $message->save();

//                    dd($message->companyChat_id);
                    $messageDTO = new MessageDTO(
                        $message->id,
                        $message->owner_id,
                        $message->companyChat_id,
                        $message->owner,
                        $this->createAttachment($body),
                        $message->created_at
                    );

                    event(new NewCompanyMessageEvent($messageDTO));
                }

                if ($request->hasFile('images')) {
                    foreach ($request->images as $image) {
                        $message = new CompanyMessage(
                            [
                                'owner_id' => $ownerID,
                                'companyChat_id' => $toID,
                            ]
                        );
                        $message->save();

                        $this->createImageMessage($message, $image);

                        $messageDTO = new MessageDTO(
                            $message->id,
                            $message->owner_id,
                            $message->companyChat_id,
                            $message->owner,
                            $this->createAttachment(
                                image: $message->imageMessage->image->id),
                            $message->created_at
                        );

                        event(new NewCompanyMessageEvent($messageDTO));
                    }
                }

                if ($request->hasFile('attachments')) {
                    foreach ($request->attachments as $file) {
                        $message = new CompanyMessage(
                            [
                                'owner_id' => $ownerID,
                                'companyChat_id' => $toID,
                            ]
                        );
                        $message->save();

                        $this->createFileMessage($message, $file);

                        $messageDTO = new MessageDTO(
                            $message->id,
                            $message->owner_id,
                            $message->companyChat_id,
                            $message->owner,
                            $this->createAttachment(
                                file: $message->fileMessage->file->id),
                            $message->created_at
                        );

                        event(new NewCompanyMessageEvent($messageDTO));
                    }
                }
        }

        return $messageDTO->jsonSerialize();
    }

    private function createFileMessage($message, $file): void
    {
        $fileMessage = new FileMessage();

        $fileModel = new File(
            [
                'file' => $file,
                'mime' => $file->getClientMimeType()
            ]
        );

        $fileModel->save();

        $fileMessage->file()->associate($fileModel);
        $fileMessage->message()->associate($message);
        $fileMessage->save();
    }

    private function createImageMessage($message, $image): void
    {
        $imageMessage = new ImageMessage();

        $imageModel = new Image(
            [
                'image' => $image,
                'description' => 'Картинка в чате'
            ]
        );
        $imageModel->save();

        $imageMessage->image()->associate($imageModel);
        $imageMessage->message()->associate($message);
        $imageMessage->save();
    }

    // todo: создание сообщений с ссылкой
    private function createLinkMessage($message, $link): void
    {
        $linkMessage = new LinkMessage(
            [
                'link' => $link
            ]
        );

        $linkMessage->message()->associate($message);
        $linkMessage->save();
    }

    private function createAttachment($body = null, $file = null, $image = null, $link = null): AttachmentDTO
    {
        return new AttachmentDTO(
            $body,
            $file == null ?: route('getFileByID', ['id' => $file]),
            $image == null ?: route('getImageByID',  ['id' => $image]),
            $link,
        );
    }
}

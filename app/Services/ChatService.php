<?php

namespace App\Services;

use App\DTO\AttachmentDTO;
use App\DTO\ChatPreviewDTO;
use App\DTO\MessageDTO;
use App\DTO\MessageType;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Image;
use App\Models\Message;
use Illuminate\Database\Eloquent\Builder;

class ChatService
{
    private int $SAVED_MESSAGES_IMAGE_ID = 1;

    /**
     * Формирует словарь личных чатов
     *
     * @param $userID - id пользователя
     * @return array - массив чатов
     */
    public function formatOneToOnes($userID): array
    {
        $messagesWithThatUser = Message::where('from_id', $userID)
            ->orWhere('to_id', $userID)
            ->get();

        $recentChats = array();

        if ($messagesWithThatUser != null) {
            foreach ($messagesWithThatUser as $message) {
                $owner = $message->owner;
                $destination = $message->destination;
                if ($owner->id == $userID and $destination->id != $userID) {
                    $key = $destination->name;
                    $avatar = $destination?->image?->image;
                    $id = $destination->id;
                } else if ($destination->id == $userID and $owner->id != $userID) {
                    $key = $owner->name;
                    $avatar = $owner?->image?->image;
                    $id = $owner->id;
                } else {
                    $key = 'Избранное';
                    // todo картинка для избранного
                    $avatar = Image::where('id', $this->SAVED_MESSAGES_IMAGE_ID)->first()?->image;
                    $id = $userID;
                }

                dd($owner, $destination);

                if ($message->body == null) {
                    if ($message->fileMessage != null) {
                        $body = 'Файл';
                    } else if ($message->imageMessage != null) {
                        $body = 'Изображение';
                    } else {
                        $body = 'Действие';
                    }
                } else {
                    $body = $message->body;
                }
                // todo нормальная проверка на наличие такого чата
                $recentChats[$key] = [
                    "avatar" => $avatar,
                    "body" => $body,
                    "updated_at" => $message->updated_at->toDateTimeString(),
                    'user_id' => $id
                ];

            }

            $chatPreviewDTOs = [];

            foreach ($recentChats as $key => $value) {
                $chatPreviewDTOs[] = new ChatPreviewDTO(
                    $key,
                    $value['avatar'],
                    $value['body'],
                    $value['updated_at'],
                    MessageType::message,
                    $value['user_id']
                );
            }
            return $chatPreviewDTOs;
        }
        else
        {
            return $recentChats;
        }
    }

    /**
     * Формирует словарь групп
     *
     * @param $userID - id пользователя
     * @return array - массив групп
     */
    public function formatGroups($userID): array
    {
        $chats = Chat::whereHas('users', function (Builder $query) use ($userID) {
            $query->where('user_id', $userID);
        })->get();

        $recentGroups = array();

        if ($chats != null)
        {
            foreach ($chats as $chat) {
                $message = ChatMessage::where('chat_id', $chat->id)->get()->last();

                if ($message != null)
                {
                    if ($message->body == null) {
                        if ($message->fileMessage != null) {
                            $body = 'Файл';
                        } else if ($message->imageMessage != null) {
                            $body = 'Изображение';
                        } else {
                            $body = 'Действие';
                        }
                    }
                    else {
                        $body = $message->body;
                    }
                }
                else {
                    $body = null;
                }

                $recentGroups[] = new ChatPreviewDTO(
                    $chat->name,
                    $chat?->image?->image,
                    $body,
                    $message != null ? $message->updated_at->toDateTimeString() : '',
                    MessageType::chatMessage,
                    $chat->id
                );
            }
        }

        return $recentGroups;
    }

    /**
     * Метод получения сообщений 1-1 по id пользователей
     *
     * @param $myID - id текущего пользователя
     * @param $userID - id пользователя, с которым нужно найти диалог
     * @return array
     */
    public function getMessagesByUserID($myID, $userID): array
    {
        $messages = Message::where(function (Builder $query) use ($myID, $userID) {
            $query->where('from_id', $myID)->where('to_id', $userID);
        })
            ->orWhere(function (Builder $query) use ($myID, $userID) {
                $query->where('from_id', $userID)->where('to_id', $myID);
            })
            ->orderBy('created_at')->get();

        $messageDTOs = array();

        if ($messages != null)
        {
            foreach ($messages as $message) {
                $messageDTOs[] = new MessageDTO(
                    $message->id,
                    $message->from_id,
                    $message->to_id,
                    $message->owner,
                    $this->createAttachment($message)
                );
            }
        }

        return $messageDTOs;
    }

    /**
     * Метод получения сообщений из выбранного чата
     *
     * @param $chatID - id чата
     * @return array
     */
    public function getChatMessagesByChatID($chatID): array
    {
        $chatMessages = ChatMessage::where('chat_id', $chatID)->orderBy('created_at')->get();

        $messageDTOs = array();

        foreach ($chatMessages as $chatMessage) {
            $messageDTOs[] = new MessageDTO(
                $chatMessage->id,
                $chatMessage->owner_id,
                $chatMessage->chat_id,
                $chatMessage->owner,
                $this->createAttachment($chatMessage)
            );
        }

        return $messageDTOs;
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

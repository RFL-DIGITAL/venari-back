<?php

namespace App\Services;

use App\DTO\ChatPreviewDTO;
use App\DTO\Type;
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
    public function formatOneToOnes ($userID): array
    {
        $messagesWithThatUser = Message::where('from_id', $userID)
            ->orWhere('to_id', $userID)
            ->get();

        $recentChats = array();

        foreach ($messagesWithThatUser as $message) {
            $owner = $message->owner;
            $destination = $message->destination;

            if ($owner->id == $userID and $destination->id != $userID) {
                $key = $destination->name;
                $avatar = $destination->image->image;
                $id = $destination->id;
            }
            else if ($destination->id == $userID and $owner->id != $userID) {
                $key = $owner->name;
                $avatar = $owner->image->image;
                $id = $owner->id;
            }
            else {
                $key = 'Избранное';
                // todo картинка для избранного
                $avatar = Image::where('id', $this->SAVED_MESSAGES_IMAGE_ID)->first()->image;
                $id = $userID;
            }

            // todo нормальная проверка на наличие такого чато
            $recentChats[$key] = [
                "avatar" => $avatar,
                "body" => $message->body,
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
                type::message,
                $value['user_id']
            );
        }

        return $chatPreviewDTOs;
    }

    /**
     * Формирует словарь групп
     *
     * @param $userID - id пользователя
     * @return array - массив групп
     */
    public function formatGroups ($userID): array
    {
        $chats = Chat::whereHas('users', function (Builder $query) use ($userID) {
            $query->where('user_id', $userID);
        })->get();

        $recentGroups = array();

        foreach ($chats as $chat) {
            $message = ChatMessage::where('chat_id', $chat->id)->get()->last();

            $recentGroups[] = new ChatPreviewDTO(
                $chat->name,
                $chat->image->image,
                $message->body,
                $message->updated_at->toDateTimeString(),
                Type::chatMessage,
                $chat->id
            );
        }

        return $recentGroups;
    }

    public function getMessagesByUserID ($myID, $userID) {
        return
            Message::where(function (Builder $query) use ($myID, $userID) {
                $query->where('from_id', $myID)->where('to_id', $userID);
            })->orWhere(function (Builder $query) use ($myID, $userID) {
                $query->where('from_id', $userID)->where('to_id', $myID);
            })->orderBy('created_at')->get()->toArray();
    }

    public function getChatMessagesByChatID ($chatID) {
        return
            ChatMessage::where('chat_id', $chatID)->orderBy('created_at')->get()->toArray();
    }
}

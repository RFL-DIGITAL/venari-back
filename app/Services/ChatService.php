<?php

namespace App\Services;

use App\DTO\AttachmentDTO;
use App\DTO\ChatPreviewDTO;
use App\DTO\MessageDTO;
use App\DTO\MessageType;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\CompanyChat;
use App\Models\CompanyMessage;
use App\Models\Image;
use App\Models\Message;
use App\Models\User;
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
                if (!$owner?->id || !$destination?->id) continue;
                if ($owner->id == $userID and $destination->id != $userID) {
                    $key = $destination->name;
                    $avatar = $destination?->image?->image;
                    $id = $destination->id;
                } else if ($destination->id == $userID and $owner->id != $userID) {
                    $key = $owner->name;
                    $avatar = $owner?->image?->image ?? "";
                    $id = $owner->id;
                } else {
                    $key = 'Избранное';
                    // todo картинка для избранного
                    $avatar = Image::where('id', $this->SAVED_MESSAGES_IMAGE_ID)->first()?->image;
                    $id = $userID;
                }

                // todo нормальная проверка на наличие такого чата
                $recentChats[$key] = [
                    "avatar" => $avatar,
                    "body" => $this->formatMessageBody($message),
                    "updated_at" => $message->updated_at->toDateTimeString(),
                    'user_id' => $id
                ];

            }

            $chatPreviewDTOs = [];

            foreach ($recentChats as $key => $value) {
                $chatPreviewDTOs[] = new ChatPreviewDTO(
                    $key,
                    $value['avatar'] ?? "",
                    $value['body'],
                    $value['updated_at'],
                    MessageType::message,
                    $value['user_id']
                );
            }
            return $chatPreviewDTOs;
        } else {
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

        if ($chats != null) {
            foreach ($chats as $chat) {
                $message = ChatMessage::where('chat_id', $chat->id)->get()->last();

                if ($message != null) {
                    $body = $this->formatMessageBody($message);

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
        }

        return $recentGroups;
    }

    public function formatCompanies($userID): array
    {
        $companyChats = CompanyChat::where('user_id', $userID)->get();

        $recentCompanies = [];

        if ($companyChats != null) {
            foreach ($companyChats as $companyChat)
            {
                $companyMessage = CompanyMessage::where('companyChat_id', $companyChat->id)->get()->last();

                if ($companyMessage != null) {
                    $body = $this->formatMessageBody($companyMessage);

                    $recentCompanies[] = new ChatPreviewDTO(
                        $companyChat->company->name,
                        $companyChat->company->image->image,
                        $body,
                        $companyMessage != null ? $companyMessage->updated_at->toDateTimeString() : '',
                        MessageType::companyMessage,
                        $companyChat->id
                    );
                }
            }
        }

        return $recentCompanies;
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

        if ($messages != null) {
            foreach ($messages as $message) {
                $messageDTOs[] = new MessageDTO(
                    $message->id,
                    $message->from_id,
                    $message->to_id,
                    $message->owner,
                    $this->createAttachment(
                        $message?->body,
                        $message?->fileMessage?->file->id,
                        $message?->imageMessage?->image->id,
                        $message?->linkMessage?->link,
                    ),
                    $message->created_at
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
                $this->createAttachment(
                    $chatMessage?->body,
                    $chatMessage?->fileMessage?->file->id,
                    $chatMessage?->imageMessage?->image->id,
                    $chatMessage?->linkMessage?->link,
                ),
                $chatMessage->created_at
            );
        }

        return $messageDTOs;
    }

    public function getCompanyMessagesByCompanyChatID($companyChatID): array
    {
        $companyMessages = CompanyMessage::where('companyChat_id', $companyChatID)->orderBy('created_at')->get();

        $messageDTOs = array();

        foreach ($companyMessages as $companyMessage) {
            $owner = $companyMessage->owner;
            // todo: в будущем стоит учесть ситуацию, когда в такой чат заходит hr.
            if ($owner->hrable->company->id == CompanyChat::where('id', $companyChatID)->first()->company->id) {
                $owner->name = $owner->hrable->company->name;
                $owner->image_id = $owner->hrable->company->image_id;
            }

            $messageDTOs[] = new MessageDTO(
                $companyMessage->id,
                $companyMessage->owner_id,
                $companyMessage->companyChat_id,
                $owner,
                $this->createAttachment(
                    $companyMessage?->body,
                    $companyMessage?->fileMessage?->file->id,
                    $companyMessage?->imageMessage?->image->id,
                    $companyMessage?->linkMessage?->link,
                ),
                $companyMessage->created_at
            );
        }

        return $messageDTOs;
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

    private function formatMessageBody($message): string
    {
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

        return $body;
    }

    public function getAllChats(): array
    {
        return Chat::all()->load(
            [
                'tags',
                'image'
            ]
        )->toArray();
    }

    /**
     * Метод получения подробной информации о чате
     *
     * @param $id - id чата
     * @return array - чат в json
     */
    public function getChatDetail($id): array
    {
        return Chat::where('id', $id)->first()
            ->load('image')
            ->toArray();
    }

    /**
     * Метод покидания чата
     *
     * @param $userID - id пользователя
     * @param $chatID - id чата
     * @return array - чат, который покинул в json
     */
    public function quitChat($userID, $chatID): array
    {
        $user = User::where('id', $userID)->first();
        $chat = Chat::where('id', $chatID)->first();
        $user->chats()->detach($chat);
        $user->save();

        return $chat->load('image')->toArray();
    }

    /**
     * Метод вступления в чат
     *
     * @param $userID - id пользователя
     * @param $chatID - id чата
     * @return array - чат, в который вступил в json
     */
    public function joinChat($userID, $chatID): array
    {
        $user = User::where('id', $userID)->first();
        $chat = Chat::where('id', $chatID)->first();
        $user->chats()->attach($chat);
        $user->save();

        return $chat->load('image')->toArray();
    }
}

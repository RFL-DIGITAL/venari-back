<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ChatsController extends Controller
{
    // todo: Перенести это всё в сервис

    /**
     * Формирует словарь личных чатов
     *
     * @param $user_id - id пользователя
     * @return array - словарь чатов
     */
    private function formatOneToOnes ($user_id): array
    {
        $messagesWithThatUser = Message::where('from_id', $user_id)
            ->orWhere('to_id', 2)
            ->get();

        $recentChats = array();

        foreach ($messagesWithThatUser as $message) {
            $owner= $message->owner;
            $destination = $message->destination;

            if ($owner->id == $user_id and $destination->id != $user_id) {
                $key = $destination->name;
            }
            else if ($destination->id == $user_id and $owner->id != $user_id) {
                $key = $owner->name;
            }
            else {
                $key = 'Избранное';
            }

            $recentChats[$key] = [
                "body" => $message->body,
                "updated_at" => $message->updated_at->toDateTimeString()
            ];
        }

        return $recentChats;
    }

    /**
     * Формирует словарь групп
     *
     * @param $user_id - id пользователя
     * @return array - словарь групп
     */
    private function formatGroups ($user_id) {
        $chats = Chat::whereHas('users', function (Builder $query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->get();

        $recentGroups = array();

        foreach ($chats as $chat) {
            $message = ChatMessage::where('chat_id', $chat->id)->get()->last();

            $recentGroups[$chat->name] = [
                "body" => $message->body,
                "updated_at" => $message->updated_at->toDateTimeString()
            ];
        }

        return $recentGroups;
    }

    public function index(Request $request)
    {
         $user_id = 2; // for testing
//        $user_id = $request->user()->id;

        $recentChats = $this->formatOneToOnes($user_id) +
            $this->formatGroups($user_id);

        // Сортируем чаты - последний самый верхний
        $dates = array_column($recentChats, 'updated_at');
        array_multisort($dates,SORT_DESC , $recentChats);

        return json_encode($recentChats);
    }
}

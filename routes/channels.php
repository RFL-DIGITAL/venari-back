<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
Broadcast::channel('user.{userId}', function ($user, $userId) {
    if ($user->id === $userId) {
        return array('name' => $user->name);
    }});

Broadcast::channel('messages-{toID}', function ($user, $toID) {
    if ($user->id == $toID) {
        return true;
    }
    else {
        return false;
    }
});

Broadcast::channel('chat-{chatID}', function ($user, $chatID) {
    if (User::whereHas('chats', function ($query) use ($chatID){
        $query->where('chats.id', $chatID);
    })->exists())
    {
        return true;
    }
    else {
        return false;
    }
});

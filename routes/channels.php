<?php

use App\Models\Message;
use App\Models\User;
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

//Broadcast::channel('user.{userId}', function ($user, $userId) {
//    return $user->id === $userId;
//});

Broadcast::channel('private-messages-{$toID}', function ($user, $toID) {
//    if (Message::where('from_id', $user->id)->where('to_id', $toID)->exists()) {
        return true;
//    }
//    else {
//        return false;
//    }
});
//
//Broadcast::channel('private-chat-*', function ($user, $chatID) {
//    if (User::whereHas('chat', function ($query) use ($chatID){
//        $query->where('id', $chatID);
//    })->exists())
//    {
//        return true;
//    }
//    else {
//        return false;
//    }
//});

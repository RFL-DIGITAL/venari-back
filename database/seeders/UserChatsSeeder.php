<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Заполняет смежную таблицу user_chats
 */
class UserChatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chats = Chat::all()->random(5);

        foreach ($chats as $chat) {
            $users = User::all()->random(3);
            $chat->users()->attach($users);

        }

    }
}

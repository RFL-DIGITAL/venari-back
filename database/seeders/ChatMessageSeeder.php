<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use Illuminate\Database\Seeder;

/**
 * Заполняет таблицу chat_messages
 */
class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatMessage::factory()
            ->count(5)
            ->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\LinkMessage;
use App\Models\Message;
use Illuminate\Database\Seeder;

class LinkMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = Message::all()->random(5);
        $chatMessages = ChatMessage::all()->random(5);

        for ($i = 0; $i < 5; $i++) {
            $linkMessage = new LinkMessage();
            $linkMessage->message()->associate($messages->random());
            $linkMessage->link = 'https://'.$messages->random()->body.'com';

            $linkMessage->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $linkMessage = new LinkMessage();
            $linkMessage->message()->associate($chatMessages->random());
            $linkMessage->link = 'https://'.$chatMessages->random()->body.'com';

            $linkMessage->save();
        }
    }
}

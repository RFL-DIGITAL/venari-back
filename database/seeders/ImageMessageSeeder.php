<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\Image;
use App\Models\ImageMessage;
use App\Models\Message;
use Illuminate\Database\Seeder;

class ImageMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = Image::all()->random(5);
        $messages = Message::all()->random(5);
        $chatMessages = ChatMessage::all()->random(5);

        for ($i = 0; $i < 5; $i++) {
            $imageMessage = new ImageMessage();
            $imageMessage->message()->associate($messages->random());
            $imageMessage->image()->associate($images->random());

            $imageMessage->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $imageMessage = new ImageMessage();
            $imageMessage->message()->associate($chatMessages->random());
            $imageMessage->image()->associate($images->random());

            $imageMessage->save();
        }
    }
}

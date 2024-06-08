<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\FileMessage;
use App\Models\Message;
use Illuminate\Database\Seeder;
use App\Models\ChatMessage;

class FileMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = File::all()->random(5);
        $messages = Message::all()->random(5);
        $chatMessages = ChatMessage::all()->random(5);

        for ($i = 0; $i < 5; $i++) {
            $fileMessage = new FileMessage();
            $fileMessage->message()->associate($messages->random());
            $fileMessage->file()->associate($files->random());

            $fileMessage->save();
        }

        for ($i = 0; $i < 5; $i++) {
            $fileMessage = new FileMessage();
            $fileMessage->message()->associate($chatMessages->random());
            $fileMessage->file()->associate($files->random());

            $fileMessage->save();
        }
    }
}

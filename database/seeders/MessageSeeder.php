<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

/**
 * Заполняет таблицу messages
 */
class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::factory()
            ->count(20)
            ->create();
    }
}

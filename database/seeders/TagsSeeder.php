<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::factory()
            ->count(10)
            ->create();

        foreach (Chat::all() as $chat) {
//            dd($tags->random(3));
            $chat->tags()->attach($tags->random(3));
        }
    }
}

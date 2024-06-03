<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all()->random(5);

        foreach ($posts as $post) {
            $post->images()->attach(Category::all()->random(2));
        }
    }
}

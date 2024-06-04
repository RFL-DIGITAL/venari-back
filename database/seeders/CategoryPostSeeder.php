<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Program;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Post::all() as $post) {
            $post->categories()->attach(Category::all()->random());
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = Comment::factory()
            ->count(50)
            ->create();

        foreach ($comments as $key => $comment) {
            $randBool = (bool) mt_rand(0, 1);
            $randID = array_rand($comments->toArray());
            $randComment = $comments[$randID];

            if ($randBool and $randComment->id != $comment->id) {
                $randComment->post()->associate($comment->post);
                $randComment->save();
                $comments = $comments->forget($randID);
                $comments = $comments->forget($key);
                $comment->parent_id = $randComment->id;
            }

            $comment->save();
        }
    }
}

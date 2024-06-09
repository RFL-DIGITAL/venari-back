<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Factory<Model>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usersID = User::pluck('id')->toArray();
        $postsID = Post::pluck('id')->toArray();


        return [
            'text' => $this->faker->realText(),
            'user_id' => $this->faker->randomElement($usersID),
            'post_id' => $this->faker->randomElement($postsID),
        ];
    }
}

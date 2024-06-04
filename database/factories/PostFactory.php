<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users_id = User::pluck('id')->toArray();

        return [
            'text' => $this->faker->realText(),
            'attributes' => null,
            'user_id' => $this->faker->randomElement($users_id),
            'title' => $this->faker->sentence(),
            'likes' => $this->faker->randomDigit()*100,
        ];
    }
}

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
        $usersID = User::pluck('id')->toArray();
        $userID = $this->faker->randomElement($usersID);

        return [
            'text' => $this->faker->realText(),
            'attributes' => null,
            'user_id' => $userID,
            'title' => $this->faker->sentence(),
            'likes' => $this->faker->randomDigit()*100,
            'user_name' => User::where('id', $userID)->first()->first_name,
        ];
    }
}

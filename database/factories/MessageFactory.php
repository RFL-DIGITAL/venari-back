<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Message::class;

    public function definition(): array
    {
        $users = User::pluck('id')->toArray();

        return [
            'from_id' => $this->faker->randomElement($users),
            'to_id' => $this->faker->randomElement($users),
            'body' => $this->faker->sentence(),
        ];
    }
}

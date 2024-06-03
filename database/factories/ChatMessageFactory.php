<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ChatMessage::class;

    public function definition(): array
    {
        $users = User::pluck('id')->toArray();
        $chats = Chat::pluck('id')->toArray();

        return [
            'owner_id' => $this->faker->randomElement($users),
            'chat_id' => $this->faker->randomElement($chats),
            'body' => $this->faker->sentence(),
        ];
    }
}

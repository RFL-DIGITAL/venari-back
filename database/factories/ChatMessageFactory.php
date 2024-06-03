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
        $users_id = User::pluck('id')->toArray();
        $chats_id = Chat::pluck('id')->toArray();

        return [
            'owner_id' => $this->faker->randomElement($users_id),
            'chat_id' => $this->faker->randomElement($chats_id),
            'body' => $this->faker->sentence(),
        ];
    }
}

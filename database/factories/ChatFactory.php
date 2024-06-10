<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Chat::class;

    public function definition(): array
    {
        $imagesID = Image::where('description', 'Аватарка')->pluck('id')->toArray();

        return [
            'name' => $this->faker->company(),
            'image_id' => $this->faker->randomElement($imagesID),
            'description' => $this->faker->text(),
        ];
    }
}

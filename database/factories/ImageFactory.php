<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
//        dd($this->faker->image(''));

        return [
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->randomElement(
                [
                    'Аватарка',
                    'Фотография поста'
                ]
            ),
        ];
    }
}

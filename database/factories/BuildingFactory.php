<?php

namespace Database\Factories;

use App\Models\Street;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $streetsID = Street::pluck('id')->toArray();

        return [
            'name' => $this->faker->randomNumber(),
            'street_id' => $this->faker->randomElement($streetsID),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    protected $model = School::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities_id = City::all()->pluck('id')->toArray();

        return [
            'name' => $this->faker->company(),
            'city_id' => $this->faker->randomElement($cities_id),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Company;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $buildingsID = Building::pluck('id')->toArray();
        $imagesID = Image::pluck('id')->toArray();

        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'established_at' => $this->faker->date(),
            'nick_name' => $this->faker->userName(),
            'building_id' => $this->faker->randomElement($buildingsID),
            'preview_id' => $this->faker->randomElement($imagesID),
            'image_id' => $this->faker->randomElement($imagesID),
        ];
    }
}

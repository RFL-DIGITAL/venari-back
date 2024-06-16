<?php

namespace Database\Factories;

use App\Models\Experience;
use App\Models\Resume;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ResumesExpIDFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $experienceID = Experience::pluck('id')->toArray();

        return [
            'experience_id' => $this->faker->randomElement($experienceID)
        ];
    }
}

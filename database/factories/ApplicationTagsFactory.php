<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\ApplicationTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ApplicationTagsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $applicationsID = Application::pluck('id')->toArray();
        $appTagID = ApplicationTag::pluck('id')->toArray();

        return [
            'application_id' => $this->faker->randomElement($applicationsID),
            'appTag_ID' => $this->faker->randomElement($appTagID)
        ];
    }
}

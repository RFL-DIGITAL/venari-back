<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Approve>
 */
class ApproveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $applications_ID = Application::pluck('id')->toArray();

        return [
            'surname' => 'surname',
            'name' => 'name',
            'application_id' => $this->faker->randomElement($applications_ID),
            'status' => $this->faker->boolean(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\HR;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HR>
 */
class HRFactory extends Factory
{
    protected $model = HR::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companies_id = Company::pluck('id')->toArray();

        return [
            'company_id' => $this->faker->randomElement($companies_id),
        ];
    }
}

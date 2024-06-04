<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Department;
use App\Models\Position;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vacancy>
 */
class VacancyFactory extends Factory
{
    protected $model = Vacancy::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments_id = Department::all()->pluck('id')->toArray();
        $positions_id = Position::all()->pluck('id')->toArray();
        $cities_id = City::all()->pluck('id')->toArray();

        return [
            'department_id' => $this->faker->randomElement($departments_id),
            'position_id' => $this->faker->randomElement($positions_id),
            'description' => $this->faker->text(),
            'salary' => $this->faker->phoneNumber(),
            'is_online' => $this->faker->boolean(),
            'has_social_support' => $this->faker->boolean(),
            'is_flexible' => $this->faker->boolean(),
            'is_fulltime' => $this->faker->boolean(),
            'schedule' => 'Schedule: '.$this->faker->text(),
            'city_id' => $this->faker->randomElement($cities_id),
        ];
    }
}

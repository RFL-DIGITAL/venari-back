<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Department;
use App\Models\Employment;
use App\Models\Experience;
use App\Models\Image;
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
        $departmentsID = Department::all()->pluck('id')->toArray();
        $positionsID = Position::all()->pluck('id')->toArray();
        $citiesID = City::all()->pluck('id')->toArray();
        $employmentsID = Employment::all()->pluck('id')->toArray();
        $experiencesID = Experience::all()->pluck('id')->toArray();
        $imagesID = Image::all()->pluck('id')->toArray();

        return [
            'department_id' => $this->faker->randomElement($departmentsID),
            'position_id' => $this->faker->randomElement($positionsID),
            'description' => $this->faker->text(),
            'is_online' => $this->faker->boolean(),
            'has_social_support' => $this->faker->boolean(),
            'is_flexible' => $this->faker->boolean(),
            'is_fulltime' => $this->faker->boolean(),
            'schedule' => 'Schedule: '.$this->faker->text(),
            'city_id' => $this->faker->randomElement($citiesID),
            'employment_id' => $this->faker->randomElement($employmentsID),
            'experience_id' => $this->faker->randomElement($experiencesID),
            'responsibilities' => $this->faker->text(150),
            'requirements' => $this->faker->text(150),
            'conditions' => $this->faker->text(150),
            'additional' => $this->faker->text(150),
            'lower_salary' => $this->faker->numberBetween(1000, 1000000),
            'higher_salary' => $this->faker->numberBetween(500000, 1000000),
            'image_id' => $this->faker->randomElement($imagesID)
        ];
    }
}

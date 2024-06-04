<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Position;
use App\Models\User;
use App\Models\UserPosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPosition>
 */
class UserPositionFactory extends Factory
{
    protected $model = UserPosition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users_id = User::pluck('id')->toArray();
        $companies_id = Company::pluck('id')->toArray();
        $positions_id = Position::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($users_id),
            'company_id' => $this->faker->randomElement($companies_id),
            'position_id' => $this->faker->randomElement($positions_id),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'description' => $this->faker->text(),
        ];
    }
}

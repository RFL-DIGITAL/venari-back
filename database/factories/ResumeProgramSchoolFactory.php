<?php

namespace Database\Factories;

use App\Models\ProgramSchool;
use App\Models\Resume;
use App\Models\ResumeProgramSchool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResumeProgramSchool>
 */
class ResumeProgramSchoolFactory extends Factory
{
    protected $model = ResumeProgramSchool::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $resumes_id = Resume::pluck('id')->toArray();
        $program_schools_id = ProgramSchool::pluck('id')->toArray();

        return [
            'resume_id' => $this->faker->randomElement($resumes_id),
            'programSchool_id' => $this->faker->randomElement($program_schools_id),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}

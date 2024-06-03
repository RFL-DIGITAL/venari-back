<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class VacancySkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Vacancy::all() as $vacancy) {
            $vacancy->skills()->attach(Skill::all()->random(3));
        }
    }
}

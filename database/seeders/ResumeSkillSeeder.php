<?php

namespace Database\Seeders;

use App\Models\Resume;
use App\Models\Skill;
use App\Models\UserPosition;
use Illuminate\Database\Seeder;

class ResumeSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resumes = Resume::all()->random(5);

        foreach ($resumes as $resume) {
            $resume->skills()->attach(Skill::all()->random(3));
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\ResumeProgramSchool;
use Illuminate\Database\Seeder;

class ResumeProgramSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResumeProgramSchool::factory()
            ->count(10)
            ->create();
    }
}

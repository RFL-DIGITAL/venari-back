<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Program;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = Program::all()->random(5);

        foreach ($programs as $program) {
            $program->schools()->attach(School::all()->random(3));
        }
    }
}

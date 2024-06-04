<?php

namespace Database\Seeders;

use App\Models\Resume;
use App\Models\UserPosition;
use Illuminate\Database\Seeder;

class ResumeUserPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resumes = Resume::all()->random(5);

        foreach ($resumes as $resume) {
            $resume->userPositions()->attach(UserPosition::all()->random(3));
        }
    }
}

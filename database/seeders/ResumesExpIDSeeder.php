<?php

namespace Database\Seeders;

use App\Models\Resume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResumesExpIDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $resumes = Resume::all();

        foreach ($resumes as $resume) {
            $resume->experience_id = Resume::pluck('id')->random();
            $resume->save();
        }
    }
}

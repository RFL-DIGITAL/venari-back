<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Experience([
            [
                'name' => 'Полная занятость'
            ],
            [
                'name' => 'Частичная занятость'
            ],
            [
                'name' => 'Стажировка'
            ]
        ]);
    }
}

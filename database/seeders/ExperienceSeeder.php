<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('experiences')->insert([
            [
                'name' => 'Без опыта'
            ],
            [
                'name' => 'Опыт от 1 года'
            ],
            [
                'name' => 'Опыт от 3 лет'
            ],
            [
                'name' => 'Опыт от 5 лет'
            ]
        ]);
    }
}

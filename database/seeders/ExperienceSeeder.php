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
                'name' => 'Полная занятость',
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employments')->insert([
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

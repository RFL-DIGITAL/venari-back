<?php

namespace Database\Seeders;

use App\Models\Employment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        new Employment([
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

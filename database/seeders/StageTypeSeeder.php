<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stage_types')->insert([
            [
                'name' => 'base',
            ],
            [
                'name' => 'interview'
            ],
            [
                'name' => 'reject'
            ],
            [
                'name' => 'offer'
            ]
        ]);
    }
}

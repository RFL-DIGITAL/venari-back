<?php

namespace Database\Seeders;

use App\Models\HR;
use Illuminate\Database\Seeder;

class HRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HR::factory()
            ->count(5)
            ->create();
    }
}

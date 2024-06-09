<?php

namespace Database\Seeders;

use App\Models\Street;
use Illuminate\Database\Seeder;

class StreetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Street::factory()
            ->count(15)
            ->create();
    }
}

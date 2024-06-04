<?php

namespace Database\Seeders;

use App\Models\UserPosition;
use Illuminate\Database\Seeder;

class UserPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserPosition::factory()
            ->count(10)
            ->create();
    }
}

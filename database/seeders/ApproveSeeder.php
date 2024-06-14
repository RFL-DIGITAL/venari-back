<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Approve;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApproveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Approve::factory()->count(Application::count('id'))->create();
    }
}

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationTag;

class ApplicationApplicationTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $application_id = Application::pluck('id')->toArray();
        $applicationTag_id = ApplicationTag::pluck('id')->toArray();

        foreach ($application_id as $a) {
            foreach ($applicationTag_id as $at) {
                DB::table('application_application_tags')->insert([
                    [
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'application_id' => $a,
                        'applicationTag_id' => $at
                    ],
                ]);
            }
        }
    }
}

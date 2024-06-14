<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApplicationTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $company_ID = Company::pluck('id')->toArray();

        foreach ($company_ID as $i) {

            DB::table('application_tags')->insert([
                [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'name' => 'tag_name',
                    'company_id' => $i,
                ],
            ]);

        }

    }
}

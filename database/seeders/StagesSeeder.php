<?php

namespace Database\Seeders;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class StagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company_ids = Company::all()->pluck('id')->toArray();

        foreach ($company_ids as $i) {

            DB::table('stages')->insert([
                [
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "name" => "Первичное интервью",
                    "stageType_id" => 1,
                    "company_id" => $i,
                ],
                [
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "name" => "Техническое интервью",
                    "stageType_id" => 2,
                    "company_id" => $i,
                ],
                [
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "name" => "Отклонено",
                    "stageType_id" => 3,
                    "company_id" => $i,
                ],
                [
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                    "name" => "Приглашение",
                    "stageType_id" => 4,
                    "company_id" => $i,
                ],
            ]);

        }
    }
}

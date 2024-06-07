<?php

namespace Database\Seeders;

use App\Models\File;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++){
            $file = new File();

            $sizeWanted =  126345; // bytes
            $junkData = NULL;

            while (strlen($junkData) < $sizeWanted) {
                $junkData .= chr(mt_rand(32, 126));
            }

            $file->file = pack("C", $junkData);;
            $file->save();
        }

//        File::factory()
//            ->count(10)
//            ->create();
    }
}

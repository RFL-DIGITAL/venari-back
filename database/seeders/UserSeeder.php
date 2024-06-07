<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Заполняет таблицу users
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::factory()
                     ->count(10)
                     ->create() as $user) {
            $image = Image::all()->random();
            $user->image()->associate($image);
            $user->save();
        }
    }
}

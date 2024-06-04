<?php

namespace Database\Seeders;

 use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Порядок важен, так как при заполнении дочерних таблиц необходимы значения
        // в родительских.
        $this->call([
            WorkingStatusSeeder::class,
            CitySeeder::class,
            CompanySeeder::class,
            HRSeeder::class,
            UserSeeder::class,
            MessageSeeder::class,
            ChatSeeder::class,
            UserChatsSeeder::class,
            ChatMessageSeeder::class,
            CategorySeeder::class,
            ImageSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            SchoolSeeder::class,
            ProgramSeeder::class,
            ProgramSchoolSeeder::class,
            ResumeSeeder::class,
            ResumeProgramSchoolSeeder::class,
            UserPositionSeeder::class,
            ResumeUserPositionSeeder::class,
            SkillSeeder::class,
            ResumeSkillSeeder::class,
            PostSeeder::class,
            CategoryPostSeeder::class,
            PostImageSeeder::class,
            VacancySeeder::class,
            VacancySkillSeeder::class,
            CommentSeeder::class
        ]);
    }
}

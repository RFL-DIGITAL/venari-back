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
            CountrySeeder::class,
            CitySeeder::class,
            StreetSeeder::class,
            BuildingSeeder::class,
            ImageSeeder::class,
            CompanySeeder::class,
            HRSeeder::class,
            UserSeeder::class,
            MessageSeeder::class,
            ChatSeeder::class,
            TagsSeeder::class,
            UserChatsSeeder::class,
            ChatMessageSeeder::class,
            CategorySeeder::class,
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
            ExperienceSeeder::class,
            EmploymentSeeder::class,
            FormatSeeder::class,
            StatusSeeder::class,
            VacancySeeder::class,
            VacancySkillSeeder::class,
            CommentSeeder::class,
            FileSeeder::class,
            ImageMessageSeeder::class,
            FileMessageSeeder::class,
            LinkMessageSeeder::class,

        ]);
    }
}

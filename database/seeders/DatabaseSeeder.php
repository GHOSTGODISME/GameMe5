<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\StudentsTableSeeder;
use Database\Seeders\LecturersTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            StudentsTableSeeder::class,
            LecturersTableSeeder::class,
            QuizSeeder::class,
            SurveySeeder::class,
            FortuneWheelSeeder::class,
            ClassroomSeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'iduser' => 1, // Assuming you have a user with ID 1
            // other attributes...
        ]);
        Student::create([
            'iduser' => 2, // Assuming you have a user with ID 1
            // other attributes...
        ]);
    }
}

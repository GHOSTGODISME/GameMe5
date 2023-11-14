<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Student',
            'email' => 'xxx@student.tarc.edu.my',
            'password' => bcrypt('student'),
            'role' => 0,
        ]);

        User::create([
            'name' => 'Lecturer',
            'email' => 'xxx@tarc.edu.my',
            'password' => bcrypt('lecturer'),
            'role' => 1,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.tarc.edu.my',
            'password' => bcrypt('admin'),
            'role' => 2,
        ]);
    }


}
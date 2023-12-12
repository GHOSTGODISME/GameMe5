<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LecturersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lecturer::create([
            'iduser' => 3, // Assuming you have a user with ID 2
            'position'=>'Senior Lecturer'
        ]);
        Lecturer::create([
            'iduser' => 4, // Assuming you have a user with ID 2
            'position'=>'Senior Lecturer'
        ]);
    }
}

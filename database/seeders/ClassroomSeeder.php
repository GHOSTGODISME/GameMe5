<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Classstudent;
use App\Models\Classlecturer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           // Create a student account
          Classroom::create([
            'name' => 'Human Computer Interaction', // Other fields specific to Lecturer
            'coursecode' => 'BAIT2203',
            'group' => '5',
            'joincode' => '0000000',
            'author' => '1',
        ]);

        Classstudent::create([
            'idclass' => '1', 
            'idstudent' => '1', 
        ]);

        Classstudent::create([
            'idclass' => '1', 
            'idstudent' => '2', 
        ]);


        Classlecturer::create([
            'idclass' => '1', 
            'idlecturer'=> '1', 
        ]);


        Classroom::create([
            'name' => 'Cloud Computing', // Other fields specific to Lecturer
            'coursecode' => 'BAIT3273',
            'group' => '5',
            'joincode' => '111111',
            'author' => '1',
        ]);

        Classstudent::create([
            'idclass' => '2', 
            'idstudent' => '1', 
        ]);

        Classstudent::create([
            'idclass' => '2', 
            'idstudent' => '2', 
        ]);


        Classlecturer::create([
            'idclass' => '2', 
            'idlecturer'=> '1', 
        ]);


    }
}

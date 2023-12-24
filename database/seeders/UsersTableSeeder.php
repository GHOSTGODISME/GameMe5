<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a student account
        User::create([
            'name' => 'Vickham Foo',
            'email' => 'vickhamf-wm20@student.tarc.edu.my',
            'password' => Hash::make('S123456.a'), // Use the Hash facade to hash the password
            'accountType' => 'student',
            'gender' => 'male', // Add more attributes as needed
            'dob' => '2002-04-16',
            'verification_code' => 0,
            'profile_picture' => null,
        ]);

         // Create a student account
         User::create([
            'name' => 'Melvin Wong',
            'email' => 'student2@student.tarc.edu.my',
            'password' => Hash::make('S123456.b'), // Use the Hash facade to hash the password
            'accountType' => 'student',
            'gender' => 'female', // Add more attributes as needed
            'dob' => '2002-05-23',
            'verification_code' => 0,
            'profile_picture' => null,
        ]);


        // Create a lecturer account
        User::create([
            'name' => 'Shoong Wai Kin',
            'email' => 'lecturer1@tarc.edu.my',
            'password' => Hash::make('L123456.a'),
            'accountType' => 'lecturer',
            'gender' => 'male',
            'dob' => '1990-01-01',
            'verification_code' => 0,
            'profile_picture' => null,
        ]);

        
        // Create a lecturer account
        User::create([
            'name' => 'Wong Kah Ming',
            'email' => 'lecturer2@tarc.edu.my',
            'password' => Hash::make('L123456.b'),
            'accountType' => 'lecturer',
            'gender' => 'male',
            'dob' => '1990-01-01',
            'verification_code' => 0,
            'profile_picture' => null,
        ]);

        // Create an admin account
        User::create([
            'name' => 'Cheok Ding Wei',
            'email' => 'admin1@admin.com',
            'password' => Hash::make('A123456.a'),
            'accountType' => 'admin',
            'gender' => 'female',
            'dob' => '1980-05-20',
            'verification_code' => 0,
            'profile_picture' => null,
        ]);


        
    }
}

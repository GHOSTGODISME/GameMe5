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
            'email' => 'student@example.com',
            'password' => Hash::make('s123456'), // Use the Hash facade to hash the password
            'accountType' => 'student',
            'gender' => 'male', // Add more attributes as needed
            'dob' => '2002-04-16',
            'verification_code' => 0,
            'profile_picture' => null,
        ]);

        // Create a lecturer account
        User::create([
            'name' => 'Shoong Wai Kin',
            'email' => 'lecturer@example.com',
            'password' => Hash::make('l123456'),
            'accountType' => 'lecturer',
            'gender' => 'male',
            'dob' => '1990-01-01',
            'verification_code' => 0,
            'profile_picture' => null,
        ]);

        // Create an admin account
        User::create([
            'name' => 'Wong Kah Ming',
            'email' => 'admin@example.com',
            'password' => Hash::make('a123456'),
            'accountType' => 'admin',
            'gender' => 'female',
            'dob' => '1980-05-20',
            'verification_code' => 0,
            'profile_picture' => null,
        ]);


        
    }
}

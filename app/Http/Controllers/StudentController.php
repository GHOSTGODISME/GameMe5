<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller{

    function stud_homepage(){
        $email = session()->get('email');
        //$email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
        $student = Student::with('classrooms')->find($stud->id);

        return view('User/stud_homepage', compact('student'));
    }

   function getStudInfo(Request $request)
    {
        // Retrieve student information from the database
        $email = $request->session()->get('email');
        // $email='aa@gmail.com';
        $student = User::where('email', $email)->first();
        // Check if the student is found
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
        // Return the student information
        return view('User/stud_profile', ['student' => $student]);
    }

    public function update_Profile(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $email = $request->session()->get('stud_email');
        //$email='wongtian628@gmail.com';
        // Assuming your User model has an 'email' column
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update the user's profile
        $user->$field = $value;
        $user->save();

        return response()->json(['success' => 'Profile updated successfully']);
    }

   
    function upload_profile_picture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
    
        $uploadedFile = $request->file('profile_picture');
        $originalFileName = $uploadedFile->getClientOriginalName();
        $fileHash = sha1_file($uploadedFile->getRealPath());
        $extension = $uploadedFile->getClientOriginalExtension();
        $fileName = $fileHash . '.' . $extension;
    
        $path = 'profile_pictures/' . $fileName;
    
        // Check if the file already exists before updating the database or storing
        if (!Storage::disk('public')->exists($path)) {
            $uploadedFile->storeAs('profile_pictures', $fileName, 'public');
    
            // Use asset() to generate the URL
            $profilePictureUrl = asset('storage/' . $path);
    
            // Update the user's profile picture URL in the database
            $user->profile_picture = $profilePictureUrl;
            $user->save();
    
            // After successfully updating the profile picture in the database
            return response()->json(['success' => true, 'url' => $profilePictureUrl]);
    
        } else {
            // File with the same hash already exists in storage, update the database only
            $user->profile_picture = asset('storage/' . $path);
            $user->save();
    
            // After successfully updating the profile picture in the database
            return response()->json(['success' => true, 'url' => asset('storage/' . $path)]);
        }
    }

    public function check_Password(Request $request)
    {
        $currentPassword = $request->input('current_password');

        // Retrieve the user's hashed password from the database
        $email = $request->session()->get('email');
        //$email = 'aa@gmail.com';
        $user = User::where('email', $email)->first();
        $hashedPassword = $user->password;

        // Check if the entered current password matches the hashed password
        if (Hash::check($currentPassword, $hashedPassword)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function update_Password(Request $request)
{
    $request->validate([
        'new_password' => 'required|min:6',
    ]);

    $email = $request->session()->get('email');
    //$email = 'aa@gmail.com';
    $user = User::where('email', $email)->first();
    // Update the password
    $user->password = bcrypt($request->input('new_password'));
    $user->save();
    return response()->json(['success' => true, 'message' => 'Password updated successfully']);
}


    
    
    

}
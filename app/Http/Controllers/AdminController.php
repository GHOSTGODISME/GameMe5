<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lecturer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller{

    function admin_stud(Request $request){
          // Retrieve all students or filter by name if a search parameter is provided
        $query = User::where('accountType', 'student');

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $students = $query->get();
            return view('Admin/admin_stud', ['students' => $students]);
    }

    //for staff
    function admin_staff(Request $request){
        // Retrieve all students or filter by name if a search parameter is provided
    $query = User::where('accountType', 'lecturer');

    if ($request->has('search')) {
      $searchTerm = $request->input('search');
      $query->where('name', 'like', '%' . $searchTerm . '%');
    }

    $staffs = $query->get();
      return view('Admin/admin_staff', ['staffs' => $staffs]);
    }



    function admin_add_stud(){
        return view('Admin/admin_add_stud');
    }
    
    function admin_add_staffs(){
        return view('Admin/admin_add_staff');
    }

    function admin_add_student(Request $request)
    {
    
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255|regex:/^[^\d]+$/',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'accountType' => 'required|in:student',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]/',
            ],
        ], [
            'email.regex' => 'The email has already registered!',
            'name.regex' => 'The name field must not contain digits.', 
            'password.regex' => "The password must meet the following criteria:\n" .
            "- Be at least 8 characters long.\n" .
            "- Include at least one lowercase letter.\n" .
            "- Include at least one uppercase letter.\n" .
            "- Include at least one digit.\n" .
            "- Include at least one special character (allowed: @, $, !, %, *, ?, &, .).",
        ]);

        if ($request->filled('password')) {
            $validatedData['password']  = Hash::make($request->password);
        }

        // Create a new student using the validated data
        $user = User::create($validatedData);

        // Redirect or respond as needed (e.g., return a success message)
        return redirect()->back()->with('success', 'Student created successfully!');
    }

    function admin_add_staff(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255|regex:/^[^\d]+$/',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'accountType' => 'required|in:lecturer',
            'position' => 'required|string',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]/',
            ],
        ], [
            'email.regex' => 'The email has already registered!',
            'name.regex' => 'The name field must not contain digits.', 
            'password.regex' => "The password must meet the following criteria:\n" .
            "- Be at least 8 characters long.\n" .
            "- Include at least one lowercase letter.\n" .
            "- Include at least one uppercase letter.\n" .
            "- Include at least one digit.\n" .
            "- Include at least one special character (allowed: @, $, !, %, *, ?, &, .).",
        ]);

        if ($request->filled('password')) {
            $validatedData['password']  = Hash::make($request->password);
        }
        
        // Create a new user using the validated data
        $user = User::create($validatedData);

        $lecturerData = ['position' => $validatedData['position']];
        $lecturer = Lecturer::create(['iduser' => $user->id] + $lecturerData);

        // Redirect or respond as needed (e.g., return a success message)
        return redirect()->back()->with('success', 'Staff created successfully!');
    }

   
    function admin_edit_stud($studentId)
    {
        // Retrieve the student with the given ID
        $student = User::findOrFail($studentId);

        // Pass the student data to the view
        return view('Admin/admin_edit_stud', compact('student'));
    }

    function admin_edit_staff($staffId)
    {
            $staff = Lecturer::where('iduser', $staffId)->first();

            // Retrieve the staff with the given ID along with the associated lecturer
            $user = User::findOrFail($staffId);

            // Pass the staff data to the view
            return view('Admin/admin_edit_staff', compact('staff','user'));
    }

    function admin_update_student(Request $request, $studentId)
    {
    
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,'. $studentId,
            'name' => 'required|string|max:255|regex:/^[^\d]+$/',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'new_password' => [
                'nullable',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]/',
            ],
        ], [
            'email.regex' => 'The email has already registered!',
            'name.regex' => 'The name field must not contain digits.', 
            'new_password.regex' => "The password must meet the following criteria:\n" .
            "- Be at least 8 characters long.\n" .
            "- Include at least one lowercase letter.\n" .
            "- Include at least one uppercase letter.\n" .
            "- Include at least one digit.\n" .
            "- Include at least one special character (allowed: @, $, !, %, *, ?, &, .).",
        ]);
    
        // Update the student details
        $student = User::findOrFail($studentId);
    
        // Check if a new password is provided
        if ($request->filled('new_password')) {
            $student->password = Hash::make($request->input('new_password'));
        }
    
        // Update other fields
        $student->update($validatedData);
    
        // Redirect or respond as needed (e.g., return a success message)
        return redirect()->route('admin_edit_stud', ['student' => $student->id])->with('success', 'Student updated successfully!');
    }


    
    function admin_update_staff(Request $request, $staffId)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email,'. $staffId,
            'name' => 'required|string|max:255|regex:/^[^\d]+$/',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'position' => 'required|string',
            'new_password' => [
                'nullable',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]/',
            ],
        ], [
            'email.regex' => 'The email has already registered!',
            'name.regex' => 'The name field must not contain digits.', 
            'new_password.regex' => "The password must meet the following criteria:\n" .
            "- Be at least 8 characters long.\n" .
            "- Include at least one lowercase letter.\n" .
            "- Include at least one uppercase letter.\n" .
            "- Include at least one digit.\n" .
            "- Include at least one special character (allowed: @, $, !, %, *, ?, &, .).",
        ]);
    
        // Update the student details
        // $user = User::where('id',$staffId)->first();
        // $staff = $staff = Lecturer::where('iduser',$user->id)->first();
        // Check if a new password is provided
                // Update the student details

        $staff = User::findOrFail($staffId);
        if ($request->filled('new_password')) {
            $staff->password = Hash::make($request->input('new_password'));
        }
        $lecturer = Lecturer::where('iduser',$staff->id)->first();
        // Update other fields
        $staff->update($validatedData);
        $lecturer->update(['position'=> $validatedData['position']]);
    
        // Redirect or respond as needed (e.g., return a success message)
        return redirect()->route('admin_edit_staff', ['staff' => $staff->id])->with('success', 'Staff updated successfully!');
    }
    
    

    function admin_destroy_student(Request $request)
    {
        // Find the student with the given ID
        $studentId = $request->input('studentId');
        $student = User::findOrFail($studentId);
    
        // Delete the student
        $student->delete();
    
        // Redirect or respond as needed (e.g., return a success message)
        return response()->json(['success' => true, 'message' => 'Student removed successfully']);

    }

    
    function admin_destroy_staff(Request $request)
    {
        // Find the student with the given ID
        $staffId = $request->input('staffId');
        $user = User::where('id',$staffId)->first();
        $staff = Lecturer::where('iduser',$user->id)->first();
        // Find the associated user
        $staff->delete();

        // Delete the student
        $user->delete();
    
        // Redirect or respond as needed (e.g., return a success message)
        return response()->json(['success' => true, 'message' => 'Staff removed successfully']);

    }
    
}
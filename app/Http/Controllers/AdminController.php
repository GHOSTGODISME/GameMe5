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
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'accountType' => 'required|in:student',
            // Add other validation rules as needed
        ]);

        if ($request->filled('password')) {
            $validatedData['password']  = bcrypt($request->password);
        }

        // Create a new student using the validated data
        $user = User::create($validatedData);

        // Redirect or respond as needed (e.g., return a success message)
        return redirect()->route('admin_stud')->with('success_message', 'Student created successfully');
    }

    function admin_add_staff(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'accountType' => 'required|in:lecturer',
            'position' => 'required|string',
            // Add other validation rules as needed
        ]);

        if ($request->filled('password')) {
            $validatedData['password']  = bcrypt($request->password);
        }
        

        // Create a new user using the validated data
        $user = User::create($validatedData);

        $lecturerData = ['position' => $validatedData['position']];
        $lecturer = Lecturer::create(['iduser' => $user->id] + $lecturerData);

        // Redirect or respond as needed (e.g., return a success message)
        return redirect()->route('admin_staff')->with('success_message', 'Staff created successfully');
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
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $studentId, // Include user ID to exclude the current user from uniqueness check
            'new_password' => 'nullable|string|min:6',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            // Add other validation rules as needed
        ]);
    
        // Update the student details
        $student = User::findOrFail($studentId);
    
        // Check if a new password is provided
        if ($request->filled('new_password')) {
            $student->password = bcrypt($request->input('new_password'));
        }
    
        // Update other fields
        $student->update($validatedData);
    
        // Redirect or respond as needed (e.g., return a success message)
        return redirect()->route('admin_edit_stud', ['student' => $student->id])->with('success_message', 'Student updated successfully');
    }


    
    function admin_update_staff(Request $request, $staffId)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staffId, // Include user ID to exclude the current user from uniqueness check
            'new_password' => 'nullable|string|min:6',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'position' => 'required|string',
            // Add other validation rules as needed
        ]);
    
        // Update the student details
        // $user = User::where('id',$staffId)->first();
        // $staff = $staff = Lecturer::where('iduser',$user->id)->first();
        // Check if a new password is provided
                // Update the student details

        $staff = User::findOrFail($staffId);
        if ($request->filled('new_password')) {
            $staff->password = bcrypt($request->input('new_password'));
        }
        $lecturer = Lecturer::where('iduser',$staff->id)->first();
        // Update other fields
        $staff->update($validatedData);
        $lecturer->update(['position'=> $validatedData['position']]);
    
        // Redirect or respond as needed (e.g., return a success message)
        return redirect()->route('admin_edit_staff', ['staff' => $staff->id])->with('success_message', 'Staff updated successfully');
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
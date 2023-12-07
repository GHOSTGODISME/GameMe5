<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Models\Classlecturer;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class LecturerController extends Controller{

    function lect_homepage(Request $request){
        
        $email = session()->get('email');
        $user = User::where('email', $email)->first();
        $lect = Lecturer::where('iduser', $user->id)->first();
        $searchQuery = $request->input('search');
        $classrooms = Classroom::where('name', 'LIKE', '%' . $searchQuery . '%')->get();
    
        // Get the classes associated with the lecturer
        $lecturerClasses = Classlecturer::where('idlecturer', $lect->id)->pluck('idclass')->toArray();

        // Filter the classrooms to include only those that the lecturer has
        $filteredClassrooms = $classrooms->whereIn('id', $lecturerClasses);

        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();
        Log::info($lecturer);


        $quizzes = Quiz::where('id_lecturer', $lecturer->id);
        $search = $request->input('search');
        if ($search) {
            $quizzes = $quizzes->where('title', 'like', '%' . $search . '%');
        }

        $quizzes = $quizzes->get();

        return view('User/lect_homepage',  ['classrooms' => $filteredClassrooms, 'quizzes' => $quizzes ]);
    }

    function getLectInfo(Request $request)
    {
        // Step 1: Find the use
        $email = $request->session()->get('email');
        //$email='wongtian628@gmail.com';
        $user = User::where('email', $email)->first();
        // Step 2: Check if the user has the account type set to "lecturer"
        if ($user && $user->accountType == 'lecturer') {
            // Step 3: Retrieve additional details from the lecturer table
            $lecturer = Lecturer::where('iduser', $user->id)->first();
    
            // Check if the lecturer is found
            if ($lecturer) {
                // Append user data to the lecturer object
                $lecturer->user = $user;
    
                // Return the combined lecturer object
                return view('User/lect_profile', ['lecturer' => $lecturer]);
            }
        }
        // Return an error or default information if the user is not a lecturer
        return response()->json(['error' => 'User is not a lecturer'], 404);
    }

    public function update_lecturer_position(Request $request)
{
    $email = $request->session()->get('email');
    //$email = 'wongtian628@gmail.com';
    $user = User::where('email', $email)->first();
    
    $request->validate([
        'new_position' => 'required',
    ]);

    $newPosition = $request->input('new_position');
    
    // Find the lecturer by user_id
    $lecturer = Lecturer::where(['iduser' => $user->id])->first();
    
    // Update the position
    $lecturer->position = $newPosition;
    $lecturer->save();
    return response()->json(['success' => 'Lecturer position updated successfully']);
}

}
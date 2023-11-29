<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class LecturerController extends Controller{

    function lect_homepage(){
        return view('User/lect_homepage');
    }

    function getLectInfo()
    {
        // Step 1: Find the use
        // $email = $request->session()->get('email');
        $email='wongtian628@gmail.com';
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
    $email = 'wongtian628@gmail.com';
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
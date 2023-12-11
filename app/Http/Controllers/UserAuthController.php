<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class UserAuthController extends Controller
{

    function login()
    {
        return view('User/login');
    }

    function login_post(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user_account_type = Auth::user()->accountType;

            switch ($user_account_type) {
                case 'student':
                    $request->session()->put('email', $request->email);
                    
                    $email = $request->session()->get('email');
                    $user = User::where('email', $email)->first();
                    $stud = Student::where('iduser', $user->id)->first();

                    $request->session()->put('stud_id', $stud->id);
                    $request->session()->put('stud_name', $user->name);
                    return redirect()->intended(route('stud_homepage'));
                    break;
                case 'lecturer':
                    $request->session()->put('email', $request->email);

                    $email = $request->session()->get('email');
                    $user = User::where('email', $email)->first();
                    $lecturer = Lecturer::where('iduser', $user->id)->first();

                    $request->session()->put('lect_id', $lecturer->id);
                    $request->session()->put('lect_name', $user->name);
                    return redirect()->intended(route('lect_homepage'));
                    break;
                case 'admin':
                    $request->session()->put('email', $request->email);
                    return redirect()->intended(route('admin_stud'));
                    break;
                default:
                    Auth::logout();
                    return redirect(route('login'))->with("error", "Oops, something went wrong!")->withErrors(['email' => 'Invalid credentials']);
            }
        } else {
            return redirect(route('login'))->with("error", "Incorrect username or password")->withErrors(['email' => 'Incorrect username or password!']);
        }
    }


    function signup()
    {
        return view('User/signup_1');
    }

    function signup_2_view()
    {
        return view('User/signup_2');
    }

    function signup_3_view()
    {
        return view('User/signup_3');
    }

    function signup_lecturer_view()
    {
        return view('User/signup_lecturer');
    }


    function signup_1(Request $request)
    {
        // Store data in session for the next step
        $request->session()->put('signup_1', $request->all());
        return redirect()->route('signup_2_view');
    }


    function signup_2(Request $request)
    {
        $data = $request->session()->get('signup_1');
    
        if ($data['accountType'] == "student") {
            $request->validate([
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9]+@(student\.tarc\.edu\.my|tarc\.edu\.my)$/', // Updated regex pattern
                    'unique:users,email', // Check uniqueness in the 'users' table, adjust the table name if needed
                ],
            
            ], [
                'email.regex' => 'The email format for students should be end with @student.tarc.edu.my',
                'email.unique' => 'The email address is already in use.',
            ]);
        } else if($data['accountType'] == "lecturer"){
            $request->validate([
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9]+@tarc\.edu\.my$/', // Updated regex pattern
                    'unique:users,email', // Check uniqueness in the 'users' table, adjust the table name if needed
                ],
            ], [
                'email.regex' => 'The email format for lecturers should be end with @tarc.edu.my',
                'email.unique' => 'The email address is already in use.',
            ]);
        }
    
        $request->session()->put('signup_2', $request->all());

        // Check the validated email type and redirect accordingly
        if ($data['accountType'] == "student") {
            return redirect()->route('signup_3_view');
        } else {
            return redirect()->route('signup_lecturer_view');
        }
    }
    
    public function signup_lecturer(Request $request)
    {
        // Validate and store additional lecturer data
        $request->validate([
            'position' => 'required|string|max:255|regex:/^[^\d]+$/',
            // Add more rules as needed
        ], [
            'position.required' => 'The position field is required.',
            'position.string' => 'The position must be a valid string.',
            'position.max' => 'The position must not exceed 255 characters.',
            'position.regex' => 'The position field must not contain digits.', // Error message for the regex rule
            // Add more error messages as needed
        ]);

        $request->session()->put('lecturer_data', $request->all());
    
        // Proceed to the next step
        return redirect()->route('signup_3_view');
    }

    function signup_post(Request $request)
    {
        // Get data from previous steps
        $step1Data = $request->session()->get('signup_1');
        $step2Data = $request->session()->get('signup_2');

        $request->validate([
            'name' => 'required|string|max:255|regex:/^[^\d]+$/',
            'gender' => 'required|in:male,female',
            'dob' => 'required|date|before:today',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]/',
            ],
        ], [
            'name.regex' => 'The name field must not contain digits.', 
            'password.regex' => "The password must meet the following criteria:\n" .
            "- Be at least 8 characters long.\n" .
            "- Include at least one lowercase letter.\n" .
            "- Include at least one uppercase letter.\n" .
            "- Include at least one digit.\n" .
            "- Include at least one special character (allowed: @, $, !, %, *, ?, &, .).",
        ]);

        // Merge data from all steps
        $data = array_merge($step1Data, $step2Data, $request->all());

        // Additional data modifications
        $data['password'] = Hash::make($request->password);

        // Create user with all data
        $user = User::create($data);
        // Check account type and handle additional steps if needed
        if ($data['accountType'] == 'lecturer') {
            $lecturerData = $request->session()->get('lecturer_data');
            // Save lecturer-specific data to the Lecturer model or perform any additional steps
            Lecturer::create(array_merge(['iduser' => $user->id], $lecturerData));
            $request->session()->forget('lecturer_data');
        } else if ($data['accountType'] == 'student') {
            // Save lecturer-specific data to the Lecturer model or perform any additional steps
            Student::create(['iduser' => $user->id]);
        }

        // Clear session data
        $request->session()->forget(['signup_1', 'signup_2']);

        return redirect()->route('successful_signup_view');
    }

    function successful_signup_view(){
        return view('User/successful_signup');
    }

    function successful_signup()
    {
        return redirect(route('login'));
    }

    function forgetpassword_1()
    {
        return view('User/forgetpassword_1');
    }
    function forgetpassword_2()
    {
        return view('User/forgetpassword_2');
    }
    function forgetpassword_3()
    {
        return view('User/forgetpassword_3');
    }



    function forgetpassword_1_post(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Generate a verification code (you may use a package or create your own logic)
        $verificationCode = self::generateVerificationCode(); // Implement your own logic for generating a code

        // Save the verification code to the user's record in the database or in a temporary storage
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // Handle the case where the user is not found
            return redirect()->route('forgetpassword_1')->withErrors(['email' => 'User not found!']);
        }

        // Store the email in the session
        $request->session()->put('email_for_password_reset', $request->email);
        $user->verification_code = $verificationCode;
        $user->save();
        // Send an email with the verification code
        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
        return redirect()->route('forgetpassword_2');
    }

    static function generateVerificationCode()
    {
        // Generate a 6-digit random code
        $verificationCode = mt_rand(100000, 999999);
        return $verificationCode;
    }


    function forgetpassword_2_post(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|digits:6', // Assuming a 6-digit verification code
        ]);

        // Retrieve the email from the session
        $email = $request->session()->get('email_for_password_reset');

        // Find the user by email
        $user = User::where('email', $email)->first();
        if ($user->verification_code == $request->verification_code) {
            // Verification code is correct, proceed to the next step
            return redirect()->route('forgetpassword_3');
        } 
            
        return redirect()->route('forgetpassword_2')->withErrors(['verification_code' => 'Invalid Verification Code!']);;
        
    }

    function forgetpassword_3_post(Request $request)
    {
        // Retrieve the email from the session
        $email = $request->session()->get('email_for_password_reset');
    
        $request->validate([
            'new_password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]/',
            ],
            'confirm_new_password' => 'required|same:new_password',
        ], [
            'new_password.regex' => "The password must meet the following criteria:\n" .
            "- Be at least 8 characters long.\n" .
            "- Include at least one lowercase letter.\n" .
            "- Include at least one uppercase letter.\n" .
            "- Include at least one digit.\n" .
            "- Include at least one special character (allowed: @, $, !, %, *, ?, &, .).",
            ]);
        // Get the user based on the email
        $user = User::where('email', $email)->first();
        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        // Clear the session data
        $request->session()->forget('email_for_password_reset');
    
        return redirect()->route('forgetpassword_3')->with('success', 'Password reset successful. You can now login with your new password.');
    }

    function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
}

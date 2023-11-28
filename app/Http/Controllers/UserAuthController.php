<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class UserAuthController extends Controller{

    function login(){
        return view('User/login');
    }

    function login_post(Request $request) {
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
                    return redirect()->intended(route('stud_homepage'));
                    break;
                case 'lecturer':
                    $request->session()->put('email', $request->email);
                    return redirect()->intended(route('lect_homepage'));
                    break;
                case 'admin':
                    $request->session()->put('email', $request->email);
                    return redirect()->intended(route('admin'));
                    break;
                default:
                    Auth::logout();
                    return redirect(route('login'))->with("error", "Oops, something went wrong!")->withErrors(['email' => 'Invalid credentials']);
            }
        } else {
            return redirect(route('login'))->with("error", "Invalid credentials")->withErrors(['email' => 'Invalid credentials']);
        }
    }
    

    function signup(){
        return view('User/signup_1');
    }

    function signup_1(Request $request)
    {
        // Store data in session for the next step
        $request->session()->put('signup_1', $request->all());

        // Check account type and redirect accordingly
        $accountType = $request->get('accountType');

        if ($accountType == 'lecturer') {
            return view('User/signup_lecturer', compact('accountType'));
        }

        return view('User/signup_2', compact('accountType'));
    }
    public function signup_lecturer(Request $request)
    {
        // Validate and store additional lecturer data
        $request->validate([
            'position' => 'required',
        ]);
        $request->session()->put('lecturer_data', $request->all());
        // Proceed to the next step
        return view('User/signup_2');
    }

    function signup_2(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        // Store data in session for the next step
        $request->session()->put('signup_2', $request->all());
        return view('User/signup_3');
    }

    function signup_post(Request $request)
    {
        // Get data from previous steps
        $step1Data = $request->session()->get('signup_1');
        $step2Data = $request->session()->get('signup_2');

        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'password' => 'required',
        ]);

        // Merge data from all steps
        $data = array_merge($step1Data, $step2Data, $request->all());

        // Additional data modifications
        $data['password'] = bcrypt($request->password);

        // Create user with all data
        $user = User::create($data);
        // Check account type and handle additional steps if needed
         if ($data['accountType'] == 'lecturer') {
            $lecturerData = $request->session()->get('lecturer_data');
            // Save lecturer-specific data to the Lecturer model or perform any additional steps
            Lecturer::create(array_merge(['iduser' => $user->id], $lecturerData));
            $request->session()->forget('lecturer_data');
        }

        // Clear session data
        $request->session()->forget(['signup_1', 'signup_2']);

    return view('User/successful_signup');
    }

    function successful_signup(){
        return redirect(route('login'));
    }

    function forgetpassword_1(){
        return view('User/forgetpassword_1');
    }
    function forgetpassword_2(){
        return view('User/forgetpassword_2');
    }
    function forgetpassword_3(){
        return view('User/forgetpassword_3');
    }

  

    function forgetpassword_1_post(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Generate a verification code (you may use a package or create your own logic)
        $verificationCode = self::generateVerificationCode();// Implement your own logic for generating a code
    
        // Save the verification code to the user's record in the database or in a temporary storage
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // Handle the case where the user is not found
            return redirect()->route('forgetpassword_1')->with('error', 'User not found.');
        }

        // Store the email in the session
        $request->session()->put('email_for_password_reset', $request->email);
        $user->verification_code = $verificationCode;
        $user->save();
        // Send an email with the verification code
        Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
        return view('User/forgetpassword_2');
    }
    
    static function generateVerificationCode() {
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
            else{
                return redirect()->route('forgetpassword_2');
            }
        
        
    }
    
    function forgetpassword_3_post(Request $request) {
        // Retrieve the email from the session
        $email = $request->session()->get('email_for_password_reset');
    
        $request->validate([
            'new_password' => 'required|min:6',  // You can adjust the validation rules as needed
            'confirm_new_password' => 'required|same:new_password',
        ]);
    
        // Get the user based on the email
        $user = User::where('email', $email)->first();
        // Update the user's password
        $user->password = bcrypt($request->new_password);
        $user->save();
    
        // Clear the session data
        $request->session()->forget('email_for_password_reset');
    
        return view('User/login')->with('success', 'Password reset successful. You can now login with your new password.');
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

}
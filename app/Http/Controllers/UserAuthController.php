<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserAuthController extends Controller{

    function login(){
        return view('User/login');
    }

    function login_post(Request $request){
    $request->validate([
    'email' => 'required',
    'password' => 'required'
    ]);
    
    $credentials = $request->only('email', 'password');
    if(Auth::attempt($credentials)) {
        $user_role=Auth::user()->role;

        switch($user_role) {
            case 0:
                return redirect()->intended(route('stud_homepage'));
                break;
            case 1:
                return redirect()->intended(route('lecturer'));
                break;
            case 2:
                return redirect()->intended(route('admin'));
                break;
            default:
                Auth::logout();
                return redirect(route('login'))->with("error", "Oops something went wrong!");
        }
    }
    return redirect(route('login'))->with("error", "Login details are not valid.");
    }

    function signup(){
        return view('User/signup');
    }
    function signup_post(Request $request) {
      $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        return redirect(route('login'))->with("success", "You have signed up successfully, now you can login to your account.");
    }

    function logout(){
        Session::flush();
        Auth::logout();
        return redirect(route('home'));
    }

}
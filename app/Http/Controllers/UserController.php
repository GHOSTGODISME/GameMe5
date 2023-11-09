<?php

namespace App\Http\Controllers;

class UserController extends Controller{

    function login(){
        return view('User/login');
    }

}
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Homepage*/
Route::get('/', function () {
    return view('User/login');
});

/*User Authentication*/
/*Login*/
Route::get('login',[UserAuthController::class, 'login'])->name('login');
Route::post('login',[UserAuthController::class, 'login_post'])->name('login_post');

/*Sign Up*/
Route::get('signup',[UserAuthController::class, 'signup'])->name('signup');
Route::post('signup',[UserAuthController::class, 'signup_post'])->name('signup_post');

/*Forgot Password*/
Route::get('forgetpassword', function () {
    return view('User/forgetpassword');
});

/*Logout*/
Route::get('logout',[UserAuthController::class, 'logout'])->name('logout');

/*User*/
/*Student*/
//Homepage
Route::get('stud_homepage',[StudentController::class, 'stud_homepage'])->name('stud_homepage');
//Profile
Route::get('stud_profile',[StudentController::class, 'stud_profile'])->name('stud_profile');

/*Lecturer*/
//Homepage
Route::get('lect_homepage',[LecturerController::class, 'lect_homepage'])->name('lect_homepage');
//Profile
Route::get('lect_profile',[LecturerController::class, 'lect_profile'])->name('lect_profile');

/*Admin*/
//Homepage
Route::get('admin_homepage',[AdminController::class, 'admin_homepage'])->name('admin_homepage');

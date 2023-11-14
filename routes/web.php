<?php


use App\Http\Controllers\FortuneWheelController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LecturerController;
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
    return view('home');
        //return view('survey/survey-main');
    // return view('quiz/quiz-edit');
    //return view('Interactive-tools/fortune-wheel-main');
    // return view('survey/survey');
    // return view('interactive-tools/fortune-wheel');
});

/*User Authentication*/
/*Login*/
Route::get('login',[UserAuthController::class, 'login'])->name('login');
Route::post('login',[UserAuthController::class, 'login_post'])->name('login_post');

/*Sign Up*/
Route::get('signup_1',[UserAuthController::class, 'signup'])->name('signup');
Route::post('signup_1',[UserAuthController::class, 'signup_1'])->name('signup_1');
Route::post('signup_2',[UserAuthController::class, 'signup_2'])->name('signup_2');
Route::post('signup_lecturer', [UserAuthController::class, 'signup_lecturer'])->name('signup_lecturer');
Route::post('signup_3',[UserAuthController::class, 'signup_post'])->name('signup_post');

/*Forgot Password*/
Route::get('forgetpassword_1', [UserAuthController::class, 'forgetpassword_1'])->name('forgetpassword_1');
Route::get('forgetpassword_2', [UserAuthController::class, 'forgetpassword_2'])->name('forgetpassword_2');
Route::get('forgetpassword_3', [UserAuthController::class, 'forgetpassword_3'])->name('forgetpassword_3');
Route::post('forgetpassword_1', [UserAuthController::class, 'forgetpassword_1_post'])->name('forgetpassword_1_post');
Route::post('forgetpassword_2', [UserAuthController::class, 'forgetpassword_2_post'])->name('forgetpassword_2_post');
Route::post('forgetpassword_3', [UserAuthController::class, 'forgetpassword_3_post'])->name('forgetpassword_3_post');

/*Logout*/
Route::post('logout',[UserAuthController::class, 'logout'])->name('logout');

/*User*/
/*Student*/
//Homepage
Route::get('stud_homepage',[StudentController::class, 'stud_homepage'])->name('stud_homepage');
//Profile
Route::get('stud_profile',[StudentController::class, 'getStudInfo'])->name('stud_profile');
Route::post('update_profile', [StudentController::class, 'update_profile'])->name('update_profile');
Route::post('upload_profile_picture', [StudentController::class, 'upload_profile_picture'])->name('upload_profile_picture');
Route::post('check_password', [StudentController::class, 'check_password'])->name('check_password');
Route::post('update_password', [StudentController::class, 'update_password'])->name('update_password');

/*Lecturer*/
//Homepage
Route::get('lect_homepage',[LecturerController::class, 'lect_homepage'])->name('lect_homepage');
//Profile
Route::get('lect_profile',[LecturerController::class, 'getLectInfo'])->name('lect_profile');
Route::post('update_lecturer_position',[LecturerController::class, 'update_lecturer_position'])->name('update_lecturer_position');
/*Admin*/
//Homepage
Route::get('admin_stud',[AdminController::class, 'admin_stud'])->name('admin_stud');
Route::get('admin_stud_search', [AdminController::class, 'admin_stud'])->name('admin_stud_search');

Route::get('admin_staff',[AdminController::class, 'admin_staff'])->name('admin_staff');
Route::get('admin_staff_search', [AdminController::class, 'admin_staff'])->name('admin_staff_search');

Route::get('admin_add_student',[AdminController::class, 'admin_add_stud'])->name('admin_add_stud');
Route::post('admin_add_student',[AdminController::class, 'admin_add_student'])->name('admin_add_student');


Route::get('admin/edit-student/{student}', [AdminController::class,'admin_edit_stud'])->name('admin_edit_stud');
Route::post('admin/update-student/{student}', [AdminController::class,'admin_update_student'])->name('admin_update_student');

Route::get('admin_add_staffs',[AdminController::class, 'admin_add_staffs'])->name('admin_add_staffs');
Route::post('admin_add_staff',[AdminController::class, 'admin_add_staff'])->name('admin_add_staff');

Route::get('admin_edit_staff/{staff}',[AdminController::class, 'admin_edit_staff'])->name('admin_edit_staff');
Route::post('admin_update_staff/{staff}',[AdminController::class, 'admin_update_staff'])->name('admin_update_staff');

Route::post('admin_destroy_student',[AdminController::class, 'admin_destroy_student'])->name('admin_destroy_student');
Route::post('admin_destroy_staff',[AdminController::class, 'admin_destroy_staff'])->name('admin_destroy_staff');


/////// kel

// fortune wheel related routes
Route::get('/fortune-wheel-main', [FortuneWheelController::class, 'index'])->name('fortune-wheel-main');
Route::post('/create-fortune-wheel', [FortuneWheelController::class, 'createFortuneWheel'])->name('create-fortune-wheel');
Route::get('/edit-fortune-wheel/{id}', [FortuneWheelController::class, 'editFortuneWheel'])->name('edit-fortune-wheel');
Route::delete('/delete-fortune-wheel/{id}', [FortuneWheelController::class, 'deleteFortuneWheel'])->name('delete-fortune-wheel');
Route::post('/save-fortune-wheel', [FortuneWheelController::class, 'updateFortuneWheel']);


Route::resource('questions', QuestionController::class);
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/save-question', [QuestionController::class, 'saveQuestion']);
Route::get('/quiz-edit', [QuestionController::class, 'showAllQuestion'])->name('quiz-edit');


//survey related
Route::get('/survey-index', [SurveyController::class, 'index'])->name('survey-index');
Route::get('/create-survey', [SurveyController::class, 'create'])->name('create-survey');
Route::get('/edit-survey/{id}', [SurveyController::class, 'edit'])->name('edit-survey');
Route::delete('/delete-survey/{id}', [SurveyController::class, 'delete'])->name('delete-survey');
Route::post('/save-survey', [SurveyController::class, 'store']);

Route::get('get-survey/{id}', [SurveyController::class, 'getSurvey']);

Route::get('/student-view-survey/{id}', [SurveyController::class, 'studentResponse'])->name('student-view-survey');
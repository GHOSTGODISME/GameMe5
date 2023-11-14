<?php

use App\Http\Controllers\FortuneWheelController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
     return view('home');
    //return view('survey/survey-main');
    // return view('quiz/quiz-edit');
    //return view('Interactive-tools/fortune-wheel-main');
    // return view('survey/survey');
    // return view('interactive-tools/fortune-wheel');
});

Route::get('login',[UserController::class, 'login'])->name('login');


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

// Route::get('/survey/create', [SurveyController::class, 'create']);
// Route::get('/survey/{id}/edit', [SurveyController::class, 'edit']);
// Route::post('/survey', [SurveyController::class, 'store']);






// Route::get('/edit-post/{post}', [FortuneWheelController::class, 'showEditScreen']);
// Route::put('/edit-post/{post}', [FortuneWheelController::class, 'actuallyUpdatePost']);
// Route::delete('/delete-post/{post}', [FortuneWheelController::class, 'deletePost']);

// https://github.com/LearnWebCode/youtube-laravel-demo/blob/main/routes/web.php
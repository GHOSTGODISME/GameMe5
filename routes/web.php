<?php

use App\Http\Controllers\FortuneWheelController;
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
    // return view('home');
    return view('quiz/quiz-edit');
    //return view('Interactive-tools/fortune-wheel-main');
    // return view('survey/survey');
    // return view('interactive-tools/fortune-wheel');
});

Route::get('login',[UserController::class, 'login'])->name('login');
// Route::get('direct',[FortuneWheelController::class, 'direct'])->name('direct');
// Route::get('showWheel',[FortuneWheelController::class, 'showWheel'])->name('showWheel');
Route::get('createWheel',[FortuneWheelController::class, 'index'])->name('createWheel');

// Route::get('showWheel', [FortuneWheelController::class, 'showWheel']);


// fortune wheel related routes
Route::post('/create-fortune-wheel', [FortuneWheelController::class, 'createFortuneWheel']);
Route::post('/update-fortune-wheel/{id}', [FortuneWheelController::class, 'updateFortuneWheel']);
Route::get('/fortune-wheel-main', [FortuneWheelController::class, 'showFortuneWheelMain'])->name('fortune-wheel-main');
Route::get('/edit-fortune-wheel/{id}', [FortuneWheelController::class, 'editFortuneWheel'])->name('editFortuneWheel');
Route::delete('/delete-fortune-wheel/{id}', [FortuneWheelController::class, 'deleteFortuneWheel'])->name('deleteFortuneWheel');


// Route::get('/edit-post/{post}', [FortuneWheelController::class, 'showEditScreen']);
// Route::put('/edit-post/{post}', [FortuneWheelController::class, 'actuallyUpdatePost']);
// Route::delete('/delete-post/{post}', [FortuneWheelController::class, 'deletePost']);

// https://github.com/LearnWebCode/youtube-laravel-demo/blob/main/routes/web.php
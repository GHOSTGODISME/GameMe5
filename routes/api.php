<?php

use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/api/quiz/questions/{code}', [QuizController::class, 'getQuizQuestions']);
// Route::get('/quiz/details/{code}', [QuizController::class, 'getQuizDetails']);
// Route::get('/quiz/questions/{code}', [QuizController::class, 'getQuizQuestions']);


Route::post('/register-name', [QuizSessionController::class, 'registerUsername']);
Route::post('/store-individual-response', [QuizSessionController::class, 'storeIndividualResponse']);
Route::post('/check-user-qualification',[QuizSessionController::class, 'checkUserQualification']);
Route::post('/store-quiz-response', [QuizSessionController::class, 'storeQuizResponse']);
Route::post('/store-full-responses', [QuizSessionController::class, 'storeFullResponses']);
// routes/api.php

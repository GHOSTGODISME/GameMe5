<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizSession;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class QuizSessionController extends Controller
{

    public function createQuizSession(Request $request)
    {
        /// Retrieve and decode JSON data
        // $data = json_decode($request->getContent(), true);
        Log::info('Request Data: ' . json_encode($request->all()));

        $data = $request->validate([
            'quizSessionSetting' => 'required',
            'quizId' => 'required'
        ]);

        Log::info('0');
        $session = Session::create([
            'code' => mt_rand(100000, 999999),
            'start_time' => now(),
            'end_time' => null,
            'status' => "created",
        ]);
        Log::info('1');

        // Create a quiz session using the relationship
        $quizSession = $session->quizSessions()->create([
            'quiz_id' => $data['quizId']
        ]);
        Log::info('2');

        // Create quiz session settings for the quiz session
        $quizSessionSetting = $quizSession->quizSessionSetting()->create([
            'show_leaderboard_flag' => $data['quizSessionSetting']['showLeaderboard'],
            'shuffle_option_flag' => $data['quizSessionSetting']['shuffleQuestion'],
        ]);

        Log::info('3');
        // Handle response
        // return redirect()->route('quiz-session-lecturer', ['sessionCode' => $session->code])->send();
        // return view('/quiz/quiz-session-lecturer');
        // return view('quiz.quiz-session-lecturer')->send();
        // return redirect()->route('quiz-session-lecturer', ['sessionCode' => $session->code])->send();
        return response()->json(['sessionCode' => $session->code]);

    }
    
    // public function startSession(Request $request, $sessionCode) {
    //     Log::info('Session Code: ' . $sessionCode);
    //     return view('quiz.quiz-session-lecturer', compact('sessionCode'))->send;
    // }

    public function startSession($sessionCode) {
        Log::info('Session Code: ' . $sessionCode);
        return view('quiz.quiz-session-lecturer', compact('sessionCode'));
    }

    public function startSession1() {
        return view('quiz.quiz-session-lecturer');
        // return view('quiz.test');
    }

    public function getLeaderboard(){
        return view('quiz.leaderboard-lecturer');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizSession;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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

        $session = Session::create([
            'code' => mt_rand(100000, 999999),
            'start_time' => now(),
            'end_time' => null,
            'status' => "waiting",
            'quiz_id' => $data['quizId'],
        ]);
        
        // Create quiz session settings for the quiz session
        $quizSessionSetting = $session->quizSessionSetting()->create([
            'show_leaderboard_flag' => $data['quizSessionSetting']['showLeaderboard'],
            'shuffle_option_flag' => $data['quizSessionSetting']['shuffleOptions'],
        ]);

                // Handle response
        return response()->json(['sessionCode' => $session->code, 'sessionId' => $session->id]);
    }
    
    public function startSession($sessionId) {
        $session = Session::find($sessionId);

        if ($session) {
            $session->status = 'started';
            $session->save();
        }
        $qrCodeContent = QrCode::size(150)->generate('localhost:8000/join-quiz?code=' . $session->code);

        return view('quiz.quiz-session-lecturer', ['qrCodeContent' => $qrCodeContent]);
    }
    public function getLeaderboard(){
        return view('quiz.leaderboard-lecturer');
    }

    public function endSession(Request $request, $sessionId)
    {
        // Find the session by ID and update its status to "ended"
        $session = Session::find($sessionId);

        if ($session) {
            $session->status = 'ended';
            $session->end_time = now();
            $session->save();

            return response()->json(['message' => 'Session ended successfully'], 200);
        } else {
            return response()->json(['message' => 'Session not found'], 404);
        }
    }
    
    public function getQuizSessionSettings($sessionId){
        $session = Session::find($sessionId);
        $sessionSettings = $session->quizSessionSetting;

        return response()->json(['sessionSettings' => $sessionSettings], 200); 
    }
    public function getQuizQuestionsBySessionId($sessionId)
    {
        // Retrieve the session based on the session ID
        $session = Session::with('quiz.quiz_questions')->find($sessionId);

        if (!$session) {
            return response()->json(['message' => 'Session not found'], 404);
        }

        $quizQuestions = $session->quiz->quiz_questions ?? [];
        $userResponses = $session->quizResponses->flatMap(function ($quizResponse) {
            return $quizResponse->quizResponseDetails->map(function ($quizResponseDetail) use ($quizResponse) {
                return [
                    'answeredOption' => $quizResponseDetail->user_response ?: [],
                    'correctness' => $quizResponseDetail->correctness,
                    'questionId' => $quizResponseDetail->question_id,
                    'timeTaken' => $quizResponseDetail->time_usage,
                    'userId' => $quizResponse->user_id,
                    'username' => $quizResponse->username,
                ];
            });
        });
    
        return response()->json([
            'quizQuestions' => $quizQuestions,
            'userResponses' => $userResponses,
        ], 200);   
     }
}

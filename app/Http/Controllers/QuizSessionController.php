<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Quiz;
use App\Models\Session;
use App\Models\QuizQuestion;
use App\Models\QuizResponse;
use Illuminate\Http\Request;
use App\Jobs\SendQuizSummaryEmail;
use App\Models\QuizResponseDetails;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Session as LaravelSession;


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

    public function endSession($sessionId)
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

    public function getLeaderboard(){
        return view('quiz.leaderboard-lecturer');
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

     public function joinQuiz(Request $request)
     {
         $code = $request->input('code');
 
         $session = Session::where('code', $code)
             ->where('status', '!=', 'ended') 
             ->first();
 
         if ($session) {
             return view('quiz.spa', ['sessionCode' => $code]);
         } else {
             LaravelSession::flash('error', 'Please enter a valid session code.');
             return redirect()->to('/');
         }
     }
     public function registerUsername(Request $request)
     {
         $validatedData = $request->validate([
             'username' => 'required|string|max:255', // Validation rules for username
             'sessionId' => 'required|exists:sessions,id', // Validation for session existence
             'userId' => 'required'
             // Add more validation rules if needed
         ]);
 
         $session = Session::findOrFail($validatedData['sessionId']);
 

         $quizResponse = $session->quizResponses()->create([
             'username' => $validatedData['username'],
             'accuracy' => null, 
             'correct_answer_count' => null,
             'incorrect_answer_count' => null,
             'total_points' => null,
             'average_time' => null,
             'user_id' => $validatedData['userId'],
         ]);
 
         return response()->json(['message' => 'Username registered successfully']);
     }
 
     public function getQuizDetails($code)
     {
         
         $session = Session::where('code', $code)
             ->with('quiz')
             ->first();
 
         Log::info('Request Data: ' . $session);
         
         if ($session && $session->quiz) {
             return response()->json(['session_id' => $session->id, 
             'quiz' => $session->quiz]); 
         }
 
         return response()->json(['error' => 'Quiz details not found'], 404);
     }
 
     public function getQuizQuestions($quizId)
     {
         $questions = QuizQuestion::where('quiz_id', $quizId)->get();
 
         if ($questions->isEmpty()) {
             return response()->json(['error' => 'Quiz questions not found for this quiz ID'], 404);
         }
 
         return response()->json($questions);
     }
     public function storeIndividualResponse(Request $request)
     {
         // Retrieve data from the request
         $sessionId = $request->input('session_id');
         $quizId = $request->input('quiz_id');
         $userId = $request->input('user_id');
         $questionId = $request->input('question_id');
         $timeTaken = $request->input('time_taken');
         $userResponse = $request->input('user_response');
         $correctness = $request->input('correctness');
         $points = $request->input('points');
 
         // Find or create a session
         $session = Session::firstOrCreate(['id' => $sessionId]);
 
         // Check if a quiz response exists for this user session
         $quizResponse = $session->quizResponses()->firstOrCreate(['user_id' => $userId]);
 
         $userResponseData = $userResponse ? json_encode($userResponse) : null;
 
         // Create a new quiz response details associated with the quiz response
         $quizResponseDetails = new QuizResponseDetails([
             'question_id' => $questionId,
             'user_response' => $userResponseData,
             'correctness' => $correctness,
             'time_usage' => $timeTaken,
             'points' => $points,
         ]);
         $quizResponse->quizResponseDetails()->save($quizResponseDetails);
 
         return response()->json(['message' => 'Individual response stored successfully']);
     }
 
     public function storeQuizResponse(Request $request)
     {
         // Validate incoming request data here if needed
         $sessionId = $request->input('session_id');
         $userId = $request->input('user_id');
 
         $existingResponse = QuizResponse::where('session_id', $sessionId)
             ->where('user_id', $userId)
             ->first();
 
         if ($existingResponse) {
             // Update the existing QuizResponse record
             $existingResponse->update([
                 'accuracy' => $request->input('accuracy'),
                 'correct_answer_count' => $request->input('correct_answer_count'),
                 'incorrect_answer_count' => $request->input('incorrect_answer_count'),
                 'total_points' => $request->input('total_points'),
                 'average_time' => $request->input('average_time'),
             ]);
 
             return response()->json(['message' => 'Quiz response updated successfully']);
         } else {
             QuizResponse::create([
                 'session_id' => $sessionId,
                 'username' => $request->input('username'),
                 'user_id' => $userId,
                 'accuracy' => $request->input('accuracy'),
                 'correct_answer_count' => $request->input('correct_answer_count'),
                 'incorrect_answer_count' => $request->input('incorrect_answer_count'),
                 'total_points' => $request->input('total_points'),
                 'average_time' => $request->input('average_time'),
             ]);
 
             return response()->json(['message' => 'Quiz response stored successfully']);
         }
     }
 
     public function storeFullResponses(Request $request)
     {
         Log::info('Request Data: ' . json_encode($request->all()));
 
         $data = $request->all();
 
         try {
             $sessionId = $data['sessionId'];
             $userId = $data['userId'];
             $responses = $data['responses'];
 
             // Find or create a quiz response record based on session and user
             $session = Session::findOrFail($sessionId);
             $quizResponse = $session->quizResponses()->firstOrCreate(['user_id' => $userId]);
 
             foreach ($responses as $response) {
                 $userResponse = $response['user_response'];
                 $userResponseData = $userResponse ? json_encode($userResponse) : null;
 
                 $questionId = $response['question_id'];
                 $userResponse = $userResponseData;
                 $correctness = $response['correctness'];
                 $timeUsage = $response['time_usage'];
 
                 // Check if the QuizResponseDetails record already exists for the given response
                 $existingResponse = QuizResponseDetails::where('quiz_response_id', $quizResponse->id)
                     ->where('question_id', $questionId)
                     ->first();
 
                 if (!$existingResponse) {
                     QuizResponseDetails::create([
                         'quiz_response_id' => $quizResponse->id,
                         'question_id' => $questionId,
                         'user_response' => $userResponse,
                         'correctness' => $correctness,
                         'time_usage' => $timeUsage,
                     ]);
                 }
             }
 
             return response()->json(['message' => 'Individual responses stored successfully']);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Failed to store full responses'], 500);
         }
     }
 
     public function fetchData(Request $request, $userId, $sessionId, $quizId)
     {
         $quiz = Quiz::with('quiz_questions')->findOrFail($quizId);
 
         // Fetch the quiz responses for the given session
         $quizResponses = QuizResponse::where('session_id', $sessionId)->get();
 
         // Calculate the rank based on total points for the given session
         $sortedQuizResponses = $quizResponses->sortByDesc('total_points')->values();
         $rank = $sortedQuizResponses->search(function ($item) use ($userId) {
             return $item->user_id == $userId;
         });
 
         $quizResponse = QuizResponse::with('quizResponseDetails')
             ->where('user_id', $userId)
             ->where('session_id', $sessionId)
             ->first();
 
         $totalParticipants = QuizResponse::where('session_id', $sessionId)->count();
 
         // If the quizResponse is found, return it with associated details
         if ($quizResponse) {
             return response()->json([
                 'quiz' => $quiz,
                 'quizResponse' => $quizResponse,
                 'totalParticipants' => $totalParticipants,
                 'rank' => $rank !== false ? $rank + 1 : null,
             ]);
         }
 
         // If no data is found, return an empty response or appropriate message
         return response()->json(['message' => 'No data found for the given user and session.'], 404);
     }
 
     public function showQuizSummary($userId, $sessionId, $quizId)
     {
         return view('quiz.quiz-summary', compact('userId', 'sessionId', 'quizId'));
     }
 
     public function generatePDF($userId, $sessionId, $quizId)
     {
         $response = $this->fetchData(request(), $userId, $sessionId, $quizId);
         $data = json_decode($response->getContent());
 
         $generatedDate = Carbon::now()->format('Y-m-d H:i:s');
 
         // Create an instance of the Dompdf class
         $dompdf = new Dompdf();
 
         // (Optional) Setup the options
         $options = new Options();
         $options->set('isHtml5ParserEnabled', true);
         $options->set('enable_javascript', true);
         $options->set('isRemoteEnabled', true);
         $dompdf->setOptions($options);
 
         // Load HTML content (replace this with your HTML)
         $html = view('Pdf.quiz-summary-pdf-template', compact('data', 'generatedDate'))->render();
         // Load HTML to Dompdf
         $dompdf->loadHtml($html);
 
         // (Optional) Set paper size and orientation
         $dompdf->setPaper('A4', 'portrait');
 
         // Render PDF (generates the PDF)
         $dompdf->render();
 
         // Output PDF
         return $dompdf->stream("quiz_summary_{$generatedDate}.pdf");
         // return $dompdf;
         }
 
     public function sendEmail($userId, $sessionId, $quizId)
     {
         $pdfContent = $this->fetchData(request(), $userId, $sessionId, $quizId);
         // $user = User::findOrFail($userId);
     
         // if ($user) {
         //     SendQuizSummaryEmail::dispatch($user->email, $pdfContent);
         // }
 
         SendQuizSummaryEmail::dispatch("ming.fai2002@gmail.com", $pdfContent);
     }


}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Session;
use App\Models\Lecturer;
use App\Models\QuizQuestion;
use App\Models\QuizResponse;
use Illuminate\Http\Request;
use App\Models\Classlecturer;
use App\Jobs\SendQuizSummaryEmail;
use App\Models\QuizResponseDetails;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Session as LaravelSession;


class QuizSessionController extends Controller
{

    public function createQuizSession(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();

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
            'lecture_id' => $lecturer->id,
        ]);

        // Create quiz session settings for the quiz session
        $quizSessionSetting = $session->quizSessionSetting()->create([
            'show_leaderboard_flag' => $data['quizSessionSetting']['showLeaderboard'],
            'shuffle_option_flag' => $data['quizSessionSetting']['shuffleOptions'],
        ]);
        // Handle response
        return response()->json(['sessionCode' => $session->code, 'sessionId' => $session->id]);
    }


    public function getLecturerClasses(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();
        $lecturerClasses = Classlecturer::with('class')->where('idlecturer', $lecturer->id)->get();
        return response()->json(['lecturerClasses' => $lecturerClasses]);
    }

    public function startSession($sessionId)
    {
        $session = Session::find($sessionId);

        if ($session) {
            $session->status = 'started';
            $session->save();
        }
        $qrCodeContent = QrCode::size(150)->generate('localhost:8000/join-quiz?code=' . $session->code);

        return view('Quiz.quiz-session-lecturer', ['qrCodeContent' => $qrCodeContent]);
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

    public function getLeaderboard()
    {
        return view('Quiz.leaderboard-lecturer');
    }

    public function getQuizSessionSettings($sessionId)
    {
        $session = Session::find($sessionId);
        $sessionSettings = $session->quizSessionSetting;

        return response()->json(['sessionSettings' => $sessionSettings], 200);
    }
    public function getQuizQuestionsBySessionId($sessionId)
    {
        // Retrieve the session based on the session ID
        $session = Session::with('Quiz.quiz_questions')->find($sessionId);

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
        $request->validate([
            'code' => [
                'required',
                'exists:sessions,code',
                function ($attribute, $value, $fail) {
                    $session = Session::where('code', $value)->first();
        
                    if ($session && $session->status === 'ended') {
                        $fail('The selected session has already ended.');
                    }
                },
            ],
        ]);
        
        
        $code = $request->input('code');
    
        $session = Session::where('code', $code)->first();
    
        if ($session) {
            if ($session->status === 'ended') {
                // If the session has ended, return an error message
                LaravelSession::flash('error', 'The session has ended.');
                return response()->json(['message' => 'Session has ended']);
            } else {
                // If the session is active, load the Quiz.spa view
                return view('Quiz.spa', ['sessionCode' => $code]);
            }
        } else {
            LaravelSession::flash('error', 'Please enter a valid session code.');
            return response()->json(['message' => 'Invalid code']);
        }
    }
    
    public function registerUsername(Request $request)
    {
        // $email = $request->session()->get('email');
        // $user = User::where('email', $email)->first();
        // $stud = Student::where('iduser', $user->id)->first();
        // $student = Student::with('classrooms')->find($stud->id);

        $validatedData = $request->validate([
            'username' => 'required|string|max:255', // Validation rules for username
            'sessionId' => 'required|exists:sessions,id', // Validation for session existence
            'userId' => 'required|exists:users,id'
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
            // 'user_id' => $student->id,
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
            return response()->json([
                'session_id' => $session->id,
                'quiz' => $session->quiz
            ]);
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

    public function checkUserQualification(Request $request){
        $session_id = $request->input('session_id');
        $user_id = $request->input('user_id');

        $completedQuizResponse = QuizResponse::where('session_id', $session_id)
            ->where('user_id', $user_id)
            ->whereNotNull('accuracy') // Assuming accuracy is only recorded upon completion
            ->first();

        return response()->json($completedQuizResponse ? true : false);
    }
    
    public function storeIndividualResponse(Request $request)
    {
        // $email = $request->session()->get('email');
        // $user = User::where('email', $email)->first();
        // $stud = Student::where('iduser', $user->id)->first();
        // $student = Student::with('classrooms')->find($stud->id);

        // Retrieve data from the request
        $sessionId = $request->input('session_id');
        // $quizId = $request->input('quiz_id');
        $userId = $request->input('user_id');
        // $userId = $student->id;
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
        // $email = $request->session()->get('email');
        // $user = User::where('email', $email)->first();
        // $stud = Student::where('iduser', $user->id)->first();
        // $student = Student::with('classrooms')->find($stud->id);
        
        // Validate incoming request data here if needed
        $sessionId = $request->input('session_id');
        // $userId = $request->$student->id;

        $existingResponse = QuizResponse::where('session_id', $sessionId)
        // ->where('user_id', $userId)
        ->where('user_id', $request->input('user_id'))
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
                'user_id' => $request->input('user_id'),
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
        // $email = $request->session()->get('email');
        // $user = User::where('email', $email)->first();
        // $stud = Student::where('iduser', $user->id)->first();
        // $student = Student::with('classrooms')->find($stud->id);
        
        // Log::info('Request Data: ' . json_encode($request->all()));

        $data = $request->all();

        try {
            $sessionId = $data['sessionId'];
            $userId = $data['userId'];
            // $userId = $student->id;
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
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
        $student = Student::with('classrooms')->find($stud->id);

        $userId = $student->id;

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

    public function showQuizSummary(Request $request, $userId, $sessionId, $quizId)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
        $student = Student::with('classrooms')->find($stud->id);

        $userId = $student->id;

        $quiz = Quiz::find($quizId);
        $quizTitle = $quiz->title;

        return view('Quiz.quiz-summary', compact('userId', 'sessionId', 'quizId', 'quizTitle'));
    }

    public function generatePDF(Request $request, $userId, $sessionId, $quizId)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
        $student = Student::with('classrooms')->find($stud->id);
        $userId = $student->id;

        $response = $this->fetchData(request(), $userId, $sessionId, $quizId);
        $data = json_decode($response->getContent());

        $generatedDate = Carbon::now()->format('Y-m-d H:i:s');

        // Create an instance of the Dompdf class
        $dompdf = new Dompdf();

        // Setup the options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('enable_javascript', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        // Load HTML content 
        $html = view('Pdf.quiz-summary-pdf-template', compact('data', 'generatedDate'))->render();

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (generates the PDF)
        $dompdf->render();

        // Output PDF
        return $dompdf->stream("quiz_summary_{$generatedDate}.pdf");
    }

    public function sendEmail(Request $request, $userId, $sessionId, $quizId)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
        $student = Student::with('classrooms')->find($stud->id);
        $userId = $student->id;

        $pdfContent = $this->fetchData(request(), $userId, $sessionId, $quizId);

        $user = User::find($userId);
        if ($user) {
            SendQuizSummaryEmail::dispatch($user->email, $pdfContent);
        }
    }
}

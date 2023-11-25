<?php

namespace App\Http\Controllers;

use App\Events\ParticipantJoined;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizResponse;
use App\Models\QuizResponseDetails;
use App\Models\QuizSession;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session as LaravelSession;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::all();
        return view('quiz.index', ['quizzes' => $quizzes]);
    }

    public function create()
    {
        $quiz = new Quiz();
        $mode = 'create';
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        return view('quiz.quiz-edit', compact('quiz', 'questions', 'mode'));

        // return view('quiz.quiz-edit', compact('quiz'));
    }

    public function view($id)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        $mode = 'view';
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        return view('quiz.quiz-edit', compact('quiz', 'questions', 'mode'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        $mode = 'edit';
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        return view('quiz.quiz-edit', compact('quiz', 'questions', 'mode'));
    }

    public function store(Request $request)
    {
        Log::info('Request Data: ' . json_encode($request->all()));

        // Validate incoming request data
        $data = $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'visibility' => 'required|string',
            // Include other necessary validations for form fields
        ]);

        Log::info('data: ' . json_encode($data));

        if (isset($data['id'])) {
            $quiz = Quiz::find($data['id']);
            $quiz->update($data);
            Log::info('updated: ' . $quiz);
        } else {
            $quiz = Quiz::create($data);
            Log::info('created: ' . $quiz);
        }

        // Get the questions data from the request
        $questionsData = collect($request->input('quiz_questions'));
        Log::info('questionsData: ' . $questionsData);

        // Get IDs of the received questions
        $receivedQuestionIds = $questionsData->pluck('id')->toArray();

        // Get existing question IDs related to this survey
        $existingQuestionIds = $quiz->quiz_questions->pluck('id')->toArray();

        // Find IDs of questions to delete
        $questionsToDelete = array_diff($existingQuestionIds, $receivedQuestionIds);

        // Delete existing questions that are not in the received data
        QuizQuestion::whereIn('id', $questionsToDelete)->delete();

        // Loop through received questions and update/create as necessary
        foreach ($questionsData as $questionData) {
            $existingQuestion = QuizQuestion::find($questionData['id']);

            if ($existingQuestion) {
                Log::info('existing: ');
                // Update the existing question
                $existingQuestion->update([
                    'title' => $questionData['title'],
                    'type' => $questionData['type'],
                    'options' => $questionData['options'] ?? null,
                    'correct_ans' => $questionData['correct_ans'] ?? null,
                    'answer_explaination' => $questionData['answer_explaination'] ?? null,
                    'single_ans_flag' => $questionData['single_ans_flag'] ?? null,
                    'points' => $questionData['points'] ?? null,
                    'duration' => $questionData['duration'] ?? null,
                    'index' => $questionData['index'] ?? 0,
                ]);
            } else {
                Log::info('not existing: ');
                // Create a new question
                $question = new QuizQuestion([
                    'title' => $questionData['title'],
                    'type' => $questionData['type'],
                    'options' => $questionData['options'] ?? null,
                    'correct_ans' => $questionData['correct_ans'] ?? null,
                    'answer_explaination' => $questionData['answer_explaination'] ?? null,
                    'single_ans_flag' => $questionData['single_ans_flag'] ?? null,
                    'points' => $questionData['points'] ?? null,
                    'duration' => $questionData['duration'] ?? null,
                    'index' => $questionData['index'] ?? 0,
                ]);

                Log::info('question: ' . json_encode($question));
                $quiz->quiz_questions()->save($question);
            }
        }
    }

    public function show($id)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);

        return view('play_quiz', ['quizData' => $quiz]);
    }

    public function joinQuiz(Request $request)
    {
        $code = $request->input('code');

        $session = Session::where('code', $code)
            ->where('status', '!=', 'ended') // Check if the session status is not "ended"
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
            // Add more validation rules if needed
        ]);

        $session = Session::findOrFail($validatedData['sessionId']);

        // Create QuizResponse associated with the session
        $quizResponse = $session->quizResponses()->create([
            'username' => $validatedData['username'],
            'accuracy' => null, // Initialize other fields if needed
            'correct_answer_count' => null,
            'incorrect_answer_count' => null,
            'total_points' => null,
            'average_time' => null,
            'user_id' => null,
            // Add other fields as needed
        ]);

        return response()->json(['message' => 'Username registered successfully']);
    }

    public function getQuizDetails($code)
    {
        $session = Session::where('code', $code)->with('quiz')->first();

        if ($session && $session->quiz) {
            return response()->json(['session_id' => $session->id, 'quiz' => $session->quiz]); // Return quiz details as JSON
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
                'username' =>  $request->input('username'),
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

}

<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        return view('quiz.quiz-edit', compact('quiz', 'questions','mode'));

        // return view('quiz.quiz-edit', compact('quiz'));
    }

    public function view($id)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        $mode = 'view';
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        return view('quiz.quiz-edit', compact('quiz', 'questions','view'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        $mode = 'edit';
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        return view('quiz.quiz-edit', compact('quiz', 'questions','edit'));
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
                    'answer_explanation' => $questionData['answer_explaination'] ?? null,
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
                    'answer_explanation' => $questionData['answer_explaination'] ?? null,
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

    public function joinQuiz(Request $request)
    {
        $code = $request->input('code');

    if ($code) {
        return view('quiz.spa', ['sessionCode' => $code]);

    } else {
        return redirect()->route('quiz-index')->with('error', 'Please enter a valid session code.');
    }
    }

    public function show($id)
    {
        // Logic for fetching and displaying the Play Quiz Screen
        // Fetch questions, options, etc., based on $quiz_id
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);

        return view('play_quiz', ['quizData' => $quiz]);
    }

//     public function getQuizDetails($code)
// {
//     $quiz = Quiz::first(); // Example: Fetch quiz details from the database based on the code

//     // Return the quiz details as JSON response
//     return response()->json($quiz);
// }

public function getQuizDetails($code)
{
    $quiz = Quiz::first(); 
    return response()->json($quiz);
}

public function getQuizQuestions($code)
{
    $quiz = Quiz::with('quiz_questions')->first();
    // $quiz = Quiz::with('quiz_questions')->findOrFail($id);
    $questions = $quiz->quiz_questions; 

    return response()->json($questions);
}



    public function submitAnswer(Request $request)
    {
        // Logic to process submitted answers and move to the next stage
        // Validate answers, calculate scores, etc.
        // Return JSON response or redirect as needed
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\Classlecturer;
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
        $questions = $quiz->quiz_questions; 

        return view('quiz.edit', compact('quiz', 'questions', 'mode'));
    }

    public function view($id, Request $request)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        $mode = 'view';
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();
    
        $lecturerClasses = Classlecturer::with('class')->where('idlecturer', $lecturer->id)->get();
        
        return view('quiz.edit', compact('quiz', 'questions', 'mode','lecturerClasses'));
    }

    public function edit($id, Request $request)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        $mode = 'edit';
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();
        $lecturerClasses = Classlecturer::with('class')->where('idlecturer', $lecturer->id)->get();

        return view('quiz.edit', compact('quiz', 'questions', 'mode','lecturerClasses'));
    }

    public function store(Request $request)
    {
        Log::info('Request Data: ' . json_encode($request->all()));

        $data = $request->validate([
            'id' => 'nullable|integer',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'visibility' => 'required|string',
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

    public function search(Request $request){
        $search = $request->input('search');

        $quizzes = Quiz::when($search, function ($query) use ($search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->get();

        return view('quiz.index', compact('quizzes'));
    }
    
}

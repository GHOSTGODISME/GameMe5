<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\Classlecturer;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index_own_quiz(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();
        Log::info($lecturer);


        $quizzes = Quiz::where('id_lecturer', $lecturer->id);
        $search = $request->input('search');
        if ($search) {
            $quizzes = $quizzes->where('title', 'like', '%' . $search . '%');
        }

        $quizzes = $quizzes->get();
        return view('quiz.index-own-quiz', ['quizzes' => $quizzes]);
    }

    public function index_all_quiz(Request $request)
    {
        $quizzes = Quiz::where('visibility', 'public')->get();
        $search = $request->input('search');

        if ($request->has('search')) {
            $quizzes = $quizzes->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })->get();
        }

        return view('quiz.index-all-quiz', ['quizzes' => $quizzes]);
    }

    public function create(Request $request)
    {
        $quiz = new Quiz();
        $mode = 'create';
        $questions = $quiz->quiz_questions;

        return view('quiz.edit', compact('quiz', 'questions', 'mode'));
    }

    public function view(Request $request, $id)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();
        Log::info($lecturer);

        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        if($quiz->id_lecturer === $lecturer->id) {
            $mode = 'view';
        }else{
            $mode = 'viewWithRestriction';
        }
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        return view('quiz.edit', compact('quiz', 'questions', 'mode'));
    }

    public function edit(Request $request, $id)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        $mode = 'edit';
        $questions = $quiz->quiz_questions; // Retrieve the related question
        return view('quiz.edit', compact('quiz', 'questions', 'mode'));
    }

    public function store(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();

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
            $quiz = Quiz::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'visibility' =>$data['visibility'],
                'id_lecturer' => $lecturer->id,
            ]);
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
                    'id_lecturer' => $lecturer->id,
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
                    'id_lecturer' => $lecturer->id,
                ]);

                Log::info('question: ' . json_encode($question));
                $quiz->quiz_questions()->save($question);
            }
        }
    }

    public function delete($id)
    {
        // Find the quiz by ID
        $quiz = Quiz::find($id);

        // Check if the fortune wheel exists
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found.'], 404);
        }

        $quiz->quiz_questions()->delete();

        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted successfully.']);
    }
}

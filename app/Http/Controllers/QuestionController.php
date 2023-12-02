<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Quiz;

class QuestionController extends Controller
{
    public function create($id)
    {
        $quiz = Quiz::findOrFail($id);
        $question = new QuizQuestion();
        //$question->save();
        $question = new QuizQuestion(['quiz_id' => $id]); // Set quiz_id if provided, or leave it null
        return view('quiz.question-edit', compact('quiz','question'));
    }

    public function store(Request $request)
    {
        // Validation logic goes here

        // Create a new question instance and save it to the database
        QuizQuestion::create([
            'title' => $request->input('quiz_title'),
            'type' => $request->input('quiz-type'),
            // Add other fields as needed
        ]);

        // Redirect or respond as needed
        return redirect()->back();
    }

    public function saveQuestion(Request $request)
    {
            Log::info('Request Data: ' . json_encode($request->all()));

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'type' => 'required|string',
            'options' => 'nullable|array', // Add more validation rules as needed
            'correct_ans' => 'required|array',
            'answer_explanation' => 'nullable|string',
            'single_ans_flag' => 'nullable|boolean',
            'points' => 'required|integer',
            'duration' => 'required|integer',
            'quiz_id' => 'required|integer'
        ]);

        // Create a new question instance and fill it with the validated data
        $question = new QuizQuestion($validatedData);
    // Save the question to the database and associate it with the related quiz
        $quiz = Quiz::findOrFail($validatedData['quiz_id']); // Retrieve the quiz using the provided quiz_id
        $quiz->quizQuestions()->save($question);

        // Save the question to the database
        // $question->save();

        return response()->json(['message' => 'Question saved successfully']);
    }

    public function showAllQuestion()
    {
        $questions = QuizQuestion::all();
        return view('quiz.quiz-edit', ['questions' => $questions]);
    }

}

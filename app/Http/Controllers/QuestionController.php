<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function create()
    {
        $question = new Question();
        //$question->save();
        return view('quiz.question-edit', compact('question'));
    }

    public function store(Request $request)
    {
        // Validation logic goes here

        // Create a new question instance and save it to the database
        Question::create([
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
        ]);

        // Create a new question instance and fill it with the validated data
        $question = new Question($validatedData);

        // Save the question to the database
        $question->save();

        return response()->json(['message' => 'Question saved successfully']);
    }

    public function showAllQuestion()
    {
        $questions = Question::all();
        return view('quiz.quiz-edit', ['questions' => $questions]);
    }

}

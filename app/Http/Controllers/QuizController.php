<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

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
        $quiz->save();
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        return view('quiz.quiz-edit', compact('quiz','questions'));

        // return view('quiz.quiz-edit', compact('quiz'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);
        $questions = $quiz->quiz_questions; // Retrieve the related questions

        return view('quiz.quiz-edit', compact('quiz', 'questions'));
    }

    public function joinQuiz(){
        return view("join_quiz");
    }

    public function show($id)
    {
        // Logic for fetching and displaying the Play Quiz Screen
        // Fetch questions, options, etc., based on $quiz_id
        $quiz = Quiz::with('quiz_questions')->findOrFail($id);

        return view('play_quiz', ['quizData' => $quiz]);
    }

    public function submitAnswer(Request $request)
    {
        // Logic to process submitted answers and move to the next stage
        // Validate answers, calculate scores, etc.
        // Return JSON response or redirect as needed
    }

}

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


        // Pass the survey and its responses data to the view for rendering
        // return view('survey.edit', compact('survey', 'surveyResponses'));

    }

}

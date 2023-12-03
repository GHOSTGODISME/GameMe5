<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Session;
use App\Models\Lecturer;
use App\Models\QuizQuestion;
use App\Models\QuizResponse;
use Illuminate\Http\Request;
use App\Models\QuizResponseDetails;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class ReportController extends Controller{

    function report_home(Request $request){
        // Assuming Session is an Eloquent model and Quiz is the model for quizzes table
        $query = Session::query()
            ->join('quizzes', 'sessions.quiz_id', '=', 'quizzes.id'); // Join the quizzes table

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where('quizzes.title', 'like', '%' . $searchTerm . '%'); // Specify the table name for the 'title' column
        }

        $sessionData = $query->get(['sessions.*', 'quizzes.title as quiz_title']); // Include the 'quizzes.title' in the selected columns

        return view('Report/report_home', compact('sessionData'));
    }


    function report_specify($reportId){
        // Assuming Session is an Eloquent model
        $report = Session::find($reportId);
        $quesCount = QuizQuestion::where('quiz_id', $report->quiz->id)->count();
        $totalPlayer = QuizResponse::where('session_id', $reportId)->count();
        $averageSessionScore = QuizResponse::where('session_id', $reportId)
        ->selectRaw('AVG(accuracy) as average_session_score') // Calculate the average of average scores
        ->value('average_session_score');

        $average_time = QuizResponse::where('session_id', $reportId)
        ->selectRaw('AVG(average_time) as average_time') // Calculate the average of average scores
        ->value('average_time');

        $quizResponses = QuizResponse::with('quizResponseDetails.question')
        ->where('session_id', $reportId)
        ->get();

$difficultQuestions = collect();

foreach ($quizResponses as $quizResponse) {
    $questionDetails = $quizResponse->quizResponseDetails;

    foreach ($questionDetails as $detail) {
        $questionId = $detail->question_id;

        if (!$difficultQuestions->has($questionId)) {
            $averageCorrectness = $questionDetails
                ->where('question_id', $questionId)
                ->avg('correctness');

            $averageTimeUsage = $questionDetails
                ->where('question_id', $questionId)
                ->avg('time_usage');

            if ($averageCorrectness <= 0.3) {
                $difficultQuestions->put($questionId, [
                    'question' => $detail->question,
                    'average_correctness' => $averageCorrectness,
                    'average_time_usage' => $averageTimeUsage,
                ]);
            }
        }
    }
}

$nhPlayers = QuizResponse::where('session_id', $reportId)
    ->where(function ($query) {
        $query->where('accuracy', '<=', 30);
    })
    ->get();

         return view('Report/report_specify', compact('report','quesCount','totalPlayer','averageSessionScore','average_time','difficultQuestions','nhPlayers'));
     }

}
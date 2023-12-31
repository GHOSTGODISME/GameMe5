<?php

namespace App\Http\Controllers;

use App\Exports\SurveyResponsesExport;
use App\Jobs\SendSurveyResponseEmail;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\SurveyResponseQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;


class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();

        $surveys = Survey::where('id_lecturer', $lecturer->id)->get();
        return view('Survey.index', ['surveys' => $surveys]);
    }

    public function create()
    {
        $survey = new Survey();
        $mode = 'create';
        return view('Survey.edit', compact('survey', 'mode'));
    }

    public function view($id)
    {
        $survey = Survey::with('surveyQuestions')->findOrFail($id);

        $mode = 'view';
        return view('Survey.edit', compact('survey', 'mode'));
    }


    public function edit($id)
    {
        $survey = Survey::with('surveyQuestions')->findOrFail($id);
        $mode = 'edit';
        Log::info('survey: ' . json_encode($survey->all()));

        // Retrieve all responses for the specific survey ID along with related question responses
        $surveyResponses = SurveyResponse::with('surveyResponseQuestions.surveyQuestion')
            ->where('survey_id', $id)
            ->get();

        $uniqueTitles = SurveyResponseQuestion::whereIn('survey_response_id', $surveyResponses->pluck('id'))
            ->distinct('survey_question_id')
            ->pluck('survey_question_id');

        $uniqueQuestions = SurveyQuestion::whereIn('id', $uniqueTitles)->get(['id', 'title']);

        // Pass the survey and its responses data to the view for rendering
        return view('Survey.edit', compact('survey', 'surveyResponses', 'uniqueQuestions', 'mode'));
    }

    public function delete($id)
    {
        // Find the survey by ID
        $survey = Survey::find($id);

        // Check if the survey exists
        if (!$survey) {
            return response()->json(['message' => 'Survey not found.'], 404);
        }

        // Delete the survey
        $survey->surveyQuestions()->delete();

        $survey->delete();

        return response()->json(['message' => 'Survey deleted successfully.']);
    }

    public function store(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();

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
            $survey = Survey::find($data['id']);
            $survey->update($data);
            Log::info('updated: ' . $survey);
        } else {
            $survey = Survey::create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'visibility' => $data['visibility'],
                'id_lecturer' => $lecturer->id,
            ]);
        }

        // Get the questions data from the request
        $questionsData = collect($request->input('questions'));
        Log::info('questionsData: ' . $questionsData);

        // 'id_lecturer' => $lecturer->id,


        // Get IDs of the received questions
        $receivedQuestionIds = $questionsData->pluck('id')->toArray();

        // Get existing question IDs related to this survey
        $existingQuestionIds = $survey->surveyQuestions->pluck('id')->toArray();

        // Find IDs of questions to delete
        $questionsToDelete = array_diff($existingQuestionIds, $receivedQuestionIds);

        // Delete existing questions that are not in the received data
        SurveyQuestion::whereIn('id', $questionsToDelete)->delete();

        // Loop through received questions and update/create as necessary
        foreach ($questionsData as $questionData) {
            $existingQuestion = SurveyQuestion::find($questionData['id']);

            if ($existingQuestion) {
                Log::info('existing: ');
                // Update the existing question
                $existingQuestion->update([
                    'title' => $questionData['title'],
                    'type' => $questionData['type'],
                    'description' => $questionData['description'] ?? null,
                    'options' => $questionData['options'] ?? null,
                    'placeholder' => $questionData['placeholder'] ?? null,
                    'prefilled_value' => $questionData['prefilled_value'] ?? null,
                    'scale_min_label' => $questionData['scale_min_label'] ?? null,
                    'scale_max_label' => $questionData['scale_max_label'] ?? null,
                    'scale_min_value' => $questionData['scale_min_value'] ?? null,
                    'scale_max_value' => $questionData['scale_max_value'] ?? null,
                    'index' => $questionData['index'] ?? 0,
                ]);
            } else {
                Log::info('not existing: ');
                // Create a new question
                $question = new SurveyQuestion([
                    'title' => $questionData['title'],
                    'type' => $questionData['type'],
                    'description' => $questionData['description'] ?? null,
                    'options' => $questionData['options'] ?? null,
                    'placeholder' => $questionData['placeholder'] ?? null,
                    'prefilled_value' => $questionData['prefilled_value'] ?? null,
                    'scale_min_label' => $questionData['scale_min_label'] ?? null,
                    'scale_max_label' => $questionData['scale_max_label'] ?? null,
                    'scale_min_value' => $questionData['scale_min_value'] ?? null,
                    'scale_max_value' => $questionData['scale_max_value'] ?? null,
                    'index' => $questionData['index'] ?? 0,
                ]);

                Log::info('question: ' . json_encode($question));
                $survey->surveyQuestions()->save($question);
            }
        }

        // Return a response indicating success or failure
        return response()->json(['message' => 'Survey created or updated successfully', 'survey' => $survey]);
    }

    public function search(Request $request)
    {
        $email = $request->session()->get('email');
        $user = User::where('email', $email)->first();
        $lecturer = Lecturer::where('iduser', $user->id)->first();

        $surveys = Survey::where('id_lecturer', $lecturer->id);

        $search = $request->input('search');
        if ($search) {
            $surveys = $surveys->where('title', 'like', '%' . $search . '%');
        }

        $surveys = $surveys->get();
        return view('Survey.index', ['surveys' => $surveys]);
    }

    public function getSurvey($id)
    {
        // Fetch the survey details by ID from the database
        $survey = Survey::find($id);

        if (!$survey) {
            return response()->json(['message' => 'Survey not found'], 404);
        }

        // Return the survey details as JSON response
        return response()->json($survey);
    }

    public function studentResponse(Request $request, $id)
    {
        $survey = Survey::with('surveyQuestions')->findOrFail($id);
        return view('Survey.student-view', ['survey' => $survey]);
    }

    public function storeResponse(Request $request)
    {
        $email = session('email');
        $user = User::where('email', $email)->first();
        $stud = Student::where('iduser', $user->id)->first();
        $student = Student::with('classrooms')->find($stud->id);

        try {
            // Validate incoming request data
            $data = $request->validate([
                'surveyResponse.id' => 'nullable|integer',
                'surveyResponse.survey_id' => 'required|integer',
                'surveyResponse.user_id' => 'nullable|integer',
                'surveyResponse.question_response' => 'required|array',
                'surveyResponse.question_response.*.question_id' => 'required|integer',
                'surveyResponse.question_response.*.answer' => 'required',
                'imageData' => 'required',
            ]);

            $this->returnSurvey($student->id, $data['imageData']);

            $survey = Survey::findOrFail($data['surveyResponse']['survey_id']);
            $response = new SurveyResponse([
                'survey_id' => $survey->id,
                'user_id' => $student->id,
            ]);

            // Loop through each question response and save it
            foreach ($data['surveyResponse']['question_response'] as $questionResponse) {
                $savedResponse = $survey->surveyResponses()->save($response);

                $savedResponse->surveyResponseQuestions()->create([
                    'survey_question_id' => $questionResponse['question_id'],
                    'answers' => $questionResponse['answer'],
                ]);
            }
            // Return a success response or redirect
            return response()->json(['message' => 'Survey response saved']);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showResponses($id)
    {
        // Retrieve all responses for a specific survey ID along with related question responses
        $surveyResponses = SurveyResponse::with('question_responses.survey_question')
            ->where('survey_id', $id)
            ->get();

        // Pass the $surveyResponses data to the view for rendering
        return view('Survey.show-responses', ['surveyResponses' => $surveyResponses]);
    }



    public function returnSurvey($userId, $imageData)
    {
        $user = User::find($userId);
        if ($user) {
            SendSurveyResponseEmail::dispatch($user->email, $imageData);
        } 
    }

    public function exportSurveyResponses($surveyId)
    {
        $surveyResponses = SurveyResponse::where('survey_id', $surveyId)->get();

        $uniqueTitles = SurveyResponseQuestion::whereIn('survey_response_id', $surveyResponses->pluck('id'))
            ->distinct('survey_question_id')
            ->pluck('survey_question_id');
        $uniqueQuestions = SurveyQuestion::whereIn('id', $uniqueTitles)->get(['id', 'title']);


        $headings = ['No', 'Name', 'Email', 'Responded Time'];
        foreach ($uniqueQuestions as $question) {
            $headings[] = $question->title;
        }

        $data = [];

        foreach ($surveyResponses as $index => $response) {

            $responseData = [
                'No' => $index + 1,
                'Name' => $response->user->name,
                'Email' => $response->user->email,
                'Responded Time' => $response->created_at,
            ];

            foreach ($response->surveyResponseQuestions as $questionResponse) {
                if (is_array($questionResponse->answers)) {
                    $responseData[] = implode(', ', $questionResponse->answers);
                } else {
                    $responseData[] = $questionResponse->answers;
                }
            }
            $data[] = $responseData;
        }

        // Export data to Excel using Maatwebsite\Excel package
        return Excel::download(new SurveyResponsesExport($data, $headings), 'survey_responses.xlsx');
    }
}

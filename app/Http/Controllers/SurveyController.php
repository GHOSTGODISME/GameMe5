<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\SurveyResponseQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all(); // Retrieve all surveys from the database
        // return view('survey.index', compact('surveys'));
        return view('survey.index', ['surveys' => $surveys]);
    }

    public function create()
    {
        $survey = new Survey();
        $mode = 'create';
        return view('survey.edit', compact('survey','mode'));
    }

    public function view($id)
    {
        $survey = Survey::with('surveyQuestions')->findOrFail($id);
        $mode = 'view';
        return view('survey.edit', compact('survey','mode'));
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
        return view('survey.edit', compact('survey', 'surveyResponses', 'uniqueQuestions', 'mode'));
    }

    public function delete($id)
    {
        // Find the fortune wheel by ID
        $survey = Survey::find($id);

        // Check if the fortune wheel exists
        if (!$survey) {
            return response()->json(['message' => 'Survey not found.'], 404);
        }

        // Delete the fortune wheel
        $survey->surveyQuestions()->delete(); // Assuming 'questions()' defines the relationship

        $survey->delete();

        return response()->json(['message' => 'Survey deleted successfully.']);
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
            $survey = Survey::find($data['id']);
            $survey->update($data);
            Log::info('updated: ' . $survey);
        } else {
            $survey = Survey::create($data);
            Log::info('created: ' . $survey);
        }

        // Get the questions data from the request
        $questionsData = collect($request->input('questions'));
        Log::info('questionsData: ' . $questionsData);

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

    public function studentResponse($id)
    {
        $survey = Survey::with('surveyQuestions')->findOrFail($id);
        return view('survey.student-view', ['survey' => $survey]);
    }

    public function storeResponse(Request $request)
    {
        Log::info('Request Data: ' . json_encode($request->all()));
        try {
            // Validate incoming request data
            $data = $request->validate([
                'id' => 'nullable|integer',
                'survey_id' => 'required|integer',
                'user_id' => 'nullable|integer',
                'question_response' => 'required|array',
                'question_response.*.question_id' => 'required|integer',
                'question_response.*.answer' => 'required', // Add necessary validation rules for the answer
                // Include other necessary validations for form fields
            ]);

            Log::info('data: ' . json_encode($data));

            $survey = Survey::findOrFail($data['survey_id']);
            $response = new SurveyResponse([
                'survey_id' => $survey->id,
                'user_id' => $data['user_id'], // Assuming user ID is obtained from the request
            ]);

            // Loop through each question response and save it
            foreach ($data['question_response'] as $questionResponse) {
                $savedResponse = $survey->surveyResponses()->save($response);
                Log::info('questionResponse: ' . json_encode($questionResponse));

                $savedResponse->surveyResponseQuestions()->create([
                    'survey_question_id' => $questionResponse['question_id'],
                    'answers' => $questionResponse['answer'],
                ]);
            }
            // Optionally return a success response or redirect
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
        return view('survey.show-responses', ['surveyResponses' => $surveyResponses]);
    }
}
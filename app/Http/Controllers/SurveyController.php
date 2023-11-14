<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
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
        return view('survey.edit', compact('survey'));
    }

    public function edit($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);
        return view('survey.edit', compact('survey'));
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
        $survey->questions()->delete(); // Assuming 'questions()' defines the relationship

        $survey->delete();

        return response()->json(['message' => 'Survey deleted successfully.']);
    }

    public function store(Request $request)
    {
        Log::info('Request Data: ' . json_encode($request->all()));

        // Validate incoming request data
        $data = $request->validate([
            'id'=> 'nullable|integer',
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

        }else{
            $survey = Survey::create($data);
            Log::info('created: ' . $survey);
        }

        // Get the questions data from the request
        $questionsData = $request->input('questions');

        foreach ($questionsData as $questionData) {
            // Check if the question already exists based on some unique identifier (e.g., title)
            $existingQuestion = SurveyQuestion::where('id', $questionData['id'])->first();
            if ($existingQuestion) {
                // If the question exists, update it
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
                    'properties' => $questionData['properties'] ?? null,
                    'index' => $questionData['index'] ?? 0,
                ]);
            } else {
                // If the question doesn't exist, create a new one
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
                    'properties' => $questionData['properties'] ?? null,
                    'index' => $questionData['index'] ?? 0,
                ]);

                $survey->questions()->save($question);
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

    public function studentResponse($id){
        $survey = Survey::with('questions')->findOrFail($id);
        return view('survey.student-view', ['survey' => $survey]);
    }
}

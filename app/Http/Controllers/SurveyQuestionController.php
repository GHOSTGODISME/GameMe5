<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyQuestionController extends Controller
{
    public function store(Request $request, Survey $survey)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string',
            'description' => 'string|nullable',
            'options' => 'json|nullable',
            'placeholder' => 'string|nullable',
            'prefilled_value' => 'string|nullable',
            'scale_min_label' => 'string|nullable',
            'scale_max_label' => 'string|nullable',
            'scale_min_value' => 'required|string',
            'scale_max_value' => 'required|string',
            'properties' => 'string',
        ]);

        $question = $survey->surveyQuestions()->create($data);

        return response()->json(['message' => 'Question created successfully', 'question' => $question]);
    }
}

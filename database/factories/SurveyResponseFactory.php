<?php

namespace Database\Factories;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyResponse>
 */
class SurveyResponseFactory extends Factory
{
    protected $model = SurveyResponse::class;

    public function definition()
    {
        $lastSurvey = Survey::latest()->first(); 
        $surveyId = $lastSurvey ? $lastSurvey->id : null;

        return [
            'survey_id' => Survey::factory()->create()->id,
            'user_id' => 1, 
        ];
    }

}

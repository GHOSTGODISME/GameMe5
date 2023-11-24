<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\SurveyResponseQuestion;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a sample survey
        $survey = Survey::factory()->create([
            'title' => 'Sample Survey',
            'description' => 'This is a sample survey.',
            'visibility' => 'public',
        ]);

        // Generate questions for the survey
        $questions = SurveyQuestion::factory()->count(5)->create([
            'survey_id' => $survey->id,
        ]);

        // Generate responses for the survey
        $responses = SurveyResponse::factory()->count(10)->create([
            'survey_id' => $survey->id,
        ]);

        // For each response, generate response questions
        $responses->each(function ($response) use ($questions) {
            $responseQuestions = $questions->map(function ($question) {
                return SurveyResponseQuestion::factory()->make([
                    'survey_question_id' => $question->id,
                ])->toArray();
            });

            $response->surveyResponseQuestions()->createMany($responseQuestions);
        });
    }
}
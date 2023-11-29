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
    // public function run()
    // {
    //     // Create a sample survey
    //     $survey = Survey::factory()->create([
    //         'title' => 'Sample Survey',
    //         'description' => 'This is a sample survey.',
    //         'visibility' => 'public',
    //     ]);

    //     // Generate questions for the survey
    //     $questions = SurveyQuestion::factory()->count(5)->create([
    //         'survey_id' => $survey->id,
    //     ]);

    //     // Generate responses for the survey
    //     $responses = SurveyResponse::factory()->count(10)->create([
    //         'survey_id' => $survey->id,
    //     ]);

    //     // For each response, generate response questions
    //     $responses->each(function ($response) use ($questions) {
    //         $responseQuestions = $questions->map(function ($question) {
    //             return SurveyResponseQuestion::factory()->make([
    //                 'survey_question_id' => $question->id,
    //             ])->toArray();
    //         });

    //         $response->surveyResponseQuestions()->createMany($responseQuestions);
    //     });
    // }

    public function run()
    {
        // Create a survey
        $survey = Survey::create([
            'title' => 'Sample Survey',
            'description' => 'This is a sample survey for demonstration purposes',
            'visibility' => 'public',
        ]);

        // Create survey questions related to the survey
        $questions = [
            [
                'type' => 0,
                'title' => 'Enter your name',
                'index' => 1,
            ],
            [
                'type' => 1,
                'title' => 'Choose your favorite color',
                'options' => ['Red', 'Blue', 'Green'],
                'index' => 2,
            ],
            [

                'type' => 2,
                'title' => 'Choose your favorite color',
                'options' => ['Red', 'Blue', 'Green'],
                'index' => 3,
            ],
            [
                'type' => 4,
                'title' => 'Rate your experience (from 1 to 10)',
                'scale_min_label' => 'Poor',
                'scale_max_label' => 'Excellent',
                'scale_min_value' => 1,
                'scale_max_value' => 10,
                'index' => 4,
            ],
        ];

        $response = SurveyResponse::factory()->create(['survey_id' => $survey->id]);

        foreach ($questions as $questionData) {
            $surveyQuestion = $survey->surveyQuestions()->create($questionData);

            $responseQuestionData = [
                'survey_response_id' => $response->id,
                'survey_question_id' => $surveyQuestion->id,
                'answers' => $this->generateAnswers($surveyQuestion->type),
            ];

            SurveyResponseQuestion::factory()->create($responseQuestionData);
        }
    }


    private function generateAnswers($type)
    {
        // Add logic to generate answers based on question type
        if ($type === 0) {
            return 'John Doe';
        } elseif ($type === 1 || $type === 2) {
            return ['Red'];
        } elseif ($type === 4) {
            return rand(1, 10);
        }

        return null;
    }
}

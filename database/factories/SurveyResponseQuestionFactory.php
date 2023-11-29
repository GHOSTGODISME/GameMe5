<?php

namespace Database\Factories;

use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyResponseQuestion>
 */
class SurveyResponseQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Define your logic for creating survey response questions
        return [
            'survey_response_id' => function () {
                return SurveyResponse::factory()->create()->id;
            },
            'survey_question_id' => function () {
                return SurveyQuestion::factory()->create()->id;
            },
            'answers' => $this->generateAnswers($this->faker->numberBetween(0, 4)),
        ];
    }

    private function generateAnswers($type)
    {
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

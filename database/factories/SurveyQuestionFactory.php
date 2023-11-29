<?php

namespace Database\Factories;

use App\Models\SurveyQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyQuestion>
 */
class SurveyQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = SurveyQuestion::class;
    public function definition(): array
    {
        $type = $this->faker->numberBetween(0, 4); // Generating a random type between 0 to 4
        $title = $this->faker->sentence;
        $description = $this->faker->paragraph;
        $options = null;
        $placeholder = null;
        $prefilledValue = null;
        $scaleMinLabel = null;
        $scaleMaxLabel = null;
        $scaleMinValue = null;
        $scaleMaxValue = null;
        $index = SurveyQuestion::count() + 1;

        if ($type === 0) {
            $placeholder = $this->faker->word;
            $prefilledValue = $this->faker->sentence;
        } elseif ($type === 1 || $type === 2) {
            $options = $this->generateOptions($this->faker->numberBetween(2, 5));
        } elseif ($type === 3) {
            $scaleMinLabel = $this->faker->word;
            $scaleMaxLabel = $this->faker->word;
            $scaleMinValue = $this->faker->numberBetween(1, 10);
            $scaleMaxValue = $this->faker->numberBetween(1, 10);
        }

        return [
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'options' => $options,
            'placeholder' => $placeholder,
            'prefilled_value' => $prefilledValue,
            'scale_min_label' => $scaleMinLabel,
            'scale_max_label' => $scaleMaxLabel,
            'scale_min_value' => $scaleMinValue,
            'scale_max_value' => $scaleMaxValue,
            'index' => $index,
            'survey_id' => 1, // Replace this with the appropriate survey ID
        ];
    }

    private function generateOptions($count)
    {
        $options = [];
        for ($i = 0; $i < $count; $i++) {
            $options[] = $this->faker->word;
        }
        return $options;
    }

}

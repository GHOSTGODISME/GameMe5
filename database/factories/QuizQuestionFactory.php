<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QuizQuestion;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizQuestion>
 */
class QuizQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizQuestion::class;

    private $currentIndex = 0;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement([0, 1, 2]); // Randomly select question type by number
        $options = $this->generateOptions($type);
        $correctAns = $this->generateCorrectAnswerBasedOnType($type, $options);

        return [
            'title' => $this->faker->sentence,
            'type' => $type,
            'options' => $options,
            'correct_ans' => $correctAns,
            'answer_explaination' => $this->faker->paragraph,
            'single_ans_flag' => $this->getSingleAnswerFlag($type),
            'points' => $this->faker->randomElement([10, 15, 30]),
            'duration' => $this->faker->randomElement([10, 15, 30]),
            'index' => $this->getIndexIncrementally(),
        ];
    }

    // Generate options based on question type
    function generateOptions($type) {
        switch ($type) {
            case 0: // Multiple Choice
                return ['Option 1', 'Option 2', 'Option 3', 'Option 4'];
            case 1: // True/False
                return ['True', 'False'];
            case 2: // Text Input
                return [];
            default:
                return null;
        }
    }

    // Generate correct answer based on question type and available options
    function generateCorrectAnswerBasedOnType($type, $options) {
        switch ($type) {
            case 0: // Multiple Choice
                $singleAnswerFlag = $this->faker->boolean; // Randomly decide single answer or not
                if ($singleAnswerFlag) {
                    return [Arr::random($options)];
                } else {
                    return Arr::random($options, $this->faker->numberBetween(2, count($options)));
                }
            case 1: // True/False
                return ['True']; // For true/false, set 'True' as the correct answer
            case 2: // Text Input
                $randomWord = $this->generateRandomWord(6); // Generate a random word with 6 characters
                return [$randomWord];
            default:
                return null;
        }
    }

    // Get single answer flag based on question type
    function getSingleAnswerFlag($type) {
        switch ($type) {
            case 0: // Multiple Choice
                return $this->faker->boolean;
            case 1: // True/False
                return true; // For true/false, single answer flag is always true
            case 2: // Text Input
                return null; // For text input, single answer flag is null
            default:
                return null;
        }
    }

    // Generate index incrementally
    private function getIndexIncrementally() {
        if ($this->currentIndex === 0) {
            $this->currentIndex = 0; // Reset currentIndex for new quizzes
        }
        return $this->currentIndex++;
    }

    //generete random words in defined length
    function generateRandomWord($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomWord = '';
        for ($i = 0; $i < $length; $i++) {
            $randomWord .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomWord;
    }
}
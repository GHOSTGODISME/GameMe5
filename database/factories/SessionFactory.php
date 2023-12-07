<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->randomElement(['pending', 'started', 'ended']);
        $quizId = Quiz::inRandomOrder()->first()->id;

        return [
            'code' => $this->faker->randomNumber(6),
            'lecture_id' => 1,
            'start_time' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'end_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'status' => $status,
            'quiz_id' => $quizId,
        ];
    }

}

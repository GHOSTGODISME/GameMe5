<?php

namespace Database\Factories;

use App\Models\FortuneWheel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FortuneWheel>
 */
class FortuneWheelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FortuneWheel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3), // Generate a random title
            'entries' => $this->generateRandomEntries(), // Generate random entries
            'results' => $this->generateRandomResults(), // Generate random results
        ];
    }

    /**
     * Generate random entries.
     *
     * @return array
     */
    private function generateRandomEntries()
    {
        // Customize the logic to generate random entries
        $entries = [];
        for ($i = 0; $i < rand(2, 5); $i++) {
            $entries[] = $this->faker->word;
        }
        return $entries;
    }

    /**
     * Generate random results.
     *
     * @return array
     */
    private function generateRandomResults()
    {
        // Customize the logic to generate random results
        $results = [];
        for ($i = 0; $i < rand(1, 3); $i++) {
            $results[] = $this->faker->word;
        }
        return $results;
    }
}
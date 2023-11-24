<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Quiz::create([
        //     'title' => 'quiz 1',
        //     'description' => 'Description for post 1',
        //     'visibility' => 'public'
        // ]);

        // Create three sample quizzes
        $quizzes = Quiz::factory()->count(3)->create();

        // For each quiz, create multiple questions
        $quizzes->each(function ($quiz) {
            $questionsCount = rand(3, 5); // Random number of questions per quiz

            QuizQuestion::factory()->count($questionsCount)->create([
                'quiz_id' => $quiz->id,
            ]);
        });
    }
}

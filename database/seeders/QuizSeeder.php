<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Session;
use App\Models\QuizQuestion;
use App\Models\QuizResponse;
use Illuminate\Database\Seeder;
use App\Models\QuizResponseDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            $questionsCount = rand(2, 2); // Random number of questions per quiz

            QuizQuestion::factory()->count($questionsCount)->create([
                'quiz_id' => $quiz->id,
            ]);
        });

        Session::factory()->count(2)->create();

        QuizResponse::create([
        'quiz_session_id'=> '1',
        'username' => 'User 1',
        'user_id' => '1',
        'accuracy' => '100.00',
        'correct_answer_count' => '2',
        'incorrect_answer_count'=> '0',
        'total_points' => '1000',
        'average_time' => '22.50',
        ]);

        QuizResponse::create([
            'quiz_session_id'=> '1',
            'username' => 'User 2',
            'user_id' => '2',
            'accuracy' => '0.00',
            'correct_answer_count' => '0',
            'incorrect_answer_count'=> '2',
            'total_points' => '500',
            'average_time' => '10.0',
            ]);

        QuizResponseDetails::create([
            'quiz_response_id'=> '1',
            'question_id' => '1',
            'user_response'=> '',
            'correctness' => '0',
            'time_usage' => '15',
        ]);

        QuizResponseDetails::create([
            'quiz_response_id'=> '1',
            'question_id' => '1',
            'user_response'=> '',
            'correctness' => '0',
            'time_usage' => '10',
        ]);

        QuizResponseDetails::create([
            'quiz_response_id'=> '1',
            'question_id' => '2',
            'user_response'=> '',
            'correctness' => '0',
            'time_usage' => '30',
        ]);
    }
}

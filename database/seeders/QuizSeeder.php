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
        Quiz::create([
            'title' => 'Quiz 1',
            'description' => 'Description for Quiz 1',
            'visibility' => 'public',
            'id_lecturer' => 1,
        ]);

        QuizQuestion::create([
            'title' => 'What is the capital city of France?',
            'type' => 0,
            'options' => ['London', 'Paris', 'Rome', 'Madrid'],
            'correct_ans' => ['Paris'],
            'answer_explaination' => null,
            'single_ans_flag' => 1,
            'points' => 10,
            'duration' => 10,
            'index' => 0,
            'quiz_id' => 1,
        ]);

        QuizQuestion::create([
            'title' => 'Which of the following are primary colors?',
            'type' => 0,
            'options' => ['Red', 'Green', 'Blue', 'Yellow'],
            'correct_ans' => ['Red','Blue','Yellow'],
            'answer_explaination' => null,
            'single_ans_flag' => 0,
            'points' => 10,
            'duration' => 10,
            'index' => 1,
            'quiz_id' => 1,
        ]);

        QuizQuestion::create([
            'title' => 'Earth is the fifth planet from the sun.',
            'type' => 1,
            'options' => ['True','False'],
            'correct_ans' => ['False'],
            'answer_explaination' => null,
            'single_ans_flag' => 1,
            'points' => 10,
            'duration' => 10,
            'index' => 2,
            'quiz_id' => 1,
        ]);

        QuizQuestion::create([
            'title' => 'Enter a word with 6-8 characters that starts with the letter \'S\'.',
            'type' => 2,
            'options' => null,
            'correct_ans' => ['Silence'],
            'answer_explaination' => null,
            'single_ans_flag' => 1,
            'points' => 10,
            'duration' => 10,
            'index' => 3,
            'quiz_id' => 1,
        ]);

         Session::factory()->count(2)->create();

        QuizResponse::create([
        'session_id'=> '1',
        'username' => 'User 1',
        'user_id' => '1',
        'accuracy' => '100.00',
        'correct_answer_count' => '2',
        'incorrect_answer_count'=> '0',
        'total_points' => '1000',
        'average_time' => '22.50',
        ]);

        QuizResponse::create([
            'session_id'=> '1',
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
            'correctness' => '0',
            'time_usage' => '15',
        ]);

        QuizResponseDetails::create([
            'quiz_response_id'=> '1',
            'question_id' => '1',
            'correctness' => '0',
            'time_usage' => '10',
        ]);

        QuizResponseDetails::create([
            'quiz_response_id'=> '1',
            'question_id' => '2',
            'correctness' => '0',
            'time_usage' => '30',
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'options', 'correct_ans', 'answer_explaination',
        'single_ans_flag', 'points', 'duration','quiz_id', 'index'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_ans' => 'array',
    ];

    protected $attributes = [
        'title' => '',
        'type' => '',
        'options' => null,
        'correct_ans' => '[]',
        'answer_explaination' => null,
        'single_ans_flag' => null,
        'points' => 0,
        'duration' => 0,
    ];
    
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}

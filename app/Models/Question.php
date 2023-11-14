<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'options', 'correct_ans', 'answer_explanation',
        'single_ans_flag', 'points', 'duration'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_ans' => 'array',
        //'single_ans_flag' => 'boolean',
    ];

    protected $attributes = [
        'title' => '',
        'type' => '',
        'options' => null,
        'correct_ans' => '[]',
        'answer_explanation' => null,
        //'single_ans_flag' => null,
        'points' => 0,
        'duration' => 0,
    ];
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponseDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_response_id',
        'question_id',
        'user_response',
        'correctness',
        'time_usage',
    ];

    public function quizResponse()
    {
        return $this->belongsTo(QuizResponse::class);
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }
}

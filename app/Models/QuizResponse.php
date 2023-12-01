<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_session_id',
        'username',
        'user_id',
        'accuracy',
        'correct_answer_count',
        'incorrect_answer_count',
        'total_points',
        'average_time',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function quizResponseDetails()
    {
        return $this->hasMany(QuizResponseDetails::class);
    }
}

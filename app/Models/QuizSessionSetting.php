<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSessionSetting extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'show_leaderboard_flag', 'shuffle_option_flag'];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
    public function quizSessionSetting()
    {
        return $this->hasOne(QuizSessionSetting::class);
    }
    
}

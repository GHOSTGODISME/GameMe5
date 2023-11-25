<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'user_id', 'rank', 'score'];

    public function quizSession()
    {
        return $this->belongsTo(Session::class);
    }
}

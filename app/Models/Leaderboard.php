<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'user_id', 'username','rank', 'score'];

    public function quizSession()
    {
        return $this->belongsTo(Session::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}

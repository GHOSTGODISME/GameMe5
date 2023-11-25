<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'lecture_id', 'start_time', 'end_time', 'status'];

    public static function retrieveSessionIdFromDatabase($quizCode)
    {
        try {
            $session = self::where('code', $quizCode)
                            ->where('status', 'active')
                            ->first();

            if ($session) {
                return $session->id;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            // Handle the exception, log, or throw further if needed
            return null;
        }
    }


    public function joinSessions()
    {
        return $this->hasMany(JoinSession::class);
    }

    
    public function quizResponses()
    {
        return $this->hasMany(QuizResponse::class);
    }
    public function sessionSetting()
    {
        return $this->hasOne(QuizSessionSetting::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function leaderboards()
    {
        return $this->hasOne(Leaderboard::class);
    }
}
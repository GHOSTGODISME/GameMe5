<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'lecture_id', 'start_time', 'end_time', 'status','quiz_id'];

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
            return null;
        }
    }

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }

    // public function students(){
    //     return $this->hasMany(Student::class);
    // }
    
    public function quizResponses()
    {
        return $this->hasMany(QuizResponse::class);
    }
    public function quizSessionSetting()
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = 
    ['id','title', 'description', 'visibility','id_lecturer'];

    protected $attributes = [
        'title' => 'Quiz Title',
        'visibility' => 'public'
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'id_lecturer');
    }

    public function quiz_questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}

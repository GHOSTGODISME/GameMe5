<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = 
    ['id','title', 'description', 'visibility'];

    protected $attributes = [
        'title' => 'Quiz Title',
        'visibility' => 'public'
    ];

    public function quiz_questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
}

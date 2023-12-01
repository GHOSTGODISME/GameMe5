<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'visibility'];

    protected $attributes = [
        'title' => 'Survey Title',
        'description' => null,
        'visibility' => 'public'
    ];

    public function surveyQuestions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function surveyResponses(){
        return $this->hasMany(SurveyResponse::class);
    }
}

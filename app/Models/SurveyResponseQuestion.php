<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponseQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_question_id',
        'answers'
    ];

    protected $casts = [
        'answers' => 'json',
    ];

    public function surveyQuestion()
    {
        return $this->belongsTo(SurveyQuestion::class, 'survey_question_id');
    }
    
    public function surveyResponse()
    {
        return $this->belongsTo(SurveyResponse::class);
    }
}

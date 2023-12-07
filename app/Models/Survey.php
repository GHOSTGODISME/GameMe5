<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status','id_lecturer'];

    protected $attributes = [
        'title' => 'Survey Title',
        'description' => null,
        'status' => 'public'
    ];

    public function surveyQuestions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function surveyResponses(){
        return $this->hasMany(SurveyResponse::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'id_lecturer');
    }
}

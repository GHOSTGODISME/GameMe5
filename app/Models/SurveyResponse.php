<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function surveyResponseQuestions() {
        return $this->hasMany(SurveyResponseQuestion::class);
    }

}

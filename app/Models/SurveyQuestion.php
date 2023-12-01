<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        //'survey_id', 
        'type', 'title', 'description', 'options',
        'placeholder', 'prefilled_value', 'scale_min_label', 'scale_max_label',
        'scale_min_value', 'scale_max_value', 
        // 'properties', 
        'index'
    ];

    protected $casts = [
        'options' => 'json',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}

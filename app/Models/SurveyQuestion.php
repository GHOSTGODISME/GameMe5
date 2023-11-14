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
        'scale_min_value', 'scale_max_value', 'properties', 'index'
    ];

    protected $casts = [
        'options' => 'json',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }


    // // Add an option to the question
    // public function addOption($option)
    // {
    //     $options = $this->options ?? [];
    //     $options[] = $option;
    //     $this->options = $options;
    //     $this->save();
    // }

    // // Update options for the question
    // public function updateOptions($options)
    // {
    //     $this->options = $options;
    //     $this->save();
    // }

    // // Delete an option
    // public function deleteOption($option)
    // {
    //     $options = $this->options ?? [];
    //     $index = array_search($option, $options);
    //     if ($index !== false) {
    //         unset($options[$index]);
    //         $this->options = array_values($options);
    //         $this->save();
    //     }
    // }

    // // Clone a question
    // public function cloneQuestion()
    // {
    //     $newQuestion = $this->replicate();
    //     $newQuestion->push();

    //     return $newQuestion;
    // }

}

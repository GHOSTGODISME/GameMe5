<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'visibility'];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    protected $attributes = [
        'title' => 'Survey Title',
        'description' => null,
        'visibility' => 'public'
    ];
}

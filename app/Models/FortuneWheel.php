<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FortuneWheel extends Model
{
    use HasFactory;

    // The $fillable property specifies which columns can be mass assigned
    protected $fillable = [
        'title',
        'entries',
        'results',
        'id_lecturer'
    ];

    // The $casts property specifies how the attributes should be cast
    protected $casts = [
        'entries' => 'array',
        'results' => 'array',
    ];

    protected $attributes = [
        'title' => 'Fortune Wheel Title',
        'entries' => '["Default 1","Default 2"]',
        'results' => '[]'
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'id_lecturer');
    }
}

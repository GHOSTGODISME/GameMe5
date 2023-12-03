<?php

namespace App\Models;
use App\Models\Session;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends  Model
{
    public $timestamps = false;
    protected $table = "lecturer";

    protected $fillable = [
        'id', // Foreign key to associate with the User model
        'position', // Other fields specific to Lecturer
        'iduser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'id');
    }

    public function lect_classrooms()
    {
        return $this->belongsToMany(Lecturer::class, 'class_lecturer', 'idclass', 'idlecturer');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'lecture_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'id_lecturer');
    }

    public function fortuneWheels()
    {
        return $this->hasMany(FortuneWheel::class, 'id_lecturer');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class, 'id_lecturer');
    }
}

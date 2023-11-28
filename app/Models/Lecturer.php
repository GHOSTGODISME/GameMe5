<?php

namespace App\Models;
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
}

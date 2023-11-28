<?php

namespace App\Models;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Model;

class Student extends  Model
{
    public $timestamps = false;
    protected $table = "student";

    protected $fillable = [
        'id', // Foreign key to associate with the User model
        'iduser', 
    ];

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'class_student', 'idstudent', 'idclass');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'iduser', 'id');
    }

}

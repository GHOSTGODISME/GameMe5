<?php

namespace App\Models;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;

class Classroom extends  Model
{
    public $timestamps = false;
    protected $table = "classroom";

    protected $fillable = [
        'id', // Foreign key to associate with the User model
        'name', // Other fields specific to Lecturer
        'coursecode',
        'group',
        'joincode',
        'author',
    ];

 
    public function creator()
    {
        return $this->belongsTo(Lecturer::class, 'author', 'id');
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student', 'idclass', 'idstudent');
    }
    
    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class, 'class_lecturer', 'idclass', 'idlecturer');
    }
    

    public function announcements()
    {
        return $this->hasMany(Announcement::class,'id');
    }

    



}

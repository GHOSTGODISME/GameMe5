<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Classstudent extends Model
{
    public $timestamps = false;
    protected $table = "class_student";

    protected $fillable = [
        'id', // Foreign key to associate with the User model
        'idclass', 
        'idstudent', 
    ];

}

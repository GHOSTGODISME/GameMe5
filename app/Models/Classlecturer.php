<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Classlecturer extends Model
{
    public $timestamps = false;
    protected $table = "class_lecturer";

    protected $fillable = [
        'id', // Foreign key to associate with the User model
        'idclass', 
        'idlecturer', 
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'idlecturer', 'id');
    }

}

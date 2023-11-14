<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends  Model
{
    public $timestamps = false;
    protected $table = "lecturer";

    protected $fillable = [
        'idlecturer', // Foreign key to associate with the User model
        'position', // Other fields specific to Lecturer
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'id', 'email');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinSession extends Model
{
    use HasFactory;
    protected $fillable = ['session_id', 'user_id', 'username'];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function user()
    {
        return $this->belongsTo(Session::class);
    }
}

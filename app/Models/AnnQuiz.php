<?php

namespace App\Models;
use App\Models\Session;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;

class AnnQuiz extends  Model
{
    public $timestamps = false;
    protected $table = "ann_quiz";

    protected $fillable = [
        'id', 
        'ann_id', 
        'session_id',
    ];
    // public function announcement()
    // {
    //     return $this->morphOne(Announcement::class, 'content');
    // }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'ann_id');
    }

    public function sessions()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }
    
    
}

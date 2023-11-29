<?php

namespace App\Models;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;

class AnnFeedback extends  Model
{
    public $timestamps = false;
    protected $table = "ann_feedback";

    protected $fillable = [
        'id', 
        'ann_id', 
        'feedback_id',
    ];
    
    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'ann_id');
    }
    
}

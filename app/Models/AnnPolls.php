<?php

namespace App\Models;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;

class AnnPolls extends  Model
{
    public $timestamps = false;
    protected $table = "ann_polls";

    protected $fillable = [
        'id', 
        'ann_id', 
        'question',
        'option1',
        'option2'
    ];
    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'ann_id');
    }
    
}

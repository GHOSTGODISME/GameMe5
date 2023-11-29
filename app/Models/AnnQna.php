<?php

namespace App\Models;
use App\Models\AnnQnaAns;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;

class AnnQna extends  Model
{
    public $timestamps = false;
    protected $table = "ann_qna";

    protected $fillable = [
        'id', 
        'ann_id', 
        'question',
    ];
    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'ann_id');
    }

    public function replies()
    {
        return $this->hasMany(AnnQnaAns::class, 'quesid');
    }
    
}

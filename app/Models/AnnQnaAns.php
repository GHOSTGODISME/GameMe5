<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AnnQnaAns extends  Model
{
    public $timestamps = false;
    protected $table = "ann_qna_answer";

    protected $fillable = [
        'id', 
        'quesid', 
        'content',
        'userid',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid','id');
    }

}

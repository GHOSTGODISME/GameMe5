<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AnnPollsResult extends  Model
{
    public $timestamps = false;
    protected $table = "ann_polls_result";

    protected $fillable = [
        'id', 
        'polls_id', 
        'option',
        'user_id',
    ];

}

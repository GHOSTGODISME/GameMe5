<?php

namespace App\Models;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;

class AnnText extends Model
{
    public $timestamps = false;
    protected $table = "ann_text";

    protected $fillable = [
        'id', 
        'annid', 
        'content',
    ];

    // public function announcement()
    // {
    //     return $this->morphOne(Announcement::class, 'content');
    // }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'annid');
    }
    
    
}

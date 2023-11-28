<?php

namespace App\Models;
use App\Models\AnnQna;
use App\Models\AnnQuiz;
use App\Models\AnnPolls;
use App\Models\AnnFeedback;
use Illuminate\Database\Eloquent\Model;

class Announcement extends  Model
{
    public $timestamps = false;
    protected $table = "announcement";

    protected $fillable = [
        'id', 
        'idclass', 
        'type',
        'created_at',
        'user_id',
    ];
    
    
    public function content()
    {
        return $this->morphTo('content');
    }

    public function annText()
    {
        return $this->hasOne(AnnText::class, 'annid');
    }

    public function annQuiz()
    {
        return $this->hasOne(AnnQuiz::class, 'ann_id');
    }

    public function annQna()
    {
        return $this->hasOne(AnnQna::class, 'ann_id');
    }

    public function annPolls()
    {
        return $this->hasOne(AnnPolls::class, 'ann_id');
    }

    public function annFeedback()
    {
        return $this->hasOne(AnnFeedback::class, 'ann_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }



}

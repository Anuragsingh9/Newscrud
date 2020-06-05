<?php

namespace App;
use App\News;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    public function news(){
        return $this->belongsTo(News::class);
    }

    protected $fillable = ['rating', 'review','news_id','user_id'];
}

<?php

namespace App;
use App\News;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function news(){
        return $this->belongsTo(News::class);
    }

    protected $fillable = [
        'rating', 'review',
    ];
}

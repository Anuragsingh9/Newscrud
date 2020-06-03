<?php

namespace App;
use App\User;
use App\Review;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    
    public function User()
    {
        return $this->hasMany(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    protected $fillable = [
        'title', 'header','description','file_url',
    ];
}

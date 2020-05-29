<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    
    public function User()
    {
        return $this->hasMany(User::class);
    }
    
    protected $fillable = [
        'title', 'header','description','file_url',
    ];
}

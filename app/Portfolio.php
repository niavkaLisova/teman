<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class Portfolio extends Model
{
    protected $fillable = ['title', 'describe', 'user_id', 'image_cover'];

    public function posts()
    {
       return $this->hasMany(Post::class);
    }

    public function users()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

}

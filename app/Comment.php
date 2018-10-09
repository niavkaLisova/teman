<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;
use App\User;

class Comment extends Model
{
    protected $fillable = ['comment','reply_id','post_id','user_id','edit'];
 
    protected $dates = ['created_at', 'updated_at'];

    protected $appends = ['createdDate'];
 
    public function replies()
    {
    	return $this->hasMany(Comment::class,'reply_id')->with('user');
    }

    public function user()
	{
	   return $this->belongsTo(User::class);
	}

	public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}

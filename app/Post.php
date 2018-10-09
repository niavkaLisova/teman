<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Comment;
use App\Favorite;

class Post extends Model
{
	protected $fillable = ['id', 'user_id', 'body', 'title', 'type', 'image'];

	protected $appends = ['createdDate'];
	
    public function user()
	{
	   return $this->belongsTo(User::class);
	}

	public function comments()
	{
	   return $this->hasMany(Comment::class);
	}

	public function favorite()
	{
	   return $this->hasMany(Favorite::class);
	}


	public function getRouteKeyName()
    {
       return 'id';
    }

	public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
	 * Determine whether a post has been marked as favorite by a user.
	 *
	 * @return boolean
	 */
	public function favorited()
	{
	    return (bool) Favorite::where('user_id', Auth::id())
	                        ->where('post_id', $this->id)
	                        ->first();
	}
}

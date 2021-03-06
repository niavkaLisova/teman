<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
	protected $fillable = ['body', 'user_id', 'del', 'read'];
    
    protected $appends = ['selfMessage'];

	public function user()
	{
	   return $this->belongsTo(User::class);
	}

	public function getSelfMessageAttribute()
	{
	    return $this->user_id === auth()->user()->id;
	}
}

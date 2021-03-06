<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'follower_id'
    ];

    public function user()
	{
	   return $this->belongsTo(User::class, 'follower_id');
	}

	public function follower()
	{
	   return $this->belongsTo(User::class, 'user_id');
	}

}

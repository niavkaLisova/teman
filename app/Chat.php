<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message;
use App\User;

class Chat extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users', 'id'
    ];

    protected $casts = [
    	'id' => 'int',
     	'users' => 'array'
	];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

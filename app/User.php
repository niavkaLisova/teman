<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Message;
use App\Portfolio;
use App\Chat;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'view_count', 'username', 'gender', 'bday', 'country', 'city'
    ];

    protected $appends = ['ProfileLink'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
       return $this->hasMany('App\Post');
    }

    public function portfolios()
    {
       return $this->hasMany(Portfolio::class);
    }

    public function getRouteKeyName()
    {
       return 'id';
    }

    public function getProfileLinkAttribute()
    {

        return "<a href='/users/{$this->id}'>{$this->name}</a>";
    }

    public function following()
    {
       return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function isNot($user)
    {
        return $this->id !== $user->id;
    }

    public function isFollowing($user)
    {
        return (bool) $this->following->where('id', $user->id)->count();
    }

    public function canFollow($user)
    {
        if(!$this->isNot($user)) {
            return false;
        }
        return !$this->isFollowing($user);
    }

    public function canUnFollow($user)
    {
        return $this->isFollowing($user);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get all of favorite posts for the user.
     */
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites', 'user_id', 'post_id')->withTimeStamps();
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class);
    }

    public function specChat($user_id)
    {
        $chats = $this->belongsToMany(Chat::class)->where('state', 1)->select('chat_id')->get();

        $chats2 = (DB::table('chat_user')->where('user_id', $user_id)->select('chat_id'))->whereIn('chat_id', $chats);

        return $chats2;
    }

    public function specPoliChat($user_id)
    {
        $chats = $this->belongsToMany(Chat::class)->where('state', 0)->select('chat_id')->get();

        $chats2 = (DB::table('chat_user')->where('user_id', $user_id)->select('chat_id'))->whereIn('chat_id', $chats);

        return $chats2;
    }
}

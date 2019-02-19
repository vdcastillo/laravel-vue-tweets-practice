<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed id
 * @property mixed following
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['profileLink'];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function canUnFollow($user)
    {
        return $this->isFollowing($user);
    }


    public function getRouteKeyName()
    {
        return 'name';
    }

    public function getProfileLinkAttribute()
    {
        return route('user.show', $this);
    }

    /**
     * @param $user
     *
     * @return bool
     */
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
}

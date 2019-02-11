<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed created_at
 */
class Post extends Model
{
    //
    protected $fillable = ['user_id', 'body'];

    protected $appends = ['createdDate'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}

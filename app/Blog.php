<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'user_id', 'content', 'main_image'
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment')->with('user');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

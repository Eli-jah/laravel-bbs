<?php

namespace App\Models;

class Reply extends Model
{
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'topic_id',
        'user_id',
        'content',
    ];

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    /*protected $touches = [
        'topic'
    ];*/

    /* Eloquent Relationships */
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

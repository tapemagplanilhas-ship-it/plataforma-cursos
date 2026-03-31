<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
    'user_id',
    'recipient_id',
    'body',
    'media_path',
    'media_type',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function recipient()
{
    return $this->belongsTo(User::class, 'recipient_id');
}

    public function getMediaUrlAttribute()
    {
        return $this->media_path ? asset('storage/' . $this->media_path) : null;
    }
}
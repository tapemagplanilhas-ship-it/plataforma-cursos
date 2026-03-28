<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
    'title',
    'body',
    'priority',
    'color',
    'media_path',
    'media_type',
    'created_by',
    'active',
];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByPriority($query)
    {
        return $query->orderByRaw("FIELD(priority, 'urgente', 'importante', 'normal')");
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Helpers de role
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'password_change_prompt_seen',
    'published_at',
    'expires_at',
    'theme_preference',
];

protected $hidden = [
    'password',
    'remember_token',
];


protected $casts = [
    'email_verified_at' => 'datetime',
    'password'          => 'hashed',
];

public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function hasRole(string|array $roles): bool
{
    if (is_array($roles)) {
        return in_array($this->role, $roles);
    }
    return $this->role === $roles;
}

public function courses()
{
    return $this->hasMany(Course::class, 'created_by');
}

public function messages()
{
    return $this->hasMany(Message::class);
}

public function notices()
{
    return $this->hasMany(Notice::class, 'created_by');
}
public function badges()
{
    return $this->belongsToMany(Badge::class)->withPivot('unlocked_at');
}

public function completedCourses()
{
    return $this->belongsToMany(Course::class, 'course_completions')->withTimestamps();  // Assuma tabela pivot
}
public function systemNotifications()
{
    return $this->hasMany(\App\Models\Notification::class)->latest();
}
// Escopo local para filtrar apenas avisos ativos
public function scopeActive($query)
{
    return $query
        ->where(function ($q) {
            $q->whereNull('published_at')
              ->orWhere('published_at', '&lt;=', now());
        })
        ->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>=', now());
        });
}
}
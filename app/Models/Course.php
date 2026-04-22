<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'video_path',
        'allowed_role',
        'created_by',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    // Escopo: só cursos ativos
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Escopo: cursos visíveis para o role do usuário
    public function scopeForRole($query, string $role)
    {
        if ($role === 'admin') {
            return $query; // admin vê tudo
        }

        return $query->where('allowed_role', $role);
    }

    // Relacionamento com criador
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

        // Um Curso TEM MUITAS Aulas (Ordenadas pela coluna 'order')
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order', 'asc');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'title',
        'description',
        'body',
        'priority',
        'color',
        'media_path',
        'media_type',
        'created_by',
        'user_id',
        'active',
        'notified',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relação com o criador
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relação com o usuário (owner)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Escopo: Avisos ativos (publicados, não expirados E marcado como ativo)
    public function scopeActive($query)
    {
        return $query
            ->where('active', true)
            ->where(function ($q) {
                // Se não tiver published_at, publica agora
                // Se tiver, só mostra se for <= agora
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            })
            ->where(function ($q) {
                // Se não tiver expires_at, nunca expira
                // Se tiver, só mostra se for > agora
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    // Escopo: Ordena por prioridade
    public function scopeByPriority($query)
    {
        return $query->orderByRaw("FIELD(priority, 'urgente', 'importante', 'normal')");
    }

    // Escopo: Avisos agendados (ainda não foram publicados)
    public function scopeScheduled($query)
    {
        return $query->where('published_at', '>', now());
    }

    // Escopo: Avisos expirados
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
}
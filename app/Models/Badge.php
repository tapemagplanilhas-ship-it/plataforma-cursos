<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'icon', 'type', 'required_completions'
    ];

    protected $casts = [
        'unlocked_at' => 'datetime',
        'required_completions' => 'integer'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('unlocked_at')->withTimestamps();
    }

    // Método para verificar se badge pode ser desbloqueado
    public function isUnlockableForUser($user)
    {
        $completions = $user->completedCourses()->count();  // Assuma relacionamento com cursos completos
        return $completions >= $this->required_completions;
    }
}
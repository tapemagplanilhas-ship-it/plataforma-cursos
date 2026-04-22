<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['course_id', 'title', 'description', 'video_path', 'order', 'is_active'];

    // Uma aula PERTENCE a um Curso
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
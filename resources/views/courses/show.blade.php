@extends('layouts.app')

@section('content')
<style>
    .back-link {
        color: #e50000;
        text-decoration: none;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 20px;
    }

    .back-link:hover { text-decoration: underline; }

    .video-container {
        background: #000;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 24px;
        border: 1px solid #222;
    }

    .video-container video {
        width: 100%;
        max-height: 520px;
        display: block;
    }

    .course-info {
        background: #111;
        border: 1px solid #222;
        border-radius: 8px;
        padding: 24px;
    }

    .course-info h1 {
        font-size: 1.6rem;
        margin-bottom: 10px;
        color: #fff;
    }

    .course-meta {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        align-items: center;
    }

    .course-meta span { font-size: 0.8rem; color: #666; }

    .course-info p {
        color: #aaa;
        line-height: 1.7;
    }

    .btn-danger {
        background: transparent;
        border: 1px solid #e50000;
        color: #e50000;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.85rem;
        margin-top: 16px;
        transition: all 0.2s;
    }

    .btn-danger:hover { background: #e50000; color: #fff; }
</style>

<a href="{{ route('courses.index') }}" class="back-link">← Voltar para Cursos</a>

<div class="video-container">
    <video controls autoplay>
        <source src="{{ Storage::url($course->video_path) }}" type="video/mp4">
        Seu navegador não suporta vídeo HTML5.
    </video>
</div>

<div class="course-info">
    <h1>{{ $course->title }}</h1>
    <div class="course-meta">
        <span class="badge badge-{{ $course->allowed_role }}">{{ $course->allowed_role }}</span>
        <span>Criado por {{ $course->creator->name }}</span>
        <span>{{ $course->created_at->format('d/m/Y') }}</span>
    </div>
    <p>{{ $course->description ?? 'Sem descrição.' }}</p>

    @if(auth()->user()->isAdmin())
        <form method="POST" action="{{ route('courses.destroy', $course) }}"
              onsubmit="return confirm('Remover este curso?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">🗑 Remover Curso</button>
        </form>
    @endif
</div>
@endsection
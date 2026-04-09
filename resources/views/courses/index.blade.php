@extends('layouts.app')

@section('content')
<style>
    .page-header { margin-bottom: 30px; }
    .page-header h1 { font-size: 1.8rem; color: var(--text-primary); }
    .page-header h1 span { color: #e50000; }

    .btn-create { 
        background: #e50000; 
        color: var(--text-primary);
        padding: 10px 20px; 
        border-radius: 6px; 
        text-decoration: none;
        float: right;
        margin-bottom: 20px;
    }
    .btn-create:hover { background: #cc0000; }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .course-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s;
        cursor: pointer;
        min-height: 300px;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        border-color: #e50000;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(229, 0, 0, 0.2);
    }

    /* Capa com título */
    .course-cover {
        width: 100%;
        height: 180px;
        background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .course-cover::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(229, 0, 0, 0.1) 0%, rgba(229, 0, 0, 0) 100%);
        pointer-events: none;
    }

    .course-cover-title {
        font-size: 1.4rem;
        color: var(--text-primary);
        font-weight: 700;
        line-height: 1.4;
        z-index: 1;
        position: relative;
    }

    .course-content {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .course-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        color: #555;
        margin-bottom: 12px;
    }

    .course-role {
        background: #1a1a1a;
        padding: 2px 8px;
        border-radius: 12px;
        color: #888;
    }

    .course-description {
        color: #888;
        font-size: 0.8rem;
        line-height: 1.4;
        margin-bottom: 16px;
        flex-grow: 1;
    }

    .course-actions {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }

    .btn-view, .btn-delete {
        flex: 1;
        padding: 8px;
        border: none;
        border-radius: 4px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-view {
        background: #e50000;
        color: var(--text-primary);
        text-decoration: none;
    }

    .btn-view:hover { background: #cc0000; }

    .btn-delete {
        background: transparent;
        color: #e50000;
        border: 1px solid #e50000;
    }

    .btn-delete:hover { background: #e50000; color: var(--text-primary); }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #555;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 12px;
    }
</style>

<div class="page-header">
    <h1>Meus <span>Cursos</span></h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('courses.create') }}" class="btn-create">🎬 Novo Curso</a>
    @endif
</div>

@if(session('success'))
    <!-- <div style="background:#0d2817; color:#4ade80; padding:12px; border-radius:6px; margin-bottom:20px; border:1px solid #22c55e;">
        ✅ {{ session('success') }}
    </div> -->
@endif

@forelse($courses as $course)
    @if($loop->first)
        <div class="courses-grid">
    @endif

    <div class="course-card" onclick="window.location='{{ route('courses.show', $course) }}'">
        <!-- Capa com título do vídeo -->
        <div class="course-cover">
            <h2 class="course-cover-title">{{ $course->title }}</h2>
        </div>

        <div class="course-content">
            <div class="course-meta">
                <span class="course-role">{{ ucfirst($course->allowed_role) }}</span>
                <span>{{ $course->created_at->format('d/m/Y') }}</span>
            </div>

            @if($course->description)
                <p class="course-description">
                    {{ Str::limit($course->description, 80) }}
                </p>
            @endif

            <div class="course-actions" onclick="event.stopPropagation();">
                <a href="{{ route('courses.show', $course) }}" class="btn-view">👁️ Ver</a>
                
                @if(auth()->user()->isAdmin())
                    <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('Remover este curso?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" style="width:100%;">🗑️</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if($loop->last)
        </div>
    @endif
@empty
    <div class="empty-state">
        <div class="empty-state-icon">🎬</div>
        <p style="font-size:1rem; margin-bottom:4px;">Nenhum curso disponível</p>
        <p style="font-size:0.85rem;">Comece criando seu primeiro curso de treinamento</p>
    </div>
@endforelse

@if($courses->hasPages())
    <div style="margin-top:30px; display:flex; justify-content:center;">
        {{ $courses->links() }}
    </div>
@endif

@endsection
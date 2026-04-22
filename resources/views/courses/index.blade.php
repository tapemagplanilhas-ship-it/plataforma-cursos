@extends('layouts.app')

@section('content')
<style>
    .page-header { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
    .page-header h1 { font-size: 1.8rem; color: var(--text-primary); margin: 0; }
    .page-header h1 span { color: #e50000; }

    .btn-create { 
        background: #e50000; 
        color: #fff;
        padding: 10px 20px; 
        border-radius: 6px; 
        text-decoration: none;
        font-weight: 700;
        transition: all 0.2s;
    }
    .btn-create:hover { background: #cc0000; transform: scale(1.05); }

    /* === ESTILO DOS GRUPOS (EXCLUSIVO ADMIN) === */
    .group-container { margin-bottom: 50px; }
    
    .group-divider {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
    }
    .group-divider h2 {
        font-size: 1.1rem;
        color: #e50000;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
        white-space: nowrap;
        margin: 0;
    }
    .group-line {
        height: 2px;
        background: linear-gradient(90deg, rgba(229, 0, 0, 0.4) 0%, transparent 100%);
        flex-grow: 1;
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    .course-card {
        background: #111;
        border: 1px solid #222;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .course-card:hover {
        border-color: #e50000;
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(229, 0, 0, 0.2);
    }

    .course-cover {
        width: 100%;
        height: 160px;
        background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        text-align: center;
        position: relative;
    }

    .course-cover-title {
        font-size: 1.2rem;
        color: #fff;
        font-weight: 700;
        z-index: 1;
    }

    .course-content { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }

    .course-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.75rem;
        margin-bottom: 15px;
    }

    .course-role {
        background: rgba(229, 0, 0, 0.1);
        padding: 4px 12px;
        border-radius: 20px;
        color: #e50000;
        font-weight: 700;
        border: 1px solid rgba(229, 0, 0, 0.2);
    }

    .course-description {
        color: #888;
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 20px;
    }

    .course-actions { display: flex; gap: 10px; margin-top: auto; }

    .btn-view {
        flex: 3;
        background: #e50000;
        color: #fff;
        text-align: center;
        padding: 10px;
        border-radius: 6px;
        font-weight: 700;
        text-decoration: none;
    }

    .btn-delete {
        flex: 1;
        background: transparent;
        color: #555;
        border: 1px solid #222;
        border-radius: 6px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-delete:hover { color: #e50000; border-color: #e50000; background: rgba(229, 0, 0, 0.05); }

    .empty-state { text-align: center; padding: 100px 20px; color: #555; }
</style>

<div class="page-header">
    <h1>Meus <span>Cursos</span></h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('courses.create') }}" class="btn-create">🎬 Novo Curso</a>
    @endif
</div>

@if(auth()->user()->isAdmin())
    {{-- 🚀 VISÃO DO ADMIN: AGRUPADA POR SETOR --}}
    @forelse($courses as $role => $group)
        <div class="group-container">
            <div class="group-divider">
                <h2>Setor: {{ $role == 'todos' ? 'Geral' : strtoupper($role) }}</h2>
                <div class="group-line"></div>
            </div>

            <div class="courses-grid">
                @foreach($group as $course)
                    @include('courses.partials.card-item', ['course' => $course])
                @endforeach
            </div>
        </div>
    @empty
        <div class="empty-state">
            <p>Nenhum curso cadastrado no sistema.</p>
        </div>
    @endforelse
@else
    {{-- 👤 VISÃO DO USUÁRIO: GRID SIMPLES FILTRADO --}}
    <div class="courses-grid" style="margin-top: 40px;">
        @forelse($courses as $course)
            @include('courses.partials.card-item', ['course' => $course])
        @empty
            <div class="empty-state">
                <p>Nenhum curso disponível para o seu cargo no momento.</p>
            </div>
        @endforelse
    </div>

    @if($courses->hasPages())
        <div style="margin-top:30px; display:flex; justify-content:center;">
            {{ $courses->links() }}
        </div>
    @endif
@endif

@endsection
@extends('layouts.app')

@section('content')
<style>
    /* === DESIGN PREMIUM DO PLAYER (ESTILO NETFLIX/HOTMART) === */
    .course-layout {
        display: flex;
        gap: 24px;
        min-height: calc(100vh - 120px);
        margin-top: 10px;
    }

    /* Área do Vídeo Principal */
    .player-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0; /* Evita quebra de layout */
    }

    .back-link {
        color: var(--accent);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        transition: color 0.2s;
    }
    .back-link:hover { color: var(--accent-hover); }

    .video-container {
        background: #000;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        flex-shrink: 0;
    }

    .video-container video {
        width: 100%;
        max-height: 65vh;
        display: block;
    }

    .course-info {
        margin-top: 24px;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
    }

    .course-info h1 {
        font-size: 1.8rem;
        color: var(--text-primary);
        margin-bottom: 12px;
        font-weight: 800;
    }

    .course-meta {
        display: flex;
        gap: 16px;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-light);
    }

    .course-meta span { color: var(--text-muted); font-size: 0.9rem; font-weight: 600; }

    .course-desc {
        color: var(--text-secondary);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Área da Playlist Lateral */
    .playlist-section {
        width: 380px;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        overflow: hidden;
    }

    .playlist-header {
        padding: 20px;
        background: linear-gradient(135deg, var(--bg-tertiary) 0%, var(--bg-secondary) 100%);
        border-bottom: 1px solid var(--border);
        color: var(--text-primary);
        font-weight: 800;
        font-size: 1.1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .lesson-list {
        flex: 1;
        overflow-y: auto;
    }
    
    .lesson-list::-webkit-scrollbar { width: 6px; }
    .lesson-list::-webkit-scrollbar-track { background: transparent; }
    .lesson-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .lesson-item {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-light);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s ease;
        background: transparent;
    }

    .lesson-item:hover { background: var(--bg-tertiary); }

    .lesson-item.active {
        background: rgba(229, 0, 0, 0.05);
        border-left: 4px solid var(--accent);
    }

    .lesson-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--bg-tertiary);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
        transition: all 0.2s;
    }

    .lesson-item.active .lesson-icon {
        background: var(--accent);
        color: #fff;
        box-shadow: 0 0 15px rgba(229, 0, 0, 0.4);
    }

    .lesson-details { flex: 1; min-width: 0; }
    
    .lesson-title {
        font-weight: 700;
        color: var(--text-primary);
        font-size: 0.95rem;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .lesson-item.active .lesson-title { color: var(--accent); }

    .lesson-subtitle { font-size: 0.8rem; color: var(--text-muted); font-weight: 600; }

    .btn-danger {
        background: transparent;
        border: 1px solid var(--accent);
        color: var(--accent);
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 700;
        margin-top: 24px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-danger:hover { background: var(--accent); color: #fff; }

    /* Responsividade Mobile */
    @media (max-width: 992px) {
        .course-layout { flex-direction: column; }
        .playlist-section { width: 100%; height: 400px; }
    }
</style>

<div class="course-layout">
    <!-- LADO ESQUERDO: PLAYER -->
    <div class="player-section">
        <a href="{{ route('courses.index') }}" class="back-link">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Voltar para a Vitrine
        </a>
        
        <div class="video-container">
            <video id="main-player" controls autoplay controlsList="nodownload">
                @php
                    $firstVideo = $course->lessons->count() > 0 ? $course->lessons->first()->video_path : $course->video_path;
                @endphp
                <source id="video-source" src="{{ Storage::url($firstVideo) }}" type="video/mp4">
                Seu navegador não suporta vídeo HTML5.
            </video>
        </div>

        <div class="course-info">
            <h1 id="current-lesson-title">
                {{ $course->lessons->count() > 0 ? $course->lessons->first()->title : $course->title }}
            </h1>
            
            <div class="course-meta">
                <span class="badge badge-{{ $course->allowed_role }}">{{ strtoupper($course->allowed_role) }}</span>
                <span>👤 {{ $course->creator->name }}</span>
                <span>📅 {{ $course->created_at->format('d/m/Y') }}</span>
            </div>
            
            <div class="course-desc">
                {{ $course->description ?? 'Nenhuma descrição detalhada fornecida para este curso.' }}
            </div>

            @if(auth()->user()->isAdmin())
                <form method="POST" action="{{ route('courses.destroy', $course) }}" onsubmit="return confirm('ATENÇÃO: Remover este curso apagará todas as aulas dele. Tem certeza?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        Excluir Curso Completo
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- LADO DIREITO: PLAYLIST -->
    <div class="playlist-section">
        <div class="playlist-header">
            <span>Conteúdo do Curso</span>
            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">
                {{ $course->lessons->count() > 0 ? $course->lessons->count() . ' Aulas' : '1 Aula' }}
            </span>
        </div>
        
        <div class="lesson-list">
            @if($course->lessons->count() > 0)
                @foreach($course->lessons as $index => $lesson)
                    <div class="lesson-item {{ $index === 0 ? 'active' : '' }}" 
                         onclick="playLesson('{{ Storage::url($lesson->video_path) }}', '{{ addslashes($lesson->title) }}', this)">
                        <div class="lesson-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                        </div>
                        <div class="lesson-details">
                            <div class="lesson-title">{{ $lesson->title }}</div>
                            <div class="lesson-subtitle">Aula {{ $index + 1 }}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback para cursos antigos que ainda não têm aulas cadastradas -->
                <div class="lesson-item active" onclick="playLesson('{{ Storage::url($course->video_path) }}', '{{ addslashes($course->title) }}', this)">
                    <div class="lesson-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    </div>
                    <div class="lesson-details">
                        <div class="lesson-title">{{ $course->title }}</div>
                        <div class="lesson-subtitle">Aula Única</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function playLesson(videoUrl, title, element) {
        const player = document.getElementById('main-player');
        const source = document.getElementById('video-source');
        
        // Atualiza a URL e dá play
        source.src = videoUrl;
        player.load();
        player.play();

        // Atualiza o Título grande embaixo do vídeo
        document.getElementById('current-lesson-title').textContent = title;

        // Gerencia a classe 'active' na playlist
        document.querySelectorAll('.lesson-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');
        
        // Rola a página suavemente para o topo do player (útil no mobile)
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
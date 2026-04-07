@extends('layouts.app')

@section('content')
<style>
    .mural-container {
        max-width: 1400px;
        margin: 40px auto;
        padding: 20px;
    }
    .mural-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 20px;
    }
    .mural-title {
        font-size: 2.8rem;
        color: #e50000;
        font-weight: 900;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        margin: 0;
    }
    .mural-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    .btn {
        padding: 12px 25px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }
    .btn-primary {
        background: #e50000;
        color: #fff;
    }
    .btn-primary:hover {
        background: #cc0000;
        transform: translateY(-2px);
    }
    .btn-secondary {
        background: #333;
        color: #fff;
        border: 2px solid #e50000;
    }
    .btn-secondary:hover {
        background: #e50000;
        transform: translateY(-2px);
    }
    .mural-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }
    .notice-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        cursor: pointer;
        border-left: 5px solid;
    }
    .notice-card.urgente {
        border-left-color: #ff4444;
        background: linear-gradient(135deg, #2a1a1a 0%, #1a1a1a 100%);
    }
    .notice-card.importante {
        border-left-color: #e50000;
        background: linear-gradient(135deg, #2a1a1a 0%, #1a1a1a 100%);
    }
    .notice-card.normal {
        border-left-color: #666;
        background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
    }
    .notice-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(229, 0, 0, 0.3);
    }
    .notice-media {
    width: 100%;
    height: 180px;
    object-fit: contain;
    object-position: center;
    background: #111;
    padding: 10px;
    box-sizing: border-box;
}
    .notice-content {
        padding: 20px;
        color: #fff;
    }
    .notice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    .notice-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: #e50000;
        flex: 1;
        margin-right: 10px;
    }
    .notice-priority {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .priority-urgente {
        background: #ff4444;
        color: #fff;
    }
    .priority-importante {
        background: #e50000;
        color: #fff;
    }
    .priority-normal {
        background: #666;
        color: #fff;
    }
    .notice-body {
        font-size: 0.95rem;
        color: #ccc;
        margin-bottom: 12px;
        line-height: 1.6;
        max-height: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .notice-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: #888;
        border-top: 1px solid #333;
        padding-top: 12px;
    }
    .notice-creator-name {
        color: #e50000;
        font-weight: bold;
    }
    .no-notices {
        text-align: center;
        color: #888;
        font-size: 1.3rem;
        padding: 80px 20px;
    }
</style>

<div class="mural-container">
    <div class="mural-header">
        <h1 class="mural-title">📰 Mural de Avisos e Notícias</h1>
        <div class="mural-buttons">
            @auth
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">📚 Ir para Cursos</a>
                @if(in_array(Auth::user()->role, ['admin', 'diretoria', 'gerencia', 'rh', 'financeiro']))
                    <a href="{{ route('notices.create') }}" class="btn btn-primary">➕ Publicar Aviso</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">🔐 Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">📝 Registrar</a>
            @endauth
        </div>
    </div>

    @if($notices->count() > 0)
        <div class="mural-grid">
            @foreach($notices as $notice)
               <a href="{{ route('notices.show', $notice->id) }}" style="text-decoration: none; color: inherit;">
                <div class="notice-card {{ $notice->priority }}">
                    @if($notice->media_path)
                        @if(str_contains($notice->media_type, 'image'))
                            <img src="{{ asset('storage/' . $notice->media_path) }}" alt="{{ $notice->title }}" class="notice-media">
                        @elseif(str_contains($notice->media_type, 'video'))
                            <video controls class="notice-media">
                                <source src="{{ asset('storage/' . $notice->media_path) }}" type="{{ $notice->media_type }}">
                            </video>
                        @endif
                    @endif

                    <div class="notice-content">
                        <div class="notice-header">
                            <h3 class="notice-title">{{ $notice->title }}</h3>
                            <span class="notice-priority priority-{{ $notice->priority }}">{{ ucfirst($notice->priority) }}</span>
                        </div>

                        <p class="notice-body">{{ Str::limit($notice->body, 150) }}</p>

                        <div class="notice-footer">
                            <span class="notice-creator-name">{{ $notice->creator->name ?? 'Sistema' }}</span>
                            <span>{{ $notice->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </a>

        <div style="display: flex; justify-content: center; margin-top: 40px;">
            {{ $notices->links() }}
        </div>
    @else
        <div class="no-notices">
            ℹ️ Nenhum aviso no momento. Volte mais tarde!
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('content')
<style>
    .notice-detail-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
    }
    .notice-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }
    .notice-detail-title {
        font-size: 2.5rem;
        color: #e50000;
        font-weight: 900;
        margin: 0;
        flex: 1;
        min-width: 300px;
    }
    .notice-detail-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.95rem;
    }
    .btn-back {
        background: #333;
        color: #fff;
        border: 2px solid #666;
    }
    .btn-back:hover {
        background: #555;
        transform: translateY(-2px);
    }
    .btn-delete {
        background: #ff4444;
        color: #fff;
        border: 2px solid #ff4444;
    }
    .btn-delete:hover {
        background: #cc0000;
        transform: translateY(-2px);
    }
    .notice-detail-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
        font-size: 0.95rem;
        color: #888;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .priority-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        text-transform: uppercase;
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
    .notice-detail-media {
        width: 100%;
        max-width: 100%;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .notice-detail-media img {
        width: 100%;
        max-height: 500px;
        object-fit: contain;
        border-radius: 12px;
        background: #111;
        padding: 15px;
        box-sizing: border-box;
    }
    .notice-detail-media video {
        width: 100%;
        max-height: 500px;
        border-radius: 12px;
        background: #111;
    }
    .notice-detail-media iframe {
        width: 100%;
        height: 600px;
        border: none;
        border-radius: 12px;
        background: #111;
    }
    .notice-detail-body {
        background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        border: 2px solid #333;
        border-radius: 12px;
        padding: 30px;
        color: #ccc;
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 30px;
    }
    .notice-detail-creator {
        background: #111;
        border-left: 4px solid #e50000;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }
    .creator-name {
        color: #e50000;
        font-weight: bold;
        font-size: 1.1rem;
    }
    .creator-date {
        color: #888;
        font-size: 0.9rem;
        margin-top: 5px;
    }
    
    /* ESTILO PREMIUM PARA O BOTÃO DE DOWNLOAD */
    .btn-download-premium {
        display: block;
        text-align: center;
        padding: 15px 30px;
        background: linear-gradient(135deg, #e50000 0%, #ff4444 100%);
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 900;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(229,0,0,0.3);
        margin-top: 20px;
        border: none;
    }
    .btn-download-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(229,0,0,0.5);
        color: #fff;
    }

    .modal-delete {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .modal-delete-content {
        background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        margin: 15% auto;
        padding: 30px;
        border: 2px solid #e50000;
        border-radius: 12px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        color: #fff;
        box-shadow: 0 20px 60px rgba(229, 0, 0, 0.3);
    }
    .modal-title {
        font-size: 1.5rem;
        color: #e50000;
        margin-bottom: 15px;
    }
    .modal-text {
        color: #ccc;
        margin-bottom: 25px;
        line-height: 1.6;
    }
    .modal-buttons {
        display: flex;
        gap: 10px;
        justify-content: center;
    }
    .modal-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s;
    }
    .modal-btn-confirm {
        background: #ff4444;
        color: #fff;
        flex: 1;
    }
    .modal-btn-confirm:hover {
        background: #cc0000;
    }
    .modal-btn-cancel {
        background: #333;
        color: #fff;
        flex: 1;
        border: 2px solid #666;
    }
    .modal-btn-cancel:hover {
        background: #555;
    }
    .notice-image-wrapper {
    position: relative;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
}

.notice-image-download-btn {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 46px;
    height: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    border-radius: 50%;
    background: rgba(10, 10, 10, 0.78);
    color: #fff;
    font-size: 1.2rem;
    font-weight: 900;
    border: 1px solid rgba(255, 255, 255, 0.14);
    backdrop-filter: blur(6px);
    z-index: 5;
    transition: all 0.25s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.35);
}

.notice-image-download-btn:hover {
    background: rgba(229, 0, 0, 0.95);
    color: #fff;
    transform: translateY(-2px) scale(1.05);
}
</style>

<div class="notice-detail-container">
    <div class="notice-detail-header">
        <h1 class="notice-detail-title">{{ $notice->title }}</h1>
        <div class="notice-detail-actions">
            <a href="{{ route('notices.index') }}" class="btn btn-back">← Voltar</a>
            @auth
                @if(Auth::id() === $notice->created_by || Auth::user()->role === 'admin')
                    <button class="btn btn-delete" onclick="openDeleteModal()">🗑️ Remover</button>
                @endif
            @endauth
        </div>
    </div>

    <div class="notice-detail-meta">
        <div class="meta-item">
            <span class="priority-badge priority-{{ $notice->priority }}">{{ ucfirst($notice->priority) }}</span>
        </div>
        <div class="meta-item">
            <span>📅 {{ $notice->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="meta-item">
            <span>⏰ {{ $notice->created_at->format('H:i') }}</span>
        </div>
    </div>

    <!-- BLOCO DE MÍDIA CORRIGIDO -->
    @if($notice->media_path)
    <div class="notice-detail-media">
        @if(str_contains($notice->media_type, 'image'))
            <div class="notice-image-wrapper">
                <img src="{{ asset('storage/' . $notice->media_path) }}" alt="{{ $notice->title }}">

                <a
                    href="{{ route('notices.download', $notice->id) }}"
                    class="notice-image-download-btn"
                    title="Baixar imagem"
                >
                    ⬇
                </a>
            </div>
        @elseif(str_contains($notice->media_type, 'video'))
            <video controls>
                <source src="{{ asset('storage/' . $notice->media_path) }}" type="{{ $notice->media_type }}">
                Seu navegador não suporta vídeo.
            </video>
        @elseif(str_contains($notice->media_type, 'pdf') || $notice->media_type === 'document')
            <iframe src="{{ asset('storage/' . $notice->media_path) }}"></iframe>
        @endif
    </div>
@endif

    <div class="notice-detail-body">
        {{ $notice->body ?? $notice->description }}
    </div>

    <div class="notice-detail-creator">
        <div class="creator-name">👤 {{ $notice->creator->name ?? 'Sistema' }}</div>
        <div class="creator-date">Publicado em {{ $notice->created_at->format('d/m/Y \à\s H:i') }}</div>
    </div>

    <!-- BOTÃO DE DOWNLOAD CORRIGIDO E MOVIDO PARA DENTRO DO CONTAINER -->
    @if($notice->media_path && !str_contains($notice->media_type, 'image'))
    <a href="{{ route('notices.download', $notice->id) }}" class="btn-download-premium">
        ⬇️ Baixar Arquivo Anexado
    </a>
@endif
</div>

<!-- Modal de Confirmação de Deleção -->
<div id="deleteModal" class="modal-delete">
    <div class="modal-delete-content">
        <div class="modal-title">⚠️ Remover Aviso?</div>
        <div class="modal-text">
            Tem certeza que deseja remover este aviso? Esta ação não pode ser desfeita.
        </div>
        <div class="modal-buttons">
            <button class="modal-btn modal-btn-confirm" onclick="confirmDelete()">Remover</button>
            <button class="modal-btn modal-btn-cancel" onclick="closeDeleteModal()">Cancelar</button>
        </div>
    </div>
</div>

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

function confirmDelete() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("notices.destroy", $notice->id) }}';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_token';
        input.value = csrfToken.getAttribute('content');
        form.appendChild(input);
    }
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Fecha modal ao clicar fora
document.getElementById('deleteModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeDeleteModal();
    }
});
</script>

@endsection
@extends('layouts.app')

@section('content')
<style>
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid #222; padding-bottom: 20px; }
    .page-header h1 { font-size: 1.8rem; color: #fff; }
    .page-header h1 span { color: #e50000; }

    .notice-form {
        background: #111;
        border: 1px solid #222;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .notice-form h3 { margin-bottom: 16px; color: #fff; font-size: 1rem; }

    .notice-form input,
    .notice-form textarea,
    .notice-form select {
        width: 100%;
        padding: 10px 14px;
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 4px;
        color: #f0f0f0;
        margin-bottom: 12px;
        font-size: 0.9rem;
    }

    .notice-form input:focus,
    .notice-form textarea:focus,
    .notice-form select:focus { outline: none; border-color: #e50000; }
    .notice-form textarea { min-height: 80px; resize: vertical; }

    /* Upload area */
    .upload-area {
        border: 2px dashed #333;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        margin-bottom: 12px;
        transition: border-color 0.2s;
    }

    .upload-area:hover { border-color: #e50000; }
    .upload-area input[type="file"] { display: none; }
    .upload-area label { cursor: pointer; color: #666; font-size: 0.9rem; }
    .upload-area label span { color: #e50000; }
    .upload-preview { margin-top: 10px; }
    .upload-preview img { max-width: 100%; max-height: 200px; border-radius: 6px; object-fit: cover; }
    .upload-preview video { max-width: 100%; max-height: 200px; border-radius: 6px; }
    .upload-name { font-size: 0.8rem; color: #666; margin-top: 6px; }

    .btn-small { padding: 9px 20px; background: #e50000; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9rem; transition: background 0.2s; }
    .btn-small:hover { background: #cc0000; }

    /* Cards de avisos */
    .notice-card {
        background: #111;
        border: 1px solid #222;
        border-left: 4px solid;
        border-radius: 8px;
        padding: 20px 24px;
        margin-bottom: 16px;
    }

    .notice-card.urgente    { border-left-color: #e50000; }
    .notice-card.importante { border-left-color: #ff6600; }
    .notice-card.normal     { border-left-color: #444; }

    .notice-top { display: flex; justify-content: space-between; align-items: flex-start; }
    .notice-card h3 { font-size: 1rem; margin-bottom: 6px; color: #fff; }
    .notice-card p  { color: #aaa; font-size: 0.9rem; line-height: 1.6; margin-bottom: 12px; }
    .notice-meta    { font-size: 0.75rem; color: #555; margin-top: 8px; }

    /* Mídia do aviso */
    .notice-media { margin-top: 14px; }
    .notice-media img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #222;
    }
    .notice-media video {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        border: 1px solid #222;
    }

    .priority-tag { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; padding: 2px 8px; border-radius: 20px; margin-left: 8px; }
    .priority-tag.urgente    { background: #e50000; color: #fff; }
    .priority-tag.importante { background: #ff6600; color: #fff; }
    .priority-tag.normal     { background: #333; color: #aaa; }

    .btn-delete { background: none; border: none; color: #555; cursor: pointer; font-size: 1rem; padding: 4px 8px; transition: color 0.2s; }
    .btn-delete:hover { color: #e50000; }
</style>

<div class="page-header">
    <h1>Mural de Avisos <span>.</span></h1>
</div>

@if(auth()->user()->isAdmin())
    <div class="notice-form">
        <h3>📢 Publicar Novo Aviso</h3>
        <form method="POST" action="{{ route('notices.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="text" name="title" placeholder="Título do aviso" required>
            <textarea name="body" placeholder="Mensagem do aviso..."></textarea>
            <select name="priority">
                <option value="normal">Normal</option>
                <option value="importante">Importante</option>
                <option value="urgente">Urgente</option>
            </select>

            {{-- Upload de mídia --}}
            <div class="upload-area" onclick="document.getElementById('mediaInput').click()">
                <input type="file" id="mediaInput" name="media" accept="image/*,video/*" onchange="previewMedia(this)">
                <label>
                    📎 Clique para anexar <span>imagem ou vídeo</span><br>
                    <small style="color:#555">JPG, PNG, GIF, MP4, AVI, MOV — máx. 100MB</small>
                </label>
                <div class="upload-preview" id="mediaPreview"></div>
            </div>

            <button type="submit" class="btn-small">PUBLICAR</button>
        </form>
    </div>
@endif

@forelse($notices as $notice)
    <div class="notice-card {{ $notice->priority }}">
        <div class="notice-top">
            <div style="flex:1">
                <h3>
                    {{ $notice->title }}
                    <span class="priority-tag {{ $notice->priority }}">{{ $notice->priority }}</span>
                </h3>
                <p>{{ $notice->body }}</p>

                {{-- Exibir mídia --}}
                @if($notice->media_path)
                    <div class="notice-media">
                        @if($notice->media_type === 'image')
                            <img src="{{ Storage::url($notice->media_path) }}" alt="Imagem do aviso">
                        @elseif($notice->media_type === 'video')
                            <video controls>
                                <source src="{{ Storage::url($notice->media_path) }}" type="video/mp4">
                                Seu navegador não suporta vídeo.
                            </video>
                        @endif
                    </div>
                @endif

                <div class="notice-meta">
                    Por {{ $notice->creator->name }} — {{ $notice->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            @if(auth()->user()->isAdmin())
                <form method="POST" action="{{ route('notices.destroy', $notice) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" title="Remover">✕</button>
                </form>
            @endif
        </div>
    </div>
@empty
    <div style="text-align:center; color:#555; padding: 60px 0;">
        <div style="font-size: 2.5rem; margin-bottom: 12px;">📭</div>
        <p>Nenhum aviso no momento.</p>
    </div>
@endforelse

<script>
function previewMedia(input) {
    const preview = document.getElementById('mediaPreview');
    preview.innerHTML = '';

    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const url  = URL.createObjectURL(file);

    if (file.type.startsWith('image/')) {
        preview.innerHTML = `<img src="${url}" alt="preview"><div class="upload-name">📷 ${file.name}</div>`;
    } else if (file.type.startsWith('video/')) {
        preview.innerHTML = `<video src="${url}" controls></video><div class="upload-name">🎬 ${file.name}</div>`;
    }
}
</script>
@endsection
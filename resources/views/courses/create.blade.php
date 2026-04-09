@extends('layouts.app')

@section('content')
<style>
    .quick-form {
        max-width: 600px;
        margin: 40px auto;
        background: #111;
        border: 1px solid #222;
        border-radius: 10px;
        padding: 32px;
    }

    .quick-form h2 {
        color: #fff;
        font-size: 1.4rem;
        margin-bottom: 24px;
        border-bottom: 1px solid #222;
        padding-bottom: 14px;
    }

    .quick-form h2 span { color: #e50000; }

    .field { margin-bottom: 18px; }

    .field label {
        display: block;
        color: #aaa;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    .field input,
    .field select,
    .field textarea {
        width: 100%;
        padding: 11px 14px;
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 6px;
        color: #f0f0f0;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }

    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        outline: none;
        border-color: #e50000;
    }

    .field textarea { min-height: 80px; resize: vertical; }

    /* Drop zone de vídeo */
    .drop-zone {
        border: 2px dashed #2a2a2a;
        border-radius: 8px;
        padding: 30px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #1a1a1a;
    }

    .drop-zone:hover,
    .drop-zone.dragover { border-color: #e50000; background: #1f1010; }

    .drop-zone input[type="file"] { display: none; }

    .drop-zone .icon { font-size: 2rem; margin-bottom: 8px; }

    .drop-zone p {
        color: #555;
        font-size: 0.85rem;
        margin: 0;
    }

    .drop-zone p span { color: #e50000; cursor: pointer; }

    .file-info {
        margin-top: 10px;
        font-size: 0.82rem;
        color: #888;
        display: none;
    }

    /* Progress bar */
    .progress-wrap {
        display: none;
        margin-top: 12px;
    }

    .progress-bar-bg {
        background: #222;
        border-radius: 20px;
        height: 6px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: #e50000;
        border-radius: 20px;
        width: 0%;
        transition: width 0.3s;
    }

    .progress-label {
        font-size: 0.75rem;
        color: #555;
        margin-top: 4px;
        text-align: right;
    }

    /* Botão publicar */
    .btn-publish {
        width: 100%;
        padding: 13px;
        background: #e50000;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        letter-spacing: 0.05em;
        transition: background 0.2s;
        margin-top: 8px;
    }

    .btn-publish:hover { background: #cc0000; }
    .btn-publish:disabled { background: #444; cursor: not-allowed; }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: #555;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .back-link:hover { color: #e50000; }
</style>

<a href="{{ route('courses.index') }}" class="back-link">← Voltar para cursos</a>

<div class="quick-form">
    <h2>Publicar <span>Curso</span></h2>

    <form
        method="POST"
        action="{{ route('courses.store') }}"
        enctype="multipart/form-data"
        id="courseForm"
    >
        @csrf

        {{-- Título --}}
        <div class="field">
            <label>Título do curso *</label>
            <input
                type="text"
                name="title"
                placeholder="Ex: Treinamento de Atendimento ao Cliente"
                required
                autofocus
            >
        </div>

        {{-- Setor --}}
        <div class="field">
            <label>Disponível para *</label>
            <select name="allowed_role" required>
                <option value="todos">🌐 Todos os setores</option>
                <option value="financeiro">💰 Financeiro</option>
                <option value="rh">👥 RH</option>
                <option value="fiscal">📋 Fiscal</option>
                <option value="comercial">🤝 Comercial</option>
                <option value="compras">🛒 Compras</option>
                <option value="mkt">📣 Marketing</option>
                <option value="vendas">💼 Vendas</option>
                <option value="estoque">📦 Estoque</option>
                <option value="caixa">🏧 Caixa</option>
                <option value="gerencia">🏢 Gerência</option>
                <option value="diretoria">👔 Diretoria</option>
                <option value="proprietario">👑 Proprietário</option>
            </select>
        </div>

        {{-- Descrição (opcional) --}}
        <div class="field">
            <label>Descrição <small style="color:#444">(opcional)</small></label>
            <textarea name="description" placeholder="Breve descrição do conteúdo..."></textarea>
        </div>

        {{-- Upload de vídeo --}}
        <div class="field">
            <label>Vídeo do curso *</label>
            <div class="drop-zone" id="dropZone" onclick="document.getElementById('videoInput').click()">
                <input
                    type="file"
                    id="videoInput"
                    name="video"
                    accept="video/mp4,video/avi,video/mov,video/mkv"
                    required
                    onchange="handleFile(this)"
                >
                <div class="icon">🎬</div>
                <p>Arraste o vídeo aqui ou <span>clique para selecionar</span></p>
                <p style="margin-top:4px">MP4, AVI, MOV, MKV — máx. 2 GB</p>
                <div class="file-info" id="fileInfo"></div>
            </div>

            <div class="progress-wrap" id="progressWrap">
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" id="progressFill"></div>
                </div>
                <div class="progress-label" id="progressLabel">0%</div>
            </div>
        </div>

        <button type="submit" class="btn-publish" id="btnPublish">
            🚀 PUBLICAR AGORA
        </button>
    </form>
</div>

<script>
// Drag and drop
const dropZone = document.getElementById('dropZone');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('dragover');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('dragover');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
        document.getElementById('videoInput').files = e.dataTransfer.files;
        handleFile(document.getElementById('videoInput'));
    }
});

// Preview do arquivo selecionado
function handleFile(input) {
    if (!input.files || !input.files[0]) return;
    const file  = input.files[0];
    const sizeMB = (file.size / 1024 / 1024).toFixed(1);
    const info  = document.getElementById('fileInfo');
    info.style.display = 'block';
    info.innerHTML = `✅ <strong>${file.name}</strong> — ${sizeMB} MB`;
}

// Simular progresso no submit
document.getElementById('courseForm').addEventListener('submit', function () {
    const btn  = document.getElementById('btnPublish');
    const wrap = document.getElementById('progressWrap');
    const fill = document.getElementById('progressFill');
    const lbl  = document.getElementById('progressLabel');

    btn.disabled    = true;
    btn.textContent = '⏳ Enviando...';
    wrap.style.display = 'block';

    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress >= 95) { progress = 95; clearInterval(interval); }
        fill.style.width = progress + '%';
        lbl.textContent  = Math.round(progress) + '%';
    }, 300);
});
</script>

@endsection
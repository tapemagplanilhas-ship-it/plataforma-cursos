@extends('layouts.app')

@section('content')
<style>
    .create-form-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(229, 0, 0, 0.2);
        color: #fff;
    }
    .form-title {
        font-size: 2rem;
        color: #e50000;
        margin-bottom: 30px;
        text-align: center;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #e50000;
        font-weight: bold;
    }
    .form-input, .form-textarea, .form-select {
        width: 100%;
        padding: 12px;
        border: 2px solid #333;
        border-radius: 6px;
        background: #111;
        color: #fff;
        font-family: inherit;
        transition: border-color 0.3s;
    }
    .form-input:focus, .form-textarea:focus, .form-select:focus {
        outline: none;
        border-color: #e50000;
    }
    .form-textarea {
        resize: vertical;
        min-height: 150px;
    }
    .form-submit {
        background: #e50000;
        color: #fff;
        padding: 12px 30px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        transition: background 0.3s;
    }
    .form-submit:hover {
        background: #cc0000;
    }
    .color-picker {
        display: flex;
        gap: 10px;
        margin-top: 8px;
    }
    .color-option {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        cursor: pointer;
        border: 3px solid transparent;
        transition: border-color 0.3s;
    }
    .color-option.selected {
        border-color: #fff;
    }
</style>

<div class="create-form-container">
    <h1 class="form-title">➕ Publicar Novo Aviso</h1>

    <form action="{{ route('notices.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title" class="form-label">Título *</label>
            <input type="text" id="title" name="title" class="form-input" placeholder="Titulo do aviso" required>
            @error('title') <span style="color: #ff4444;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Conteúdo *</label>
            <textarea id="description" name="description" class="form-textarea" placeholder="Escreva o conteúdo do aviso..." required></textarea>
            @error('description') <span style="color: #ff4444;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="priority" class="form-label">Prioridade *</label>
            <select id="priority" name="priority" class="form-select" required>
                <option value="">Selecione...</option>
                <option value="normal">Normal</option>
                <option value="importante">Importante</option>
                <option value="urgente">Urgente</option>
            </select>
            @error('priority') <span style="color: #ff4444;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="color" class="form-label">Cor *</label>
            <input type="color" id="color" name="color" class="form-input" value="#e50000" required>
            @error('color') <span style="color: #ff4444;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="media_path" class="form-label">Arquivos, Imagens ou Vídeos (opcional)</label>
            <input type="file" id="media_path" name="media_path" class="form-input" accept="image/*,video/*, application/pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .txt, .zip, .rar">
            @error('media_path') <span style="color: #ff4444;">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="form-submit">✅ Publicar Aviso</button>
    </form>
</div>
@endsection
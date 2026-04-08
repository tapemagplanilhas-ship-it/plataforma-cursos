@extends('layouts.app')

@section('content')
<style>
    .edit-container {
        max-width: 500px;
        margin: 40px auto;
    }

    .edit-header {
        margin-bottom: 30px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 16px;
        transition: border-color 0.3s ease;
    }

    .edit-header h1 {
        font-size: 1.6rem;
        color: var(--text-primary);
        margin: 0 0 4px 0;
        transition: color 0.3s ease;
    }

    .edit-header h1 span {
        color: var(--accent);
        transition: color 0.3s ease;
    }

    .edit-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin: 0;
        transition: color 0.3s ease;
    }

    .edit-form {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 28px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        color: var(--text-secondary);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 11px 14px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-light);
        border-radius: 6px;
        color: var(--text-primary);
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(229, 0, 0, 0.1);
    }

    .form-group input::placeholder {
        color: var(--text-muted);
        transition: color 0.3s ease;
    }

    .password-section {
        background: var(--bg-tertiary);
        border: 1px solid var(--border-light);
        border-radius: 6px;
        padding: 16px;
        margin-top: 24px;
        margin-bottom: 20px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .password-section h3 {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin: 0 0 12px 0;
        padding: 0;
        transition: color 0.3s ease;
    }

    .password-requirement {
        display: flex;
        align-items: center;
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 8px;
        gap: 8px;
        transition: color 0.3s ease;
    }

    .password-requirement.met {
        color: #4ade80;
    }

    .password-requirement .icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        font-size: 0.7rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .password-requirement .icon.unmet {
        background: var(--border);
        color: var(--text-muted);
    }

    .password-requirement.met .icon {
        background: #22c55e;
        color: #fff;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
    }

    .btn-primary,
    .btn-secondary {
        flex: 1;
        padding: 12px;
        border-radius: 6px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.3s ease;
        letter-spacing: 0.05em;
    }

    .btn-primary {
        background: var(--accent);
        color: #fff;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border);
    }

    .btn-secondary:hover {
        color: var(--text-secondary);
        border-color: var(--border-light);
    }

    .alert {
        padding: 12px 14px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .alert-error {
        background: rgba(229, 0, 0, 0.1);
        color: #f87171;
        border: 1px solid var(--accent);
    }

    .back-link {
        display: inline-block;
        margin-bottom: 20px;
        color: var(--text-muted);
        font-size: 0.85rem;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: var(--accent);
    }
</style>

<a href="{{ route('admin.users') }}" class="back-link">← Voltar para usuários</a>

<div class="edit-container">
    <div class="edit-header">
        <h1>Editar <span>{{ $user->name }}</span></h1>
        <p>Atualize informações e senha do usuário</p>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                ❌ {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="edit-form">
        @csrf
        @method('PATCH')

        {{-- Nome --}}
        <div class="form-group">
            <label for="name">Nome completo *</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
            >
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label for="email">Email *</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
            >
        </div>

        {{-- Seção de Senha --}}
        <div class="password-section">
            <h3>🔐 Alterar Senha (opcional)</h3>
            <p style="color:#666; font-size:0.85rem; margin:0 0 12px 0;">Deixe em branco para manter a senha atual</p>

            {{-- Nova Senha --}}
            <div class="form-group" style="margin-bottom:16px;">
                <label for="password">Nova senha</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Mínimo 8 caracteres"
                    onchange="validatePassword()"
                >
            </div>

            {{-- Confirmar Senha --}}
            <div class="form-group">
                <label for="password_confirmation">Confirmar senha</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirme a nova senha"
                >
            </div>

            {{-- Requisitos de Senha --}}
            <div style="margin-top:12px;">
                <div class="password-requirement" id="req-length">
                    <span class="icon unmet">✗</span>
                    <span>Mínimo 8 caracteres</span>
                </div>
                <div class="password-requirement" id="req-uppercase">
                    <span class="icon unmet">✗</span>
                    <span>Pelo menos uma letra maiúscula</span>
                </div>
                <div class="password-requirement" id="req-number">
                    <span class="icon unmet">✗</span>
                    <span>Pelo menos um número</span>
                </div>
                <div class="password-requirement" id="req-special">
                    <span class="icon unmet">✗</span>
                    <span>Pelo menos um caractere especial (!@#$%)</span>
                </div>
            </div>
        </div>

        {{-- Botões --}}
        <div class="form-actions">
            <button type="submit" class="btn-primary">💾 Salvar Alterações</button>
            <a href="{{ route('admin.users') }}" class="btn-secondary" style="display:flex; align-items:center; justify-content:center; text-decoration:none;">Cancelar</a>
        </div>
    </form>
</div>

<script>
function validatePassword() {
    const pwd = document.getElementById('password').value;

    // Validadores
    const hasLength = pwd.length >= 8;
    const hasUppercase = /[A-Z]/.test(pwd);
    const hasNumber = /[0-9]/.test(pwd);
    const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\|,.<>\/?]/.test(pwd);

    // Atualizar UI
    updateRequirement('req-length', hasLength);
    updateRequirement('req-uppercase', hasUppercase);
    updateRequirement('req-number', hasNumber);
    updateRequirement('req-special', hasSpecial);
}

function updateRequirement(id, met) {
    const el = document.getElementById(id);
    if (met) {
        el.classList.add('met');
        el.querySelector('.icon').textContent = '✓';
        el.querySelector('.icon').classList.remove('unmet');
    } else {
        el.classList.remove('met');
        el.querySelector('.icon').textContent = '✗';
        el.querySelector('.icon').classList.add('unmet');
    }
}

// Validar ao digitar
document.getElementById('password').addEventListener('input', validatePassword);
</script>
@endsection
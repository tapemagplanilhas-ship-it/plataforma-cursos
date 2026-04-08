@extends('layouts.app')

@section('content')
<style>
    .admin-header { 
        margin-bottom: 30px; 
    }
    
    .admin-header h1 { 
        font-size: 1.8rem; 
        color: var(--text-primary);
        transition: color 0.3s ease;
    }
    
    .admin-header h1 span { 
        color: var(--accent);
        transition: color 0.3s ease;
    }

    .admin-nav {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .admin-nav a {
        padding: 8px 18px;
        border-radius: 6px;
        font-size: 0.85rem;
        text-decoration: none;
        border: 1px solid var(--border);
        color: var(--text-muted);
        transition: all 0.3s ease;
        background: var(--bg-tertiary);
    }

    .admin-nav a:hover,
    .admin-nav a.active { 
        background: var(--accent); 
        color: #fff; 
        border-color: var(--accent);
        transform: translateY(-2px);
    }

    .users-table {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .users-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead {
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border);
    }

    .users-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .users-table td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-light);
        color: var(--text-secondary);
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .users-table tbody tr:hover { 
        background: var(--bg-tertiary);
        transition: background-color 0.3s ease;
    }

    .role-select {
        background: var(--bg-tertiary);
        border: 1px solid var(--border);
        color: var(--text-secondary);
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .role-select:focus { 
        outline: none; 
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(229, 0, 0, 0.1);
    }

    .btn-save {
        background: var(--accent);
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-save:hover { 
        background: var(--accent-hover);
        transform: translateY(-2px);
    }

    .btn-delete {
        background: transparent;
        color: var(--accent);
        border: 1px solid var(--accent);
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-delete:hover { 
        background: var(--accent); 
        color: #fff;
        transform: translateY(-2px);
    }

    .alert {
        padding: 14px 16px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .alert-success { 
        background: rgba(74, 222, 128, 0.1); 
        color: #4ade80; 
        border: 1px solid #22c55e;
    }
    
    .alert-error { 
        background: rgba(229, 0, 0, 0.1); 
        color: #f87171; 
        border: 1px solid var(--accent);
    }
</style>

<div class="admin-header">
    <h1>Gerenciar <span>Usuários</span></h1>
    <p>Total de {{ $users->count() }} usuários cadastrados</p>
</div>

<div class="admin-nav">
    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('admin.users') }}" class="active">👥 Usuários</a>
    <a href="{{ route('courses.create') }}">🎬 Novo Curso</a>
    <a href="{{ route('notices.index') }}">📢 Avisos</a>
</div>

@if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
@endif

<div class="users-table">
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Setor</th>
                <th>Role Atual</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.role', $user) }}" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="role-select" onchange="this.form.submit()">
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="financeiro" {{ $user->role === 'financeiro' ? 'selected' : '' }}>Financeiro</option>
                                <option value="rh" {{ $user->role === 'rh' ? 'selected' : '' }}>RH</option>
                                <option value="fiscal" {{ $user->role === 'fiscal' ? 'selected' : '' }}>Fiscal</option>
                                <option value="comercial" {{ $user->role === 'comercial' ? 'selected' : '' }}>Comercial</option>
                                <option value="compras" {{ $user->role === 'compras' ? 'selected' : '' }}>Compras</option>
                                <option value="mkt" {{ $user->role === 'mkt' ? 'selected' : '' }}>Marketing</option>
                                <option value="vendas" {{ $user->role === 'vendas' ? 'selected' : '' }}>Vendas</option>
                                <option value="estoque" {{ $user->role === 'estoque' ? 'selected' : '' }}>Estoque</option>
                                <option value="caixa" {{ $user->role === 'caixa' ? 'selected' : '' }}>Caixa</option>
                                <option value="gerencia" {{ $user->role === 'gerencia' ? 'selected' : '' }}>Gerência</option>
                                <option value="diretoria" {{ $user->role === 'diretoria' ? 'selected' : '' }}>Diretoria</option>
                                <option value="proprietario" {{ $user->role === 'proprietario' ? 'selected' : '' }}>Proprietário</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        @if($user->id !== auth()->id())
                            <a href="{{ route('admin.users.edit', $user) }}" style="color:#e50000; margin-right:8px; text-decoration:none; font-size:0.8rem;">✏️ Editar</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;" onsubmit="return confirm('Remover {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                    <button type="submit" class="btn-delete">🗑 Remover</button>
                                </form>
                        @else
                            <span style="color:#666; font-size:0.8rem;">(Você)</span>
                        @endif
                    </td>               
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#555; padding:30px;">
                        Nenhum usuário cadastrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
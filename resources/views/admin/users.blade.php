@extends('layouts.app')

@section('content')
<style>
    .admin-header { margin-bottom: 30px; }
    .admin-header h1 { font-size: 1.8rem; color: #fff; }
    .admin-header h1 span { color: #e50000; }

    .admin-nav {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .admin-nav a {
        padding: 8px 18px;
        border-radius: 6px;
        font-size: 0.85rem;
        text-decoration: none;
        border: 1px solid #222;
        color: #888;
        transition: all 0.2s;
    }

    .admin-nav a:hover,
    .admin-nav a.active { background: #e50000; color: #fff; border-color: #e50000; }

    .users-table {
        background: #111;
        border: 1px solid #222;
        border-radius: 8px;
        overflow: hidden;
    }

    .users-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead {
        background: #1a1a1a;
        border-bottom: 1px solid #222;
    }

    .users-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 0.8rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }

    .users-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #1a1a1a;
        color: #ddd;
        font-size: 0.9rem;
    }

    .users-table tbody tr:hover { background: #1a1a1a; }

    .role-select {
        background: #2a2a2a;
        border: 1px solid #3a3a3a;
        color: #ddd;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        cursor: pointer;
    }

    .role-select:focus { outline: none; border-color: #e50000; }

    .btn-save {
        background: #e50000;
        color: #fff;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-save:hover { background: #cc0000; }

    .btn-delete {
        background: transparent;
        color: #e50000;
        border: 1px solid #e50000;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-delete:hover { background: #e50000; color: #fff; }

    .alert {
        padding: 14px 16px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 0.85rem;
    }

    .alert-success { background: #0d2817; color: #4ade80; border: 1px solid #22c55e; }
    .alert-error { background: #2d0a0a; color: #f87171; border: 1px solid #ef4444; }
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
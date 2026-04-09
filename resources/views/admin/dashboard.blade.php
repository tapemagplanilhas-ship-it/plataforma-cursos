@extends('layouts.app')

@section('content')
<style>
    .admin-header { 
        margin-bottom: 30px; 
    }
    
    .admin-header h1 { 
        font-size: 1.8rem; 
        color: var(--text-primary); 
    }
    
    .admin-header h1 span { 
        color: var(--accent); 
    }
    
    .admin-header p { 
        color: var(--text-muted); 
        font-size: 0.9rem; 
        margin-top: 4px; 
    }

    /* Cards de stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: var(--accent);
        box-shadow: 0 8px 20px rgba(229, 0, 0, 0.2);
    }

    .stat-card .number {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--accent);
    }

    .stat-card .label {
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 4px;
    }

    /* Seção dupla */
    .admin-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media(max-width: 768px) { 
        .admin-grid { 
            grid-template-columns: 1fr; 
        } 
    }

    .admin-section {
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .admin-section h3 {
        font-size: 0.9rem;
        color: var(--text-primary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-light);
    }

    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--border-light);
        font-size: 0.875rem;
    }

    .item-row:last-child { 
        border-bottom: none; 
    }
    
    .item-row .name { 
        color: var(--text-secondary); 
    }
    
    .item-row .meta { 
        color: var(--text-muted); 
        font-size: 0.78rem; 
    }

    /* Role tags */
    .role-tag {
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 20px;
        background: var(--bg-tertiary);
        color: var(--text-muted);
        border: 1px solid var(--border);
    }

    .role-tag.admin { 
        background: rgba(229, 0, 0, 0.1); 
        color: var(--accent); 
        border-color: var(--accent); 
    }

    /* Distribuição por setor */
    .role-bar { 
        margin-bottom: 10px; 
    }
    
    .role-bar-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .role-bar-bg {
        background: var(--bg-tertiary);
        border-radius: 20px;
        height: 5px;
        overflow: hidden;
    }

    .role-bar-fill {
        height: 100%;
        background: var(--accent);
        border-radius: 20px;
    }

    /* Nav admin */
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
</style>

<div class="admin-header">
    <h1>Painel <span>Admin</span></h1>
    <p>Bem-vindo, {{ auth()->user()->name }}. Aqui está o resumo da plataforma.</p>
</div>

<div class="admin-nav">
    <a href="{{ route('admin.dashboard') }}" class="active">📊 Dashboard</a>
    <a href="{{ route('admin.users') }}">👥 Usuários</a>
    <a href="{{ route('courses.create') }}">🎬 Novo Curso</a>
    <a href="{{ route('notices.index') }}">📢 Avisos</a>
</div>

{{-- Cards de estatísticas --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="number">{{ $stats['total_users'] }}</div>
        <div class="label">Usuários</div>
    </div>
    <div class="stat-card">
        <div class="number">{{ $stats['total_courses'] }}</div>
        <div class="label">Cursos</div>
    </div>
    <div class="stat-card">
        <div class="number">{{ $stats['total_notices'] }}</div>
        <div class="label">Avisos Ativos</div>
    </div>
    <div class="stat-card">
        <div class="number">{{ $stats['users_by_role']->count() }}</div>
        <div class="label">Setores</div>
    </div>
</div>

<div class="admin-grid">
    {{-- Cursos recentes --}}
    <div class="admin-section">
        <h3>🎬 Cursos Recentes</h3>
        @forelse($recent_courses as $course)
            <div class="item-row">
                <div>
                    <div class="name">{{ $course->title }}</div>
                    <div class="meta">{{ $course->allowed_role }} • {{ $course->created_at->format('d/m/Y') }}</div>
                </div>
                <a href="{{ route('courses.show', $course) }}" style="color:#e50000; font-size:0.8rem;">Ver</a>
            </div>
        @empty
            <p style="color:#555; font-size:0.85rem;">Nenhum curso ainda.</p>
        @endforelse
    </div>

    {{-- Usuários por setor --}}
    <div class="admin-section">
        <h3>👥 Usuários por Setor</h3>
        @php $maxUsers = $stats['users_by_role']->max('total'); @endphp
        @foreach($stats['users_by_role'] as $item)
            <div class="role-bar">
                <div class="role-bar-label">
                    <span>{{ ucfirst($item->role) }}</span>
                    <span>{{ $item->total }}</span>
                </div>
                <div class="role-bar-bg">
                    <div class="role-bar-fill" style="width: {{ ($item->total / $maxUsers) * 100 }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <title>{{ config('app.name', 'Plataforma de Cursos') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: #0a0a0a;
            color: #f0f0f0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        /* NAVBAR */
        nav {
            background: #111;
            border-bottom: 2px solid #e50000;
            padding: 14px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav .logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: #e50000;
            text-decoration: none;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        nav .nav-links a {
            color: #f0f0f0;
            text-decoration: none;
            margin-left: 20px;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        nav .nav-links a:hover { color: #e50000; }

        nav .nav-links span {
            color: #888;
            font-size: 0.8rem;
            margin-left: 20px;
        }

        nav .nav-links form { display: inline; }

        nav .nav-links button {
            background: none;
            border: 1px solid #e50000;
            color: #e50000;
            padding: 5px 14px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            margin-left: 20px;
            transition: all 0.2s;
        }

        nav .nav-links button:hover {
            background: #e50000;
            color: #fff;
        }

        /* CONTAINER */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* ALERTS */
        .alert-success {
            background: #1a1a1a;
            border-left: 4px solid #e50000;
            color: #f0f0f0;
            padding: 12px 18px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #1a0000;
            border-left: 4px solid #e50000;
            color: #ff6666;
            padding: 12px 18px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        /* BADGES */
        .badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-admin     { background: #e50000; color: #fff; }
        .badge-professor { background: #ff6600; color: #fff; }
        .badge-aluno     { background: #333; color: #f0f0f0; }
    </style>
</head>
<body>

<nav>
    <a href="{{ route('courses.index') }}" class="logo">
        <img src="{{ asset('images/tapemag-logo.png') }}" alt="Tapemag" style="height: 42px; object-fit: contain;">
    </a>
    <div class="nav-links">
        @auth
            <a href="{{ route('courses.index') }}">Cursos</a>
            <a href="{{ route('notices.index') }}">Avisos</a>
            <a href="{{ route('chat.index') }}">Chat</a>

            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">⚙️ Admin</a>
            @endif
            <span>{{ auth()->user()->name }}</span>
            <span class="badge badge-{{ auth()->user()->role }}">{{ auth()->user()->role }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Sair</button>
            </form>
        @endauth
    </div>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    @yield('content')
</div>

<!-- Modal Boas-vindas ao Login -->
@if(session('show_welcome_modal'))
<style>
    .welcome-modal { display: block; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
    .modal-content { background: #fff; border-radius: 12px; margin: 10% auto; padding: 24px; width: 90%; max-width: 500px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
    .modal-title { font-size: 1.5rem; margin-bottom: 16px; color: #e50000; }
    .notice-item { background: #f5f5f5; padding: 12px; margin: 8px 0; border-radius: 8px; border-left: 4px solid #e50000; }
    .close-btn { background: #e50000; color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; width: 100%; margin-top: 16px; }
</style>

<div id="welcomeModal" class="welcome-modal">
    <div class="modal-content">
        <h2 class="modal-title">🔔 Bem-vindo, {{ Auth::user()->name }}!</h2>
        <p>Explore novos cursos no seu setor e desbloqueie badges!</p>
        <button class="close-btn" onclick="closeWelcomeModal()">Continuar</button>
    </div>
</div>

<script>
function closeWelcomeModal() { document.getElementById('welcomeModal').style.display = 'none'; }
</script>
@endif

@if(session('badge_unlocked'))
<div id="badgeAlert" style="display: block; position: fixed; top: 20px; right: 20px; z-index: 10000; background: linear-gradient(135deg, #e50000, #cc0000); color: #fff; padding: 16px 24px; border-radius: 12px; box-shadow: 0 8px 20px rgba(229,0,0,0.3); max-width: 300px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <img src="{{ asset(session('badge_unlocked.icon')) }}" alt="Badge" style="width: 40px; height: 40px; border-radius: 50%;">
        <div>
            <h3 style="margin: 0; font-size: 1.2rem;">🎉 Parabéns!</h3>
            <p style="margin: 4px 0 0 0; font-size: 0.9rem;">Desbloqueou: {{ session('badge_unlocked.badge') }}</p>
        </div>
    </div>
    <button onclick="this.parentElement.style.display='none'" style="background: none; border: none; color: #fff; font-size: 1.5rem; cursor: pointer; float: right;">&times;</button>
</div>

<script>
    // Auto-hide após 5s
    setTimeout(() => {
        document.getElementById('badgeAlert').style.display = 'none';
    }, 5000);
</script>
@endif

<!-- ALERT DE BEM-VINDO A CADA LOGIN -->
@if(session('welcome'))
<style>
    .alert-welcome {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        color: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(229, 0, 0, 0.5);
        z-index: 10000;
        width: 90%;
        max-width: 500px;
        text-align: center;
        animation: slideIn 0.5s ease;
    }
    @keyframes slideIn {
        from { transform: translate(-50%, -60%); opacity: 0; }
        to { transform: translate(-50%, -50%); opacity: 1; }
    }
    .alert-title {
        font-size: 2rem;
        color: #e50000;
        margin-bottom: 15px;
    }
    .alert-text {
        font-size: 1.1rem;
        color: #ccc;
        margin-bottom: 20px;
    }
    .alert-button {
        background: #e50000;
        color: #fff;
        border: none;
        padding: 12px 30px;
        border-radius: 6px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s;
    }
    .alert-button:hover {
        background: #cc0000;
    }
    .alert-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 9999;
    }
</style>

<div class="alert-overlay" onclick="closeAlert()"></div>
<div class="alert-welcome">
    <div class="alert-title">🔔 Bem-vindo de Volta!</div>
    <div class="alert-text">{{ Auth::user()->name }}, você tem novos avisos e cursos para explorar.</div>
    <button class="alert-button" onclick="closeAlert()">Entendi, Continuar</button>
</div>

<script>
function closeAlert() {
    const overlay = document.querySelector('.alert-overlay');
    const alert = document.querySelector('.alert-welcome');
    if (overlay) overlay.remove();
    if (alert) alert.remove();
}

// Auto-fecha após 8s
setTimeout(() => {
    const alert = document.querySelector('.alert-welcome');
    if (alert) {
        closeAlert();
    }
}, 8000);
</script>
@endif

</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <title>{{ config('app.name', 'Tapemag') }}</title>
    <style>
        /* === VARIÁVEIS DE TEMA GLOBAIS === */
        :root {
            --bg-primary: #0a0a0a;
            --bg-secondary: #111111;
            --bg-tertiary: #1a1a1a;
            --text-primary: #f0f0f0;
            --text-secondary: #cccccc;
            --text-muted: #888888;
            --accent: #e50000;
            --accent-hover: #cc0000;
            --border: #333333;
            --border-light: #2a2a2a;
            --dropdown-bg: linear-gradient(135deg, #151515 0%, #1f1f1f 100%);
            --dropdown-solid: #1a1a1a;
        }

        [data-theme="light"] {
            --bg-primary: #f4f4f5;
            --bg-secondary: #ffffff;
            --bg-tertiary: #e9ecef;
            --text-primary: #1a1a1a;
            --text-secondary: #4a4a4a;
            --text-muted: #6c757d;
            --accent: #e50000;
            --accent-hover: #cc0000;
            --border: #dee2e6;
            --border-light: #e9ecef;
            --dropdown-bg: #ffffff;
            --dropdown-solid: #ffffff;
        }

        /* === CONTROLE DINÂMICO DA LOGO === */
        nav .logo img {
            transition: filter 0.3s ease;
        }

        [data-theme="light"] nav .logo img {
            filter: brightness(0);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* === APLICAÇÃO DAS VARIÁVEIS === */
        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* NAVBAR */
        nav {
            background: var(--bg-secondary);
            border-bottom: 2px solid var(--accent);
            padding: 14px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: background-color 0.3s ease;
        }

        nav .logo {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent);
            text-decoration: none;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        nav .nav-links a {
            color: var(--text-primary);
            text-decoration: none;
            margin-left: 20px;
            font-size: 0.9rem;
            transition: color 0.2s;
            font-weight: 600;
        }

        nav .nav-links a:hover { color: var(--accent); }

        /* CONTAINER */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* ALERTS */
        .alert-success {
            background: var(--bg-tertiary);
            border-left: 4px solid var(--accent);
            color: var(--text-primary);
            padding: 12px 18px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: rgba(229, 0, 0, 0.1);
            border-left: 4px solid var(--accent);
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
            margin-left: 10px;
        }

        .badge-admin     { background: var(--accent); color: #fff; }
        .badge-professor { background: #ff6600; color: #fff; }
        .badge-aluno     { background: var(--bg-tertiary); color: var(--text-primary); }

        nav .nav-links {
            display: flex;
            align-items: center;
        }

        /* NOTIFICAÇÕES */
        .notification-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
            margin-left: 10px;
        }

        .notification-bell {
            position: relative;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--bg-secondary);
            color: var(--text-primary);
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            line-height: 1;
            transition: all 0.2s ease;
        }

        .notification-bell:hover {
            border-color: var(--accent);
            background: var(--bg-tertiary);
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 999px;
            background: var(--accent);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            width: 320px;
            background: var(--dropdown-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.2);
            display: none;
            overflow: hidden;
            z-index: 9999;
        }

        .notification-dropdown.show {
            display: block;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-light);
            color: var(--text-primary);
            font-weight: 700;
        }

        .notification-read-all {
            background: none;
            border: none;
            color: var(--accent);
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .notification-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .notification-item {
            display: block;
            padding: 14px 16px;
            text-decoration: none;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-light);
            transition: background 0.2s ease;
        }

        .notification-item:hover {
            background: rgba(229, 0, 0, 0.06);
        }

        .notification-item.unread {
            background: rgba(229, 0, 0, 0.08);
            border-left: 3px solid var(--accent);
        }

        .notification-item-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .notification-item-time {
            font-size: 0.76rem;
            color: var(--text-muted);
        }

        .notification-empty {
            padding: 18px;
            text-align: center;
            color: var(--text-muted);
        }

        /* === INDICADOR DE STATUS DE CONEXÃO === */
        .connection-status-wrapper {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-left: 20px;
            padding: 4px 10px;
            background: var(--bg-tertiary);
            border-radius: 20px;
            border: 1px solid var(--border);
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #ffcc00;
            box-shadow: 0 0 8px #ffcc00;
            transition: all 0.3s ease;
        }

        .status-online .status-dot {
            background-color: #00cc66;
            box-shadow: 0 0 8px rgba(0, 204, 102, 0.6);
        }
        .status-online .status-text { color: #00cc66; }

        .status-offline .status-dot {
            background-color: #e50000;
            box-shadow: 0 0 8px rgba(229, 0, 0, 0.6);
            animation: pulse-error 1.5s infinite;
        }
        .status-offline .status-text { color: #e50000; }

        @keyframes pulse-error {
            0% { box-shadow: 0 0 0 0 rgba(229, 0, 0, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(229, 0, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(229, 0, 0, 0); }
        }

        /* ==========================================================================
           NOVO: DROPDOWN DE PERFIL (ESTILO BALÃO)
           ========================================================================== */
        .profile-menu-wrapper {
            position: relative;
            display: inline-block;
            margin-left: 20px;
        }

        /* O Avatar Redondo */
        .profile-trigger {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(229, 0, 0, 0.2);
        }

        .profile-trigger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(229, 0, 0, 0.3);
        }

        /* O Balão Dropdown */
        .profile-dropdown-content {
            position: absolute;
            top: 55px;
            right: 0;
            width: 220px;
            background: var(--dropdown-solid);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            display: none; /* Escondido por padrão */
            flex-direction: column;
            z-index: 1000;
            padding: 8px;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        /* Animação de entrada */
        .profile-dropdown-content.show {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        /* A Setinha do Balão (Triângulo) */
        .profile-dropdown-content::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 15px; /* Alinhado com o avatar */
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid var(--border);
        }

        /* Triângulo interno para cobrir a borda */
        .profile-dropdown-content::after {
            content: '';
            position: absolute;
            top: -7px;
            right: 15px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid var(--dropdown-solid);
        }

        /* Informações do Usuário no Topo do Balão */
        .profile-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-light);
            margin-bottom: 8px;
            display: flex;
            flex-direction: column; /* Força um item embaixo do outro */
            align-items: flex-start; /* Alinha tudo perfeitamente à esquerda */
            gap: 6px; /* Dá um respiro elegante entre o nome e a badge */
        }

        .profile-name {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 0.95rem;
            margin-bottom: 0; /* Tiramos a margem antiga porque o gap já faz o trabalho */
            line-height: 1;
        }

        /* Itens do Menu (Admin, Tema) */
        .profile-item {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 8px;
            transition: background 0.2s ease;
            cursor: pointer;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
        }

        .profile-item:hover {
            background: var(--bg-tertiary);
            color: var(--accent);
        }

        /* Ícones minimalistas (SVG) */
        .profile-icon {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            fill: currentColor;
            opacity: 0.8;
        }

        /* Botão Sair (Vermelho e Arredondado) */
        .profile-logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 8px;
            padding: 10px;
            background: var(--accent);
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 999px; /* Totalmente arredondado */
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .profile-logout-btn:hover {
            background: var(--accent-hover);
            transform: scale(1.02);
        }

        .profile-logout-btn .profile-icon {
            fill: #ffffff;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    @php
        $user = auth()->user();
        $excludedEmails = ['suporte@tapemag.com.br', 'victor.araujo@tapemag.com.br'];
        $shouldShowPasswordPrompt =
            $user &&
            !$user->password_change_prompt_seen &&
            !in_array($user->email, $excludedEmails);
    @endphp

<nav>
    <a href="{{ route('courses.index') }}" class="logo">
        <img src="{{ asset('images/tapemag-logo.png') }}" alt="Tapemag" style="height: 42px; object-fit: contain;">
    </a>
    @auth
    <div class="nav-links">
        <a href="{{ route('courses.index') }}">Cursos</a>
        <a href="{{ route('notices.index') }}">Avisos</a>
        <a href="{{ route('chat.index') }}">Chat</a>
        
        <div class="notification-wrapper">
            <button type="button" class="notification-bell" id="notificationBell">
                🔔
                <span class="notification-badge" id="notificationBadge">
                    {{ auth()->user()->systemNotifications()->where('is_read', false)->count() }}
                </span>
            </button>

            <div class="notification-dropdown" id="notificationDropdown">
                <div class="notification-header">
                    <span>Notificações</span>
                    <button type="button" class="notification-read-all" id="markAllNotificationsRead">
                        Marcar todas
                    </button>
                </div>

                <div class="notification-list" id="notificationList">
                    <div class="notification-empty">Carregando...</div>
                </div>
            </div>
        </div>
        
        <!-- INDICADOR DE STATUS DE CONEXÃO -->
        <div class="connection-status-wrapper" id="connectionStatus" title="Status da conexão com o servidor">
            <div class="status-dot"></div>
            <span class="status-text" id="connectionText">Conectando...</span>
        </div>

        <!-- ==========================================
             NOVO: MENU DROPDOWN DE PERFIL (BALÃO)
             ========================================== -->
        <div class="profile-menu-wrapper">
            <!-- Avatar Gatilho (Primeira letra do nome) -->
            <div class="profile-trigger" id="profileTrigger">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <!-- Conteúdo do Balão -->
            <div class="profile-dropdown-content" id="profileDropdown">
                <div class="profile-header">
                    <div class="profile-name">{{ auth()->user()->name }}</div>
                    <span class="badge badge-{{ auth()->user()->role }}" style="margin-left: 0; align-self: flex-start;">{{ auth()->user()->role }}</span>
                </div>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="profile-item">
                        <!-- Ícone de Engrenagem (Admin) -->
                        <svg class="profile-icon" viewBox="0 0 24 24"><path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.06-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.73,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.06,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.43-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.49-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/></svg>
                        Admin
                    </a>
                @endif

                <button id="theme-toggle" class="profile-item">
                    <!-- Ícone de Sol/Lua (Tema) -->
                    <svg class="profile-icon" viewBox="0 0 24 24"><path d="M12,7c-2.76,0-5,2.24-5,5s2.24,5,5,5s5-2.24,5-5S14.76,7,12,7L12,7z M2,13l2,0c0.55,0,1-0.45,1-1s-0.45-1-1-1l-2,0 c-0.55,0-1,0.45-1,1S1.45,13,2,13z M20,13l2,0c0.55,0,1-0.45,1-1s-0.45-1-1-1l-2,0c-0.55,0-1,0.45-1,1S19.45,13,20,13z M11,2v2 c0,0.55,0.45,1,1,1s1-0.45,1-1V2c0-0.55-0.45-1-1-1S11,1.45,11,2z M11,20v2c0,0.55,0.45,1,1,1s1-0.45,1-1v-2c0-0.55-0.45-1-1-1 C11.45,19,11,19.45,11,20z M5.99,4.58c-0.39-0.39-1.03-0.39-1.41,0c-0.39,0.39-0.39,1.03,0,1.41l1.06,1.06 c0.39,0.39,1.03,0.39,1.41,0s0.39-1.03,0-1.41L5.99,4.58z M18.36,16.95c-0.39-0.39-1.03-0.39-1.41,0c-0.39,0.39-0.39,1.03,0,1.41 l1.06,1.06c0.39,0.39,1.03,0.39,1.41,0c0.39-0.39,0.39-1.03,0-1.41L18.36,16.95z M19.42,5.99c0.39-0.39,0.39-1.03,0-1.41 c-0.39-0.39-1.03-0.39-1.41,0l-1.06,1.06c-0.39,0.39-0.39,1.03,0,1.41s1.03,0.39,1.41,0L19.42,5.99z M7.05,18.36 c0.39-0.39,0.39-1.03,0-1.41c-0.39-0.39-1.03-0.39-1.41,0l-1.06,1.06c-0.39,0.39-0.39,1.03,0,1.41s1.03,0.39,1.41,0L7.05,18.36z"/></svg>
                    Tema
                </button>

                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="profile-logout-btn">
                        <!-- Ícone de Sair -->
                        <svg class="profile-icon" viewBox="0 0 24 24"><path d="M17,7l-1.41,1.41L18.17,11H8v2h10.17l-2.58,2.58L17,17l5-5L17,7z M4,5h8V3H4C2.9,3,2,3.9,2,5v14c0,1.1,0.9,2,2,2h8v-2H4V5z"/></svg>
                        Sair
                    </button>
                </form>
            </div>
        </div>

    </div>
    @endauth
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
    .modal-content { background: var(--bg-secondary); color: var(--text-primary); border-radius: 12px; margin: 10% auto; padding: 24px; width: 90%; max-width: 500px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
    .modal-title { font-size: 1.5rem; margin-bottom: 16px; color: var(--accent); }
    .close-btn { background: var(--accent); color: #fff; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; width: 100%; margin-top: 16px; }
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
    setTimeout(() => { document.getElementById('badgeAlert').style.display = 'none'; }, 5000);
</script>
@endif

@if(session('welcome'))
<style>
    .alert-welcome {
        position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
        background: var(--dropdown-bg); color: var(--text-primary);
        padding: 40px; border-radius: 12px; box-shadow: 0 20px 60px rgba(229, 0, 0, 0.5);
        z-index: 10000; width: 90%; max-width: 500px; text-align: center; animation: slideIn 0.5s ease;
    }
    @keyframes slideIn { from { transform: translate(-50%, -60%); opacity: 0; } to { transform: translate(-50%, -50%); opacity: 1; } }
    .alert-title { font-size: 2rem; color: var(--accent); margin-bottom: 15px; }
    .alert-text { font-size: 1.1rem; color: var(--text-secondary); margin-bottom: 20px; }
    .alert-button { background: var(--accent); color: #fff; border: none; padding: 12px 30px; border-radius: 6px; font-size: 1rem; cursor: pointer; transition: background 0.3s; }
    .alert-button:hover { background: var(--accent-hover); }
    .alert-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); z-index: 9999; }
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
setTimeout(() => { closeAlert(); }, 8000);
</script>
@endif

@if($shouldShowPasswordPrompt)
    <div id="password-change-modal-overlay" style="position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 99999; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div style="width: 100%; max-width: 460px; background: var(--dropdown-bg); border: 1px solid var(--border); border-left: 4px solid var(--accent); border-radius: 16px; padding: 24px; box-shadow: 0 20px 50px rgba(0,0,0,0.45); color: var(--text-primary); font-family: Arial, sans-serif;">
            <div style="font-size: 1.2rem; font-weight: 800; color: var(--accent); margin-bottom: 10px;">Atualização de segurança</div>
            <div style="font-size: 0.95rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 22px;">Deseja trocar sua senha agora para reforçar a segurança da sua conta?</div>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" id="password-change-no" style="padding: 10px 18px; border: 1px solid var(--border); background: transparent; color: var(--text-primary); border-radius: 10px; cursor: pointer; font-weight: 700;">Agora não</button>
                <button type="button" id="password-change-yes" style="padding: 10px 18px; border: none; background: linear-gradient(135deg, #e50000 0%, #cc0000 100%); color: #fff; border-radius: 10px; cursor: pointer; font-weight: 800;">Sim, trocar senha</button>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('password-change-modal-overlay');
        const btnYes = document.getElementById('password-change-yes');
        const btnNo = document.getElementById('password-change-no');

        if (!modal || !btnYes || !btnNo) return;

        function markPromptAsSeen() {
            return fetch('{{ route("password.prompt.seen") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            });
        }

        btnYes.addEventListener('click', function () {
            markPromptAsSeen().finally(() => { window.location.href = '{{ route("profile.password.edit") }}'; });
        });

        btnNo.addEventListener('click', function () {
            markPromptAsSeen().finally(() => { modal.remove(); });
        });
    });
    </script>
@endif

@auth
<!-- SCRIPT UNIFICADO: NOTIFICAÇÕES + TEMA INTELIGENTE + STATUS DE CONEXÃO + DROPDOWN PERFIL -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    
    // ==========================================
    // 0. LÓGICA DO DROPDOWN DE PERFIL (NOVO)
    // ==========================================
    const profileTrigger = document.getElementById('profileTrigger');
    const profileDropdown = document.getElementById('profileDropdown');

    if (profileTrigger && profileDropdown) {
        profileTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        // Fecha ao clicar fora
        document.addEventListener('click', function(e) {
            if (!profileDropdown.contains(e.target) && !profileTrigger.contains(e.target)) {
                profileDropdown.classList.remove('show');
            }
        });
    }

    // ==========================================
    // 1. MOTOR DE TEMA (CLARO/ESCURO)
    // ==========================================
    const toggleBtn = document.getElementById('theme-toggle');
    const html = document.documentElement;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)');

    function applyTheme(theme, isManualOverride = false) {
        html.setAttribute('data-theme', theme);
        if (isManualOverride) {
            localStorage.setItem('user_theme_override', theme);
            saveThemeToDatabase(theme);
        }
    }

    function initializeTheme() {
        const userOverride = localStorage.getItem('user_theme_override');
        if (userOverride) {
            applyTheme(userOverride, false);
        } else {
            applyTheme(systemPrefersDark.matches ? 'dark' : 'light', false);
        }
    }

    systemPrefersDark.addEventListener('change', (e) => {
        if (!localStorage.getItem('user_theme_override')) {
            applyTheme(e.matches ? 'dark' : 'light', false);
        }
    });

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            applyTheme(newTheme, true);
        });
    }

    async function saveThemeToDatabase(theme) {
        try {
            await fetch('{{ route("theme.toggle") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ theme: theme })
            });
        } catch (error) { console.error('Erro ao salvar tema no banco:', error); }
    }

    initializeTheme();

    // ==========================================
    // 2. CONTROLE DE STATUS DE CONEXÃO
    // ==========================================
    const statusWrapper = document.getElementById('connectionStatus');
    const statusText = document.getElementById('connectionText');
    let connectionFails = 0;

    function setConnectionStatus(isOnline) {
        if (!statusWrapper) return;
        
        if (isOnline) {
            connectionFails = 0;
            statusWrapper.className = 'connection-status-wrapper status-online';
            statusText.textContent = 'Online';
        } else {
            connectionFails++;
            if (connectionFails >= 2) {
                statusWrapper.className = 'connection-status-wrapper status-offline';
                statusText.textContent = 'Offline';
            }
        }
    }

    // ==========================================
    // 3. MOTOR DE NOTIFICAÇÕES (DROPDOWN + PUSH)
    // ==========================================
    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    const badge = document.getElementById('notificationBadge');
    const list = document.getElementById('notificationList');
    const markAllBtn = document.getElementById('markAllNotificationsRead');

    function escapeHtml(text) { return String(text || '').replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[m]); }
    function formatDate(dateString) { const d = new Date(dateString); return isNaN(d) ? '' : d.toLocaleString('pt-BR'); }
    function updateBadge(count) { badge.textContent = count || 0; badge.style.display = count > 0 ? 'flex' : 'none'; }
    function renderEmpty(msg = 'Nenhuma notificação.') { list.innerHTML = `<div class="notification-empty">${escapeHtml(msg)}</div>`; }

    function renderNotifications(notifications) {
        if (!Array.isArray(notifications) || notifications.length === 0) return renderEmpty();
        list.innerHTML = notifications.map(n => `
            <a href="${n.link || '#'}" class="notification-item ${!n.is_read ? 'unread' : ''}" data-id="${n.id}">
                <div class="notification-item-title">${escapeHtml(n.title || 'Notificação')}</div>
                <div class="notification-item-time">${formatDate(n.created_at)}</div>
            </a>
        `).join('');
        
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function() { if(this.dataset.id) markAsRead(this.dataset.id); });
        });
    }

    async function fetchDropdownNotifications() {
        try {
            const res = await fetch(`{{ route('notifications.fetch') }}`, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            if(res.ok) {
                const data = await res.json();
                updateBadge(data.unread_count || 0);
                renderNotifications(data.notifications || []);
                setConnectionStatus(true);
            } else {
                setConnectionStatus(false);
            }
        } catch (e) { 
            console.error(e); 
            renderEmpty('Erro ao carregar.'); 
            setConnectionStatus(false);
        }
    }

    async function markAsRead(id) {
        try {
            await fetch(`/notifications/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' }, body: '{}' });
            fetchDropdownNotifications();
        } catch (e) { console.error(e); }
    }

    async function markAllAsRead() {
        try {
            await fetch(`{{ route('notifications.readAll') }}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' }, body: '{}' });
            fetchDropdownNotifications();
        } catch (e) { console.error(e); }
    }

    if(bell) bell.addEventListener('click', e => { e.stopPropagation(); dropdown.classList.toggle('show'); });
    if(markAllBtn) markAllBtn.addEventListener('click', e => { e.preventDefault(); markAllAsRead(); });
    document.addEventListener('click', e => { if (dropdown && !dropdown.contains(e.target) && !bell.contains(e.target)) dropdown.classList.remove('show'); });

    // ==========================================
    // 4. WEB PUSH NOTIFICATIONS (SISTEMA OPERACIONAL)
    // ==========================================
    function requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
    }

    function registerServiceWorker() {
        if ('serviceWorker' in navigator) navigator.serviceWorker.register('/sw.js').catch(e => console.error(e));
    }

    function playNotificationSound() {
        try {
            const audio = new Audio('/audio/notification.mp3'); 
            audio.volume = 0.5; 
            audio.play().catch(e => {}); 
        } catch (e) {}
    }

    async function checkPushNotifications() {
        if (Notification.permission !== 'granted') return;
        try {
            const res = await fetch('{{ route("notifications.check") }}', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            if(res.ok) {
                const data = await res.json();
                if (data.notifications && data.notifications.length > 0) {
                    playNotificationSound();
                    navigator.serviceWorker.ready.then(reg => {
                        data.notifications.forEach(n => {
                            reg.showNotification(n.title, {
                                body: n.body, icon: '/favicon.ico', badge: '/favicon.ico',
                                vibrate: [200, 100, 200], data: { url: n.url }, requireInteraction: false
                            });
                        });
                    });
                    fetchDropdownNotifications(); 
                }
                setConnectionStatus(true);
            } else {
                setConnectionStatus(false);
            }
        } catch (e) { 
            console.error(e);
            setConnectionStatus(false);
        }
    }

    fetchDropdownNotifications();
    requestNotificationPermission();
    registerServiceWorker();

    setInterval(() => {
        fetchDropdownNotifications();
        checkPushNotifications();
    }, 15000);
});
</script>
@endauth

</body>
</html>
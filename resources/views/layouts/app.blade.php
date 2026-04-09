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
        }

        /* === CONTROLE DINÂMICO DA LOGO === */
/* No tema escuro (padrão), a logo fica normal (branca/clara) */
        nav .logo img {
            transition: filter 0.3s ease;
        }

/* No tema claro, transformamos a logo em PRETA */
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
        }

        nav .nav-links a:hover { color: var(--accent); }

        nav .nav-links span {
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-left: 20px;
        }

        nav .nav-links form { display: inline; }

        nav .nav-links button {
            background: none;
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 5px 14px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            margin-left: 20px;
            transition: all 0.2s;
        }

        nav .nav-links button:hover {
            background: var(--accent);
            color: #fff; /* Botão preenchido sempre tem texto branco */
        }

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

        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}">⚙️ Admin</a>
        @endif
        
        <span>{{ auth()->user()->name }}</span>
        <span class="badge badge-{{ auth()->user()->role }}">{{ auth()->user()->role }}</span>
        
        <!-- Botão de Tema -->
        <button id="theme-toggle" title="Alternar tema" style="margin-left: 15px; border: none; background: transparent; font-size: 1.2rem; cursor: pointer;">
            🌓
        </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Sair</button>
        </form>
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
<!-- SCRIPT UNIFICADO: NOTIFICAÇÕES + TEMA INTELIGENTE -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    
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

    initializeTheme(); // Inicia o tema

    // ==========================================
    // 2. MOTOR DE NOTIFICAÇÕES (DROPDOWN + PUSH)
    // ==========================================
    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    const badge = document.getElementById('notificationBadge');
    const list = document.getElementById('notificationList');
    const markAllBtn = document.getElementById('markAllNotificationsRead');

    // Funções de UI do Dropdown
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

    // Funções de API do Dropdown
    async function fetchDropdownNotifications() {
        try {
            const res = await fetch(`{{ route('notifications.fetch') }}`, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            if(res.ok) {
                const data = await res.json();
                updateBadge(data.unread_count || 0);
                renderNotifications(data.notifications || []);
            }
        } catch (e) { console.error(e); renderEmpty('Erro ao carregar.'); }
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

    // Eventos do Dropdown
    if(bell) bell.addEventListener('click', e => { e.stopPropagation(); dropdown.classList.toggle('show'); });
    if(markAllBtn) markAllBtn.addEventListener('click', e => { e.preventDefault(); markAllAsRead(); });
    document.addEventListener('click', e => { if (dropdown && !dropdown.contains(e.target) && !bell.contains(e.target)) dropdown.classList.remove('show'); });

    // ==========================================
    // 3. WEB PUSH NOTIFICATIONS (SISTEMA OPERACIONAL)
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
                    // Atualiza o dropdown junto com o push!
                    fetchDropdownNotifications(); 
                }
            }
        } catch (e) { console.error(e); }
    }

    // Inicializa tudo
    fetchDropdownNotifications();
    requestNotificationPermission();
    registerServiceWorker();

    // UM ÚNICO INTERVALO PARA TUDO (Economiza CPU e Servidor)
    setInterval(() => {
        fetchDropdownNotifications();
        checkPushNotifications();
    }, 15000);
});
</script>
@endauth

</body>
</html>
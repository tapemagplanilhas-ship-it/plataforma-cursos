
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
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

        .notification-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
    margin-left: 18px;
}

.notification-bell {
    position: relative;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1px solid #333;
    background: #111;
    color: #fff;
    cursor: pointer;
    font-size: 1.1rem;
    transition: all 0.2s ease;
}

.notification-bell:hover {
    border-color: #e50000;
    background: #1a1a1a;
}

.notification-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    min-width: 20px;
    height: 20px;
    padding: 0 6px;
    border-radius: 999px;
    background: #e50000;
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
    background: linear-gradient(135deg, #151515 0%, #1f1f1f 100%);
    border: 1px solid rgba(229, 0, 0, 0.15);
    border-radius: 12px;
    box-shadow: 0 18px 40px rgba(0,0,0,0.45);
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
    border-bottom: 1px solid #2a2a2a;
    color: #fff;
    font-weight: 700;
}

.notification-read-all {
    background: none;
    border: none;
    color: #e50000;
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
    color: #fff;
    border-bottom: 1px solid #242424;
    transition: background 0.2s ease;
}

.notification-item:hover {
    background: rgba(229, 0, 0, 0.06);
}

.notification-item.unread {
    background: rgba(229, 0, 0, 0.08);
    border-left: 3px solid #e50000;
}

.notification-item-title {
    font-size: 0.92rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
}

.notification-item-time {
    font-size: 0.76rem;
    color: #888;
}

.notification-empty {
    padding: 18px;
    text-align: center;
    color: #888;
}
nav .nav-links {
    display: flex;
    align-items: center;
}

.notification-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
    margin-left: 10px;
    margin-right: 0;
}

.notification-bell {
    position: relative;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1px solid #333;
    background: #111;
    color: #fff;
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
    border-color: #e50000;
    background: #1a1a1a;
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
        @auth
            <a href="{{ route('courses.index') }}">Cursos</a>
            <a href="{{ route('notices.index') }}">Avisos</a>
            <a href="{{ route('chat.index') }}">Chat</a>
            <!-- <div class="notification-wrapper">
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
@endauth -->

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

@if($shouldShowPasswordPrompt)
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
        markPromptAsSeen().then(() => {
            window.location.href = '{{ route("profile.password.edit") }}';
        }).catch(() => {
            window.location.href = '{{ route("profile.password.edit") }}';
        });
    });

    btnNo.addEventListener('click', function () {
        markPromptAsSeen().finally(() => {
            modal.remove();
        });
    });
});
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

@if($shouldShowPasswordPrompt)
    <div id="password-change-modal-overlay" style="
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.65);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    ">
        <div style="
            width: 100%;
            max-width: 460px;
            background: linear-gradient(135deg, #151515 0%, #222 100%);
            border: 1px solid rgba(229,0,0,0.25);
            border-left: 4px solid #e50000;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.45);
            color: #fff;
            font-family: Arial, sans-serif;
        ">
            <div style="
                font-size: 1.2rem;
                font-weight: 800;
                color: #e50000;
                margin-bottom: 10px;
            ">
                Atualização de segurança
            </div>

            <div style="
                font-size: 0.95rem;
                color: #d0d0d0;
                line-height: 1.6;
                margin-bottom: 22px;
            ">
                Deseja trocar sua senha agora para reforçar a segurança da sua conta?
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button
                    type="button"
                    id="password-change-no"
                    style="
                        padding: 10px 18px;
                        border: 1px solid rgba(255,255,255,0.12);
                        background: rgba(255,255,255,0.04);
                        color: #fff;
                        border-radius: 10px;
                        cursor: pointer;
                        font-weight: 700;
                    "
                >
                    Agora não
                </button>

                <button
                    type="button"
                    id="password-change-yes"
                    style="
                        padding: 10px 18px;
                        border: none;
                        background: linear-gradient(135deg, #e50000 0%, #cc0000 100%);
                        color: #fff;
                        border-radius: 10px;
                        cursor: pointer;
                        font-weight: 800;
                    "
                >
                    Sim, trocar senha
                </button>
            </div>
        </div>
    </div>
@endif
@auth
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    const badge = document.getElementById('notificationBadge');
    const list = document.getElementById('notificationList');
    const markAllBtn = document.getElementById('markAllNotificationsRead');
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

    if (!bell || !dropdown || !badge || !list || !markAllBtn || !csrfTokenMeta) {
        console.error('Elementos de notificação não encontrados no layout.');
        return;
    }

    const csrfToken = csrfTokenMeta.getAttribute('content');

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';

        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatDate(dateString) {
        if (!dateString) return '';

        const date = new Date(dateString);

        if (isNaN(date.getTime())) {
            return '';
        }

        return date.toLocaleString('pt-BR');
    }

    function updateBadge(count) {
        const safeCount = Number(count) || 0;

        if (safeCount > 0) {
            badge.textContent = safeCount;
            badge.style.display = 'flex';
        } else {
            badge.textContent = '0';
            badge.style.display = 'none';
        }
    }

    function renderEmpty(message = 'Nenhuma notificação.') {
        list.innerHTML = `<div class="notification-empty">${escapeHtml(message)}</div>`;
    }

    function renderNotifications(notifications) {
        if (!Array.isArray(notifications) || notifications.length === 0) {
            renderEmpty();
            return;
        }

        list.innerHTML = notifications.map(notification => {
            const link = notification.link ? notification.link : '#';
            const title = escapeHtml(notification.title || 'Notificação');
            const isUnread = !notification.is_read;

            return `
                <a href="${link}"
                   class="notification-item ${isUnread ? 'unread' : ''}"
                   data-id="${notification.id}">
                    <div class="notification-item-title">${title}</div>
                    <div class="notification-item-time">${formatDate(notification.created_at)}</div>
                </a>
            `;
        }).join('');

        bindNotificationClicks();
    }

    function bindNotificationClicks() {
        const items = document.querySelectorAll('.notification-item');

        items.forEach(item => {
            item.addEventListener('click', function () {
                const id = this.dataset.id;

                if (!id) return;

                markAsRead(id);
            });
        });
    }

    async function safeJsonResponse(response) {
        const rawText = await response.text();

        if (!response.ok) {
            console.error('Resposta do servidor:', rawText);
            throw new Error(`Erro HTTP ${response.status}`);
        }

        try {
            return JSON.parse(rawText);
        } catch (error) {
            console.error('Resposta recebida não é JSON:', rawText);
            throw new Error('Resposta inválida do servidor');
        }
    }

    async function fetchNotifications() {
        try {
            const response = await fetch(`{{ route('notifications.fetch') }}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await safeJsonResponse(response);

            updateBadge(data.unread_count || 0);
            renderNotifications(data.notifications || []);
        } catch (error) {
            console.error('Erro ao buscar notificações:', error);
            renderEmpty('Não foi possível carregar as notificações.');
        }
    }

    async function markAsRead(id) {
        try {
            const response = await fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            });

            await safeJsonResponse(response);
            fetchNotifications();
        } catch (error) {
            console.error('Erro ao marcar notificação como lida:', error);
        }
    }

    async function markAllAsRead() {
        try {
            const response = await fetch(`{{ route('notifications.readAll') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            });

            await safeJsonResponse(response);
            fetchNotifications();
        } catch (error) {
            console.error('Erro ao marcar todas como lidas:', error);
        }
    }

    bell.addEventListener('click', function (event) {
        event.stopPropagation();
        dropdown.classList.toggle('show');
    });

    markAllBtn.addEventListener('click', function (event) {
        event.preventDefault();
        markAllAsRead();
    });

    document.addEventListener('click', function (event) {
        if (!dropdown.contains(event.target) && !bell.contains(event.target)) {
            dropdown.classList.remove('show');
        }
    });

    fetchNotifications();
    setInterval(fetchNotifications, 15000);
});
</script>
@endauth
</body>
</html>
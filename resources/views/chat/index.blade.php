@extends('layouts.chat')

@section('content')

<style>
/*
| ================================================================
| CHAT INTERFACE - CSS COMPLETO OTIMIZADO
| ================================================================
| Reescrito com variáveis CSS, responsividade mobile-first,
| acessibilidade e performance maximizada.
| ================================================================
*/

/* =====================================================
   1. RESET E VARIÁVEIS CSS
   ===================================================== */

*, *::before, *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    /* CORES */
    --color-bg-dark: #0a0a0a;
    --color-bg-medium: #121212;
    --color-bg-light: #1a1a1a;
    --color-bg-input: #161616;
    
    --color-primary: #e50000;
    --color-primary-dark: #cc0000;
    --color-primary-light: rgba(229, 0, 0, 0.15);
    --color-primary-hover: linear-gradient(135deg, #cc0000 0%, #990000 100%);
    --color-primary-gradient: linear-gradient(135deg, #e50000 0%, #cc0000 100%);
    
    --color-secondary: #00cc66;
    
    --color-text-light: #fff;
    --color-text-medium: #e8e8e8;
    --color-text-dark: #888;
    --color-text-placeholder: #555;
    --color-text-muted: #666;
    
    /* BORDAS */
    --border-default: rgba(229, 0, 0, 0.1);
    --border-active: rgba(229, 0, 0, 0.4);
    --border-sidebar: rgba(229, 0, 0, 0.15);
    
    /* SOMBRAS */
    --shadow-avatar: 0 4px 12px rgba(229, 0, 0, 0.25);
    --shadow-sidebar: inset -8px 0 24px rgba(0, 0, 0, 0.4);
    --shadow-hover: 0 4px 8px rgba(0, 0, 0, 0.2);
    
    /* TIPOGRAFIA */
    --font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    --font-sm: 0.75rem;
    --font-md: 0.9rem;
    --font-base: 1rem;
    --font-lg: 1.1rem;
    --font-xl: 1.3rem;
    --font-xxl: 1.6rem;
    
    /* ESPAÇAMENTO */
    --sp-xs: 4px;
    --sp-sm: 8px;
    --sp-md: 12px;
    --sp-lg: 16px;
    --sp-xl: 20px;
    --sp-xxl: 24px;
    --sp-xxxl: 28px;
    --sp-xxxxl: 32px;
    
    /* BORDER RADIUS */
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-full: 50%;
    
    /* TRANSIÇÕES */
    --trans-fast: 0.2s ease;
    --trans-normal: 0.25s ease;
    --trans-slow: 0.3s ease;
}

/* =====================================================
   2. BASE HTML/BODY
   ===================================================== */

html, body {
    width: 100%;
    height: 100%;
    font-family: var(--font-family);
    font-size: var(--font-base);
    line-height: 1.5;
    color: var(--color-text-medium);
    background-color: var(--color-bg-dark);
    overflow: hidden !important;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

h1, h2, h3, h4, h5, h6 {
    color: var(--color-text-light);
    font-weight: 700;
}

a {
    color: var(--color-primary);
    text-decoration: none;
    transition: color var(--trans-fast);
}

a:hover {
    color: var(--color-primary-dark);
}

button {
    cursor: pointer;
    border: none;
    background: none;
    font-family: inherit;
    font-size: inherit;
}

/* =====================================================
   3. LAYOUT PRINCIPAL (GRID CONTAINER)
   ===================================================== */

.chat-container {
    display: grid;
    grid-template-columns: 1fr;
    width: 100vw;
    height: 100vh;
    background-color: var(--color-bg-dark);
    overflow: hidden;
}

/* =====================================================
   4. SIDEBAR COM USUÁRIOS
   ===================================================== */

.chat-sidebar {
    display: none;
    flex-direction: column;
    background: linear-gradient(180deg, var(--color-bg-medium) 0%, #0f0f0f 100%);
    border-right: 1px solid var(--border-sidebar);
    box-shadow: var(--shadow-sidebar);
    overflow: hidden;
}

.sidebar-header {
    padding: var(--sp-xxl) var(--sp-xl);
    border-bottom: 1px solid var(--border-default);
    background: linear-gradient(180deg, rgba(229, 0, 0, 0.05) 0%, transparent 100%);
    flex-shrink: 0;
}

.sidebar-title {
    font-size: var(--font-base);
    font-weight: 700;
    color: var(--color-primary);
    letter-spacing: 0.5px;
    margin-bottom: var(--sp-sm);
    text-transform: uppercase;
}

.online-count {
    font-size: var(--font-md);
    color: var(--color-text-dark);
}

.users-list {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: var(--sp-md) var(--sp-sm);
    display: flex;
    flex-direction: column;
    gap: var(--sp-xs);
}

.users-list::-webkit-scrollbar {
    width: 6px;
}

.users-list::-webkit-scrollbar-track {
    background: transparent;
}

.users-list::-webkit-scrollbar-thumb {
    background: rgba(229, 0, 0, 0.2);
    border-radius: var(--radius-sm);
}

.user-item {
    padding: var(--sp-md) var(--sp-md);
    background-color: rgba(26, 26, 26, 0.6);
    border-radius: var(--radius-md);
    border-left: 3px solid transparent;
    transition: all var(--trans-normal);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: var(--sp-md);
    min-height: 56px;
}

.user-item:hover {
    background-color: rgba(229, 0, 0, 0.08);
    border-left-color: var(--color-primary);
    transform: translateX(4px);
}

.user-item.active {
    background-color: var(--color-primary-light);
    border-left-color: var(--color-primary);
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-full);
    background: var(--color-primary-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-text-light);
    font-weight: 700;
    font-size: var(--font-md);
    flex-shrink: 0;
    box-shadow: var(--shadow-avatar);
}

.user-info {
    flex: 1;
    min-width: 0;
}

.user-name {
    font-size: var(--font-md);
    color: var(--color-text-light);
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin-bottom: var(--sp-xs);
}

.user-status {
    font-size: var(--font-sm);
    color: var(--color-text-muted);
    display: flex;
    align-items: center;
    gap: var(--sp-xs);
}

.status-dot {
    width: 6px;
    height: 6px;
    background-color: var(--color-secondary);
    border-radius: var(--radius-full);
}

/* =====================================================
   5. CHAT WRAPPER
   ===================================================== */

.chat-wrapper {
    display: grid;
    grid-template-rows: auto 1fr auto;
    min-height: 0;
    overflow: hidden;
}

/* =====================================================
   6. CHAT HEADER
   ===================================================== */

.chat-header {
    background: linear-gradient(90deg, var(--color-bg-light) 0%, #161616 100%);
    border-bottom: 1px solid var(--border-default);
    padding: var(--sp-xl) var(--sp-xxxl);
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70px;
    flex-shrink: 0;
}

.chat-header-left {
    display: flex;
    align-items: center;
    gap: var(--sp-lg);
}

.chat-header h1 {
    font-size: var(--font-xl);
    color: var(--color-text-light);
    margin: 0;
    font-weight: 700;
}

.online-indicator {
    width: 12px;
    height: 12px;
    background-color: var(--color-secondary);
    border-radius: var(--radius-full);
    animation: pulse 2s ease infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(0.95); }
}

/* =====================================================
   7. CHAT MESSAGES AREA
   ===================================================== */

/* =====================================================
   7. CHAT MESSAGES AREA (CORRIGIDO PARA SCROLL) ✅
   ===================================================== */

.chat-main {
    display: flex;
    flex-direction: column;
    min-height: 0;           /* ESSENCIAL para flexbox com scroll */
    overflow: hidden;        /* O overflow é controlado por #chat-box */
}

#chat-box {
    flex: 1;                 /* Ocupa espaço máximo disponível */
    min-height: 0;           /* ESSENCIAL para scroll funcionar */
    overflow-y: auto;        /* ✅ ATIVA O SCROLL VERTICAL */
    overflow-x: hidden;      /* Remove scroll horizontal */
    scroll-behavior: smooth; /* Scroll suave ao pular */
    padding: var(--sp-xxxl);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    gap: var(--sp-md);
}

/* Scrollbar customizada */
#chat-box::-webkit-scrollbar {
    width: 8px;
}

#chat-box::-webkit-scrollbar-track {
    background: transparent;
}

#chat-box::-webkit-scrollbar-thumb {
    background: rgba(229, 0, 0, 0.15);
    border-radius: var(--radius-sm);
    transition: background 0.2s ease;
}

#chat-box::-webkit-scrollbar-thumb:hover {
    background: rgba(229, 0, 0, 0.3);
}

.msg-bubble {
    display: flex;
    flex-direction: column;
    animation: slideIn 0.3s ease forwards;
    max-width: 70%;
    margin-bottom: var(--sp-md);
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.msg-bubble.mine {
    align-items: flex-end;
    align-self: flex-end;
}

.msg-bubble.other {
    align-items: flex-start;
    align-self: flex-start;
}

.msg-header {
    display: flex;
    gap: var(--sp-sm);
    margin-bottom: var(--sp-xs);
    font-size: var(--font-md);
}

.msg-bubble.mine .msg-header {
    flex-direction: row-reverse;
}

.msg-name {
    font-weight: 600;
    color: var(--color-text-dark);
}

/* =====================================================
   SEPARADOR DE DATA - WhatsApp Style
   ===================================================== */

.date-separator {
    text-align: center;
    margin: var(--sp-xxxl) 0 var(--sp-xl) 0;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none;
}

.date-separator span {
    background-color: var(--color-bg-light);
    color: var(--color-text-dark);
    font-size: var(--font-sm);
    padding: var(--sp-sm) var(--sp-md);
    border-radius: var(--radius-md);
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    white-space: nowrap;
}

.date-separator::before,
.date-separator::after {
    content: '';
    flex-grow: 1;
    height: 1px;
    background-color: var(--border-default);
    margin: 0 var(--sp-md);
}
.msg-bubble.mine .msg-name {
    color: var(--color-primary);
}

.msg-container {
    display: flex;
    gap: var(--sp-sm);
}

.msg-bubble.mine .msg-container {
    flex-direction: row-reverse;
}

.msg-content {
    display: flex;
    flex-direction: column;
    gap: var(--sp-xs);
}

.msg-text {
    padding: var(--sp-md) var(--sp-lg);
    border-radius: var(--radius-lg);
    font-size: var(--font-md);
    line-height: 1.5;
    word-break: break-word;
}

.msg-bubble.mine .msg-text {
    background: var(--color-primary-gradient);
    color: var(--color-text-light);
    border-bottom-right-radius: var(--radius-sm);
}

.msg-bubble.other .msg-text {
    background-color: var(--color-bg-light);
    color: var(--color-text-medium);
    border: 1px solid var(--border-default);
    border-bottom-left-radius: var(--radius-sm);
}

.msg-media {
    max-width: 320px;
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.msg-media img, .msg-media video {
    width: 100%;
    display: block;
    height: auto;
}

.msg-file {
    display: inline-flex;
    align-items: center;
    gap: var(--sp-xs);
    padding: var(--sp-md) var(--sp-lg);
    background-color: var(--color-bg-light);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    color: var(--color-primary);
    font-size: var(--font-md);
    font-weight: 600;
    transition: background-color var(--trans-fast);
}

.msg-file:hover {
    background-color: rgba(229, 0, 0, 0.05);
}

.msg-meta {
    display: flex;
    gap: var(--sp-sm);
    font-size: var(--font-sm);
    color: var(--color-text-muted);
    align-items: center;
}

.msg-actions {
    display: flex;
    gap: var(--sp-xs);
    opacity: 0;
    transition: opacity var(--trans-slow);
}

.msg-bubble:hover .msg-actions {
    opacity: 1;
}

.msg-action-btn {
    background-color: var(--color-primary-light);
    border: none;
    color: var(--color-primary);
    padding: var(--sp-xs) var(--sp-md);
    border-radius: var(--radius-md);
    cursor: pointer;
    font-size: var(--font-md);
    font-weight: 600;
    transition: all var(--trans-fast);
}

.msg-action-btn:hover {
    background-color: var(--color-primary);
    color: var(--color-text-light);
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: var(--sp-lg);
    text-align: center;
}

.empty-state h2 {
    color: var(--color-text-dark);
    font-size: var(--font-xxl);
    margin: 0;
}

.empty-state p {
    color: var(--color-text-muted);
    font-size: var(--font-base);
}

/* =====================================================
   8. INPUT AREA
   ===================================================== */

.chat-input-area {
    background: linear-gradient(180deg, #161616 0%, #0f0f0f 100%);
    border-top: 1px solid var(--border-default);
    padding: var(--sp-xl) var(--sp-xxxl);
    display: flex;
    flex-direction: column;
    gap: var(--sp-md);
    flex-shrink: 0;
}

.file-preview {
    background-color: rgba(229, 0, 0, 0.05);
    border: 1px solid rgba(229, 0, 0, 0.2);
    padding: var(--sp-md) var(--sp-lg);
    border-radius: var(--radius-md);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.file-preview-name {
    color: var(--color-primary);
    font-weight: 600;
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.file-preview-remove {
    background-color: var(--color-primary-light);
    border: none;
    color: var(--color-primary);
    padding: var(--sp-xs) var(--sp-md);
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: all var(--trans-fast);
}

.file-preview-remove:hover {
    background-color: var(--color-primary);
    color: var(--color-text-light);
}

.input-controls {
    display: flex;
    gap: var(--sp-md);
    align-items: flex-end;
}

.input-wrapper {
    flex: 1;
    display: flex;
    gap: var(--sp-sm);
    align-items: center;
    background-color: rgba(26, 26, 26, 0.6);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    padding: var(--sp-md) var(--sp-lg);
    transition: all var(--trans-slow);
}

.input-wrapper:focus-within {
    border-color: var(--border-active);
    background-color: rgba(26, 26, 26, 0.9);
    box-shadow: 0 0 0 2px var(--border-active);
}

.chat-input-area input[type="text"] {
    flex: 1;
    background: transparent;
    border: none;
    color: var(--color-text-light);
    font-size: var(--font-md);
    outline: none;
    padding: 0;
}

.chat-input-area input[type="text"]::placeholder {
    color: var(--color-text-placeholder);
}

.input-icon {
    color: var(--color-text-muted);
    cursor: pointer;
    font-size: var(--font-lg);
    transition: color var(--trans-fast);
    flex-shrink: 0;
}

.input-icon:hover {
    color: var(--color-primary);
}

.char-count {
    font-size: var(--font-sm);
    color: var(--color-text-muted);
    flex-shrink: 0;
}

.chat-input-area button[type="submit"] {
    padding: var(--sp-md) var(--sp-xxl);
    background: var(--color-primary-gradient);
    color: var(--color-text-light);
    border-radius: var(--radius-md);
    font-weight: 700;
    transition: all var(--trans-fast);
    min-height: 44px;
    flex-shrink: 0;
}

.chat-input-area button[type="submit"]:hover {
    background: var(--color-primary-hover);
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.chat-input-area button[type="submit"]:active {
    transform: translateY(0);
    box-shadow: none;
}

/* =====================================================
   9. MODAL DE EDIÇÃO
   ===================================================== */

.edit-modal {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity var(--trans-slow);
}

.edit-modal.show {
    display: flex;
    opacity: 1;
}

.edit-modal-content {
    background: linear-gradient(135deg, var(--color-bg-light) 0%, #0f0f0f 100%);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-lg);
    padding: var(--sp-xxxxl);
    width: 90%;
    max-width: 500px;
    color: var(--color-text-light);
    transform: translateY(-20px);
    opacity: 0;
    transition: transform var(--trans-slow), opacity var(--trans-slow);
}

.edit-modal.show .edit-modal-content {
    transform: translateY(0);
    opacity: 1;
}

.edit-modal-title {
    font-size: var(--font-xl);
    color: var(--color-primary);
    margin-bottom: var(--sp-xl);
    font-weight: 700;
}

.edit-modal-input {
    width: 100%;
    padding: var(--sp-lg) var(--sp-md);
    background-color: rgba(26, 26, 26, 0.6);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    color: var(--color-text-light);
    font-size: var(--font-md);
    margin-bottom: var(--sp-lg);
    transition: all var(--trans-slow);
}

.edit-modal-input:focus {
    outline: none;
    border-color: var(--border-active);
    box-shadow: 0 0 0 2px var(--border-active);
}

.char-edit-count {
    font-size: var(--font-sm);
    color: var(--color-text-muted);
    margin-bottom: var(--sp-lg);
}

.edit-modal-buttons {
    display: flex;
    gap: var(--sp-md);
}

.edit-modal-btn {
    flex: 1;
    padding: var(--sp-lg);
    border-radius: var(--radius-md);
    cursor: pointer;
    font-weight: 700;
    min-height: 44px;
    transition: all var(--trans-fast);
}

.user-badge {
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 999px;
    background: #e50000;
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 0 2px rgba(229, 0, 0, 0.15);
    flex-shrink: 0;
}

.edit-modal-btn-save {
    background: var(--color-primary-gradient);
    color: var(--color-text-light);
}

.edit-modal-btn-save:hover {
    background: var(--color-primary-hover);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

.edit-modal-btn-cancel {
    background-color: var(--color-primary-light);
    color: var(--color-primary);
    border: 1px solid rgba(229, 0, 0, 0.2);
}

.edit-modal-btn-cancel:hover {
    background-color: rgba(229, 0, 0, 0.2);
}

/* =====================================================
   10. RESPONSIVIDADE
   ===================================================== */

/* Tablets (768px+) */
@media (min-width: 768px) {
    .chat-container {
        grid-template-columns: 220px 1fr;
    }
    
    .chat-sidebar {
        display: flex;
    }
}

/* Desktops (1024px+) */
@media (min-width: 1024px) {
    .chat-container {
        grid-template-columns: 280px 1fr;
    }
    
    .msg-bubble {
        max-width: 70%;
    }
}

/* Mobile Vertical (9:16) */
@media (max-aspect-ratio: 9/16) and (max-width: 480px) {
    .chat-header h1 {
        font-size: var(--font-base);
    }
    
    .chat-header-left span {
        display: none;
    }
    
    #chat-box {
        padding: var(--sp-lg);
    }
    
    .msg-bubble {
        max-width: 95%;
    }
    
    .msg-text {
        font-size: var(--font-sm);
        padding: var(--sp-sm) var(--sp-md);
    }
    
    .msg-media {
        max-width: 250px;
    }
    
    .chat-input-area button[type="submit"] {
        padding: var(--sp-md) var(--sp-lg);
        min-height: 40px;
    }
}

/* Focus Visível (Acessibilidade) */
:focus-visible {
    outline: 2px solid var(--color-primary);
    outline-offset: 2px;
}

/* Screen Reader Only */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
}

</style>

<div class="chat-container">
    <!-- SIDEBAR com usuários -->
    <div class="chat-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">👥 Usuários Online</div>
            <div class="online-count"><span id="online-count">{{ count($users) }}</span> online</div>
        </div>

        <div class="users-list" id="users-list">
    @foreach($users as $user)
        <div class="user-item" onclick='selectUser({{ $user["id"] }}, @json($user["name"]), this)'>
            <div class="user-avatar">{{ strtoupper(substr($user['name'], 0, 1)) }}</div>

            <div class="user-info">
                <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
                    <div class="user-name">{{ $user['name'] }}</div>

                    @if($user['unread_count'] > 0)
                        <div class="user-badge">{{ $user['unread_count'] }}</div>
                    @endif
                </div>

                <div class="user-status" style="justify-content:space-between;">
                    <span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:140px;">
                        {{ $user['last_message_body'] ?: 'Sem mensagens' }}
                    </span>

                    @if($user['last_message_time'])
                        <span>{{ $user['last_message_time'] }}</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
    </div>

    <!-- CHAT MAIN -->
    <div class="chat-wrapper">
        <!-- Header -->
        <div class="chat-header">
    <div class="chat-header-left">
        <div class="online-indicator"></div>
        <h1>💬 Chat da Equipe</h1>
        <span style="color: var(--color-text-dark); font-size: var(--font-md); margin-left: var(--sp-sm);">
            Conversando com: <strong id="selected-user" style="color: var(--color-primary);">Todos</strong>
        </span>
        <div class="chat-header-right">
    <button class="reset-filter-btn" onclick="resetUserFilter()" title="Voltar para conversa com todos" style="padding: 8px 16px; background: rgba(229, 0, 0, 0.15); color: #ffffff; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s;">
        Ver Todos
    </button>
</div>
    </div>
    <div class="chat-header-right">
        <a href="{{ route('courses.index') }}" class="chat-exit-btn">← Voltar</a>
    </div>
</div>

        <!-- Chat Box -->
        <div class="chat-main">
            <div id="chat-box">
                @if(count($messages) === 0)
                    <div class="empty-state">
                        <h2>🚀 Seja o primeiro a conversar!</h2>
                        <p>Envie uma mensagem para iniciar a conversa com sua equipe.</p>
                    </div>
                @else
                    @foreach($messages as $msg)
                        <div class="msg-bubble {{ $msg->user_id === auth()->id() ? 'mine' : 'other' }}" data-msg-id="{{ $msg->id }}">
                            <div class="msg-header">
                                <span class="msg-name">{{ $msg->user->name }}</span>
                            </div>
                            <div class="msg-container">
                                <div class="msg-content">
                                    @if($msg->body)
                                        <div class="msg-text">{{ $msg->body }}</div>
                                    @endif
                                    @if($msg->media_path)
                                        @if(str_contains($msg->media_type, 'image'))
                                            <div class="msg-media">
                                                <img src="{{ asset('storage/' . $msg->media_path) }}" alt="Imagem">
                                            </div>
                                        @elseif(str_contains($msg->media_type, 'video'))
                                            <div class="msg-media">
                                                <video controls>
                                                    <source src="{{ asset('storage/' . $msg->media_path) }}" type="{{ $msg->media_type }}">
                                                </video>
                                            </div>
                                        @else
                                            <a href="{{ asset('storage/' . $msg->media_path) }}" download class="msg-file">
                                                📄 {{ basename($msg->media_path) }}
                                            </a>
                                        @endif
                                    @endif
                                    <div class="msg-meta">
                                        <span id="time-{{ $msg->id }}">{{ $msg->created_at->format('H:i') }}</span>
                                        @if($msg->user_id === auth()->id() || auth()->user()->role === 'admin')
                                            <div class="msg-actions">
                                                @if($msg->body && $msg->user_id === auth()->id())
                                                    <button class="msg-action-btn" onclick="openEditModal({{ $msg->id }}, '{{ addslashes($msg->body) }}')">✏️</button>
                                                @endif
                                                <button class="msg-action-btn" onclick="deleteMessage({{ $msg->id }})">🗑️</button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
        <!-- Input Area -->
            <form class="chat-input-area" id="chat-form">
                @csrf
                <div id="file-preview"></div>
                <div class="input-controls">
                    <div class="input-wrapper">
                        <span class="input-icon" onclick="openEmojiPicker()" title="Emoji (Win+.)">😊</span>
                        <input 
                            type="text" 
                            name="body" 
                            id="chat-input" 
                            placeholder="Digite sua mensagem..." 
                            autocomplete="off" 
                            maxlength="500"
                        >
                        <span class="input-icon" onclick="document.getElementById('file-input').click()" title="Upload de arquivo">📎</span>
                        <input type="file" id="file-input" style="display: none;" accept="image/*,video/*,.pdf,.doc,.docx">
                        <span class="char-count" id="char-count">0/500</span>
                    </div>
                    <button type="submit">Enviar 📤</button>
                </div>
            </form>
    </div>
</div>

<!-- Modal de Edição -->
<div class="edit-modal" id="edit-modal">
    <div class="edit-modal-content">
        <div class="edit-modal-title">✏️ Editar Mensagem</div>
        <input 
            type="text" 
            id="edit-input" 
            class="edit-modal-input" 
            maxlength="500"
            placeholder="Edite sua mensagem..."
        >
        <div class="char-edit-count" style="font-size: 0.75rem; color: #666; margin-bottom: 16px;">0/500</div>
        <div class="edit-modal-buttons">
            <button class="edit-modal-btn edit-modal-btn-save" onclick="confirmEdit()">✅ Salvar</button>
            <button class="edit-modal-btn edit-modal-btn-cancel" onclick="closeEditModal()">❌ Cancelar</button>
        </div>
    </div>
</div>

<script>


    const chatBox = document.getElementById('chat-box');
    const chatInput = document.getElementById('chat-input');
    const charCount = document.getElementById('char-count');
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    const editInput = document.getElementById('edit-input');
    const editModal = document.getElementById('edit-modal');
    const usersList = document.getElementById('users-list');
    const selectedUserSpan = document.getElementById('selected-user');
    const currentId = {{ auth()->id() }};
    
    let selectedFile = null;
    let editingMessageId = null;
    let lastMessageCount = 0;
    let messageIds = [];
    let selectedUserId = null;

    // Scroll para o final
    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    scrollToBottom();

    // Contador de caracteres
    chatInput.addEventListener('input', () => {
        charCount.textContent = chatInput.value.length + '/500';
    });

function selectUser(userId, userName, element) {
    selectedUserId = userId;
    selectedUserSpan.textContent = userName || 'Usuário';
    chatInput.placeholder = `Mensagem privada para ${userName || 'Usuário'}...`;

    document.querySelectorAll('.user-item').forEach(item => {
        item.classList.remove('active');
    });

    if (element) {
        element.classList.add('active');
    }

    fetchMessages();
    reloadSidebar();
}

// 2. Resetar filtro para "Todos"
function resetUserFilter() {
    selectedUserId = null;
    selectedUserSpan.textContent = 'Todos';
    chatInput.placeholder = 'Digite sua mensagem para todos...';

    document.querySelectorAll('.user-item').forEach(item => {
        item.classList.remove('active');
    });

    fetchMessages();
    reloadSidebar();
}

// 3. Enviar mensagem (Blindado contra string "null")
document.getElementById('chat-form').addEventListener('submit', (e) => {
    e.preventDefault();

    const body = chatInput.value.trim();
    if (!body && !selectedFile) return;

    const formData = new FormData();
    formData.append('body', body);
    
    // 🛡️ CORREÇÃO CRÍTICA: Só faz o append se o ID existir. 
    // Evita enviar a string "null" que quebra a validação do Laravel.
    if (selectedUserId !== null) {
        formData.append('recipient_id', selectedUserId);
    }
    
    if (selectedFile) {
        formData.append('media', selectedFile);
    }
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch('{{ route("chat.store") }}', {
        method: 'POST',
        body: formData,
    }).then(response => {
    if (response.ok) {
        chatInput.value = '';
        charCount.textContent = '0/500';
        removeFile();
        fetchMessages();
        reloadSidebar();
    } else {
        console.error('Erro ao enviar mensagem');
    }
});
    });


    // Preview de arquivo
    fileInput.addEventListener('change', (e) => {
        selectedFile = e.target.files[0];
        if (selectedFile) {
            filePreview.innerHTML = `
                <div class="file-preview">
                    <span class="file-preview-name">📎 ${selectedFile.name}</span>
                    <button type="button" class="file-preview-remove" onclick="removeFile()">✕</button>
                </div>
            `;
        }
    });

    function removeFile() {
        selectedFile = null;
        fileInput.value = '';
        filePreview.innerHTML = '';
    }

function renderMessage(msg) {
    const isMine = Number(msg.user_id) === Number(currentId);
    const userName = escapeHtml(msg.user?.name || 'Usuário');
    const body = msg.body ?? '';
    const safeBody = escapeHtml(body);
    const mediaType = msg.media_type ?? '';
    const mediaPath = msg.media_path ?? '';

    const isImage = mediaType.includes('image');
    const isVideo = mediaType.includes('video');
    const isFile = mediaPath && !isImage && !isVideo;

    let mediaHtml = '';

    if (mediaPath) {
        if (isImage) {
            mediaHtml = `
                <div class="msg-media">
                    <img src="/storage/${mediaPath}" alt="Imagem">
                </div>
            `;
        } else if (isVideo) {
            mediaHtml = `
                <div class="msg-media">
                    <video controls>
                        <source src="/storage/${mediaPath}" type="${mediaType}">
                    </video>
                </div>
            `;
        } else if (isFile) {
            const filename = mediaPath.split('/').pop() || 'arquivo';
            mediaHtml = `
                <a href="/storage/${mediaPath}" download class="msg-file">
                    📄 ${escapeHtml(filename)}
                </a>
            `;
        }
    }

    const time = msg.created_at
        ? new Date(msg.created_at).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })
        : '--:--';

    const safeBodyForEdit = JSON.stringify(body);

    const actions = isMine ? `
        <div class="msg-actions">
            ${body ? `<button class="msg-action-btn" onclick='openEditModal(${msg.id}, ${safeBodyForEdit})'>✏️</button>` : ''}
            <button class="msg-action-btn" onclick="deleteMessage(${msg.id})">🗑️</button>
        </div>
    ` : '';

    return `
        <div class="msg-bubble ${isMine ? 'mine' : 'other'}" data-msg-id="${msg.id}">
            <div class="msg-header">
                <span class="msg-name">${userName}</span>
            </div>
            <div class="msg-container">
                <div class="msg-content">
                    ${body ? `<div class="msg-text">${safeBody}</div>` : ''}
                    ${mediaHtml}
                    <div class="msg-meta">
                        <span>${time}</span>
                        ${actions}
                    </div>
                </div>
            </div>
        </div>
    `;
}

   // Funções auxiliares de data
function isSameDay(d1, d2) {
    return d1.getFullYear() === d2.getFullYear() &&
           d1.getMonth() === d2.getMonth() &&
           d1.getDate() === d2.getDate();
}

function isToday(date) {
    const today = new Date();
    return isSameDay(date, today);
}

function isYesterday(date) {
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    return isSameDay(date, yesterday);
}

function formatDateLabel(date) {
    if (isToday(date)) return "Hoje";
    if (isYesterday(date)) return "Ontem";
    return date.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });
}


// Fetch de mensagens com agrupamento por data E FILTRO CORRETO
function fetchMessages() {
    // 🔥 CORREÇÃO 1: Avisa o Laravel qual usuário está selecionado via URL
    const url = selectedUserId 
        ? `{{ route("chat.fetch") }}?selected_user_id=${selectedUserId}` 
        : '{{ route("chat.fetch") }}';

    fetch(url)
        .then(res => res.json())
        .then(msgs => {
            
            // 🔥 CORREÇÃO 2: Filtro inteligente no Frontend
            // Garante que mostra o que você enviou PARA ele e o que ele enviou PARA você
            const filteredMsgs = selectedUserId 
                ? msgs.filter(msg => 
                    (msg.user_id === selectedUserId && msg.recipient_id === currentId) || 
                    (msg.user_id === currentId && msg.recipient_id === selectedUserId)
                  )
                : msgs.filter(msg => msg.recipient_id === null); // Chat Geral
            
            const newIds = filteredMsgs.map(m => m.id);
            const shouldScroll = lastMessageCount < filteredMsgs.length || chatBox.scrollTop >= chatBox.scrollHeight - chatBox.clientHeight - 50;

            let htmlContent = [];
            let lastDate = null;

            // Se não há mensagens no chat atual
            if (filteredMsgs.length === 0) {
                const emptyTitle = selectedUserId ? '📭 Nenhuma mensagem' : '🚀 Seja o primeiro a conversar!';
                const emptyText = selectedUserId ? 'Envie um "Olá" para iniciar a conversa privada.' : 'Envie uma mensagem para iniciar a conversa com sua equipe no chat geral.';
                
                chatBox.innerHTML = `
                    <div class="empty-state">
                        <h2>${emptyTitle}</h2>
                        <p>${emptyText}</p>
                    </div>
                `;
                lastMessageCount = 0;
                messageIds = [];
                return;
            }

            filteredMsgs.forEach(msg => {
                const msgDate = new Date(msg.created_at);
                
                // Adiciona separador de data se mudou
                if (!lastDate || !isSameDay(msgDate, lastDate)) {
                    htmlContent.push(`
                        <div class="date-separator">
                            <span>${formatDateLabel(msgDate)}</span>
                        </div>
                    `);
                    lastDate = msgDate;
                }
                htmlContent.push(renderMessage(msg));
            });

            // Atualiza o chat apenas se houver mudanças
            if (newIds.length !== messageIds.length || JSON.stringify(newIds) !== JSON.stringify(messageIds)) {
                chatBox.innerHTML = htmlContent.join('');
                messageIds = newIds;
                if (shouldScroll || newIds.length > lastMessageCount) {
                    scrollToBottom();
                }
            }
            lastMessageCount = newIds.length;
        })
        .catch(error => console.error('Erro ao buscar mensagens:', error));
}

setInterval(fetchMessages, 2000);

    // Funções auxiliares
    function escapeHtml(text) {
    if (text === null || text === undefined) return '';

    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

    function openEmojiPicker() {
        if (navigator.userAgentData?.platform === 'Windows') {
            alert('💡 Pressione WIN + . para abrir o emoji picker do Windows!');
        } else if (navigator.userAgentData?.platform === 'macOS') {
            alert('💡 Pressione CMD + ; para abrir o emoji picker do Mac!');
        } else {
            alert('💡 Use o atalho do seu sistema operacional para inserir emojis.');
        }
        chatInput.focus();
    }

    function openEditModal(msgId, content) {
        editingMessageId = msgId;
        editInput.value = content;
        document.querySelector('.char-edit-count').textContent = content.length + '/500';
        editModal.classList.add('show');
        editInput.focus();
        editInput.select();
    }

    function closeEditModal() {
        editModal.classList.remove('show');
        editingMessageId = null;
    }

    function confirmEdit() {
        const newContent = editInput.value.trim();
        if (!newContent) {
            alert('Mensagem não pode estar vazia!');
            return;
        }

        fetch(`{{ url('/chat') }}/${editingMessageId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ body: newContent }),
        }).then(response => {
            if (response.ok) {
                closeEditModal();
                setTimeout(() => {
                    location.reload();
                }, 500);
            }
        });
    }

    function deleteMessage(msgId) {
        if (confirm('Remover mensagem? ⚠️')) {
            fetch(`{{ url('/chat') }}/${msgId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            }).then(() => fetchMessages());
        }
    }

    // Fechar modal com ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });

    // Salvar com CTRL+ENTER no modal de edição
    editInput.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'Enter') {
            confirmEdit();
        }
    });

    // Clicar fora do modal fecha
    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    function renderUsersList(users) {
    usersList.innerHTML = '';

    users.forEach(user => {
        const isActive = Number(selectedUserId) === Number(user.id);

        const item = document.createElement('div');
        item.className = `user-item ${isActive ? 'active' : ''}`;
        item.setAttribute('onclick', `selectUser(${user.id}, ${JSON.stringify(user.name)}, this)`);

        item.innerHTML = `
            <div class="user-avatar">${escapeHtml((user.name || 'U').charAt(0).toUpperCase())}</div>
            <div class="user-info">
                <div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">
                    <div class="user-name">${escapeHtml(user.name || 'Usuário')}</div>
                    ${user.unread_count > 0 ? `<div class="user-badge">${user.unread_count}</div>` : ''}
                </div>
                <div class="user-status" style="justify-content:space-between;">
                    <span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:140px;">
                        ${escapeHtml(user.last_message_body || 'Sem mensagens')}
                    </span>
                    ${user.last_message_time ? `<span>${escapeHtml(user.last_message_time)}</span>` : ''}
                </div>
            </div>
        `;

        usersList.appendChild(item);
    });
}

function reloadSidebar() {
    fetch(`{{ route("chat.sidebarUsers") }}`)
        .then(res => res.json())
        .then(users => {
            renderUsersList(users);
        })
        .catch(error => console.error('Erro ao recarregar sidebar:', error));
}
fetchMessages();
reloadSidebar();

setInterval(() => {
    fetchMessages();
    reloadSidebar();
}, 2000);
</script>
@endsection
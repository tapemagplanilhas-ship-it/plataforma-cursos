@extends('layouts.chat')

@section('content')

<!-- CDN do Emoji Mart -->
<script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>

<style>
/*
| 
| CHAT INTERFACE - CSS COMPLETO OTIMIZADO
| 
*/

*, *::before, *::after {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --color-bg-dark: var(--bg-primary);
    --color-bg-medium: var(--bg-secondary);
    --color-bg-light: var(--bg-tertiary);
    --color-bg-input: var(--bg-input);
    
    --color-primary: var(--accent);
    --color-primary-dark: var(--accent-hover);
    --color-primary-light: rgba(229, 0, 0, 0.15);
    --color-primary-hover: linear-gradient(135deg, var(--accent-hover) 0%, #990000 100%);
    --color-primary-gradient: linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%);
    
    --color-secondary: #00cc66;
    
    --color-text-light: var(--text-primary);
    --color-text-medium: var(--text-secondary);
    --color-text-dark: var(--text-tertiary);
    --color-text-placeholder: var(--text-placeholder);
    --color-text-muted: var(--text-tertiary);
    
    --border-default: var(--border);
    --border-active: var(--accent);
    --border-sidebar: var(--border-light);
    
    --shadow-avatar: 0 4px 12px rgba(229, 0, 0, 0.25);
    --shadow-sidebar: inset -8px 0 24px rgba(0, 0, 0, 0.1);
    --shadow-hover: 0 4px 8px rgba(0, 0, 0, 0.2);
    
    --font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    --font-sm: 0.75rem;
    --font-md: 0.9rem;
    --font-base: 1rem;
    --font-lg: 1.1rem;
    --font-xl: 1.3rem;
    --font-xxl: 1.6rem;
    
    --sp-xs: 4px;
    --sp-sm: 8px;
    --sp-md: 12px;
    --sp-lg: 16px;
    --sp-xl: 20px;
    --sp-xxl: 24px;
    --sp-xxxl: 28px;
    --sp-xxxxl: 32px;
    
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-full: 50%;
    
    --trans-fast: 0.2s ease;
    --trans-normal: 0.25s ease;
    --trans-slow: 0.3s ease;
}

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
    transition: background-color 0.3s ease, color 0.3s ease;
}

h1, h2, h3, h4, h5, h6 { color: var(--color-text-light); font-weight: 700; }
a { color: var(--color-primary); text-decoration: none; transition: color var(--trans-fast); }
a:hover { color: var(--color-primary-dark); }
button { cursor: pointer; border: none; background: none; font-family: inherit; font-size: inherit; }

.chat-container {
    display: grid;
    grid-template-columns: 1fr;
    width: 100vw;
    height: 100vh;
    background-color: var(--color-bg-dark);
    overflow: hidden;
}

.chat-sidebar {
    display: none;
    flex-direction: column;
    background: linear-gradient(180deg, var(--color-bg-medium) 0%, var(--color-bg-dark) 100%);
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

.online-count { font-size: var(--font-md); color: var(--color-text-dark); }

.users-list {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: var(--sp-md) var(--sp-sm);
    display: flex;
    flex-direction: column;
    gap: var(--sp-xs);
}

.users-list::-webkit-scrollbar { width: 6px; }
.users-list::-webkit-scrollbar-track { background: transparent; }
.users-list::-webkit-scrollbar-thumb { background: rgba(229, 0, 0, 0.2); border-radius: var(--radius-sm); }

.user-item {
    padding: var(--sp-md) var(--sp-md);
    background-color: var(--color-bg-light);
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
    background: red;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 700;
    font-size: var(--font-md);
    flex-shrink: 0;
    box-shadow: var(--shadow-avatar);
}

.user-info { flex: 1; min-width: 0; }

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

.chat-wrapper {
    display: grid;
    grid-template-rows: auto 1fr auto;
    min-height: 0;
    overflow: hidden;
}

.chat-header {
    background: linear-gradient(90deg, var(--color-bg-light) 0%, var(--color-bg-input) 100%);
    border-bottom: 1px solid var(--border-default);
    padding: var(--sp-xl) var(--sp-xxxl);
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70px;
    flex-shrink: 0;
}

.chat-header-left { display: flex; align-items: center; gap: var(--sp-lg); }
.chat-header h1 { font-size: var(--font-xl); color: var(--color-text-light); margin: 0; font-weight: 700; }

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

.chat-main {
    display: flex;
    flex-direction: column;
    min-height: 0;
    overflow: hidden;
    position: relative;
}

#chat-box {
    flex: 1;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden;
    scroll-behavior: smooth;
    padding: var(--sp-xxxl);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    gap: var(--sp-md);
}

#chat-box::-webkit-scrollbar { width: 8px; }
#chat-box::-webkit-scrollbar-track { background: transparent; }
#chat-box::-webkit-scrollbar-thumb { background: rgba(229, 0, 0, 0.15); border-radius: var(--radius-sm); transition: background 0.2s ease; }
#chat-box::-webkit-scrollbar-thumb:hover { background: rgba(229, 0, 0, 0.3); }

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

.msg-bubble.mine { align-items: flex-end; align-self: flex-end; }
.msg-bubble.other { align-items: flex-start; align-self: flex-start; }

.msg-header {
    display: flex;
    gap: var(--sp-sm);
    margin-bottom: var(--sp-xs);
    font-size: var(--font-md);
}

.msg-bubble.mine .msg-header { flex-direction: row-reverse; }
.msg-name { font-weight: 600; color: var(--color-text-dark); }
.msg-bubble.mine .msg-name { color: var(--color-primary); }

.msg-container { display: flex; gap: var(--sp-sm); }
.msg-bubble.mine .msg-container { flex-direction: row-reverse; }
.msg-content { display: flex; flex-direction: column; gap: var(--sp-xs); }

.msg-text {
    padding: var(--sp-md) var(--sp-lg);
    border-radius: var(--radius-lg);
    font-size: var(--font-md);
    line-height: 1.5;
    word-break: break-word;
}

.msg-bubble.mine .msg-text {
    background: #e50000; 
    background: linear-gradient(135deg, #e50000 0%, #cc0000 100%);
    color: #ffffff !important;
    border-bottom-right-radius: var(--radius-sm);
    box-shadow: 0 2px 5px rgba(229, 0, 0, 0.2);
}

.msg-bubble.other .msg-text {
    background-color: var(--color-bg-light);
    color: var(--color-text-medium);
    border: 1px solid var(--border-default);
    border-bottom-left-radius: var(--radius-sm);
}

.msg-media { max-width: 320px; border-radius: var(--radius-lg); overflow: hidden; }
.msg-media img, .msg-media video { width: 100%; display: block; height: auto; }

/* 🚨 AQUI ESTÁ A MÁGICA DO TAMANHO DA FIGURINHA (WPP STYLE) 🚨 */
.msg-media.sticker {
    background: transparent !important; /* Sem fundo */
    border: none !important; /* Sem borda */
    border-radius: 0 !important; /* Sem arredondamento do container */
    max-width: 120px !important; /* Tamanho ajustado igual WPP */
    overflow: visible !important; /* Permite a sombra vazar */
    margin: 4px 0;
}

.msg-media.sticker img { 
    background: transparent !important;
    width: 100%;
    height: auto;
    object-fit: contain;
    filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.2)); /* Sombra flutuante elegante */
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

.msg-file:hover { background-color: rgba(229, 0, 0, 0.05); }

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

.msg-bubble:hover .msg-actions { opacity: 1; }

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

.msg-action-btn:hover { background-color: var(--color-primary); color: #fff; }

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    gap: var(--sp-lg);
    text-align: center;
}

.empty-state h2 { color: var(--color-text-dark); font-size: var(--font-xxl); margin: 0; }
.empty-state p { color: var(--color-text-muted); font-size: var(--font-base); }

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
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

/* TYPING INDICATOR (WPP STYLE) */
.typing-indicator-container {
    display: none; 
    align-self: flex-start;
    margin-bottom: var(--sp-md);
    animation: slideIn 0.3s ease forwards;
}

.typing-bubble {
    background-color: var(--color-bg-light);
    border: 1px solid var(--border-default);
    border-radius: 18px;
    border-bottom-left-radius: 4px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 4px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.typing-dot {
    width: 6px;
    height: 6px;
    background-color: var(--color-text-muted);
    border-radius: 50%;
    animation: typingBounce 1.4s infinite ease-in-out both;
}

.typing-dot:nth-child(1) { animation-delay: -0.32s; }
.typing-dot:nth-child(2) { animation-delay: -0.16s; }

@keyframes typingBounce {
    0%, 80%, 100% { transform: translateY(0); opacity: 0.6; }
    40% { transform: translateY(-4px); opacity: 1; background-color: var(--color-primary); }
}

.typing-name {
    font-size: 0.75rem;
    color: var(--color-text-muted);
    margin-left: 8px;
    font-weight: 600;
}

.chat-input-area {
    background: linear-gradient(180deg, var(--color-bg-input) 0%, var(--color-bg-dark) 100%);
    border-top: 1px solid var(--border-default);
    padding: var(--sp-xl) var(--sp-xxxl);
    display: flex;
    flex-direction: column;
    gap: var(--sp-md);
    flex-shrink: 0;
    position: relative;
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

.file-preview-remove:hover { background-color: var(--color-primary); color: #fff; }

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
    background-color: var(--color-bg-light);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    padding: var(--sp-md) var(--sp-lg);
    transition: all var(--trans-slow);
}

.input-wrapper:focus-within {
    border-color: var(--border-active);
    box-shadow: 0 0 0 2px rgba(229, 0, 0, 0.1);
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

.chat-input-area input[type="text"]::placeholder { color: var(--color-text-placeholder); }

.input-icon {
    color: var(--color-text-muted);
    cursor: pointer;
    font-size: var(--font-lg);
    transition: color var(--trans-fast);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
}

.input-icon:hover { color: var(--color-primary); background: var(--color-bg-medium); }

.char-count {
    font-size: var(--font-sm);
    color: var(--color-text-muted);
    flex-shrink: 0;
}

.chat-input-area button[type="submit"] {
    padding: var(--sp-md) var(--sp-xxl);
    background: #e50000 !important; 
    background: linear-gradient(135deg, #e50000 0%, #cc0000 100%) !important;
    color: #ffffff !important;
    border-radius: var(--radius-md);
    font-weight: 700;
    transition: all var(--trans-fast);
    min-height: 44px;
    flex-shrink: 0;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 10px rgba(229, 0, 0, 0.3);
}

.chat-input-area button[type="submit"]:hover {
    background: #cc0000 !important;
    background: linear-gradient(135deg, #cc0000 0%, #990000 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(229, 0, 0, 0.4);
}

.chat-input-area button[type="submit"]:active {
    transform: translateY(0);
    box-shadow: 0 2px 5px rgba(229, 0, 0, 0.3);
}

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

.edit-modal.show { display: flex; opacity: 1; }

.edit-modal-content {
    background: linear-gradient(135deg, var(--color-bg-light) 0%, var(--color-bg-dark) 100%);
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

.edit-modal.show .edit-modal-content { transform: translateY(0); opacity: 1; }

.edit-modal-title {
    font-size: var(--font-xl);
    color: var(--color-primary);
    margin-bottom: var(--sp-xl);
    font-weight: 700;
}

.edit-modal-input {
    width: 100%;
    padding: var(--sp-lg) var(--sp-md);
    background-color: var(--color-bg-medium);
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
    box-shadow: 0 0 0 2px rgba(229, 0, 0, 0.1);
}

.char-edit-count { font-size: var(--font-sm); color: var(--color-text-muted); margin-bottom: var(--sp-lg); }

.edit-modal-buttons { display: flex; gap: var(--sp-md); }

.edit-modal-btn {
    flex: 1;
    padding: var(--sp-lg);
    border-radius: var(--radius-md);
    cursor: pointer;
    font-weight: 700;
    min-height: 44px;
    transition: all var(--trans-fast);
    border: none;
}

.user-badge {
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 999px;
    background: var(--color-primary);
    color: #fff;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 0 2px rgba(229, 0, 0, 0.15);
    flex-shrink: 0;
}

.edit-modal-btn-save { background: var(--color-primary-gradient); color: #fff; }
.edit-modal-btn-save:hover { background: var(--color-primary-hover); box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2); }

.edit-modal-btn-cancel { background-color: var(--color-primary-light); color: var(--color-primary); border: 1px solid rgba(229, 0, 0, 0.2); }
.edit-modal-btn-cancel:hover { background-color: rgba(229, 0, 0, 0.2); }

#emoji-picker-container {
    position: absolute;
    bottom: 80px; 
    left: 20px;
    z-index: 1000;
    display: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border-radius: 10px;
    overflow: hidden;
}

#sticker-picker-container {
    position: absolute;
    bottom: 80px; 
    left: 60px; 
    z-index: 1000;
    display: none;
    background: var(--color-bg-light);
    border: 1px solid var(--border-default);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border-radius: 12px;
    width: 300px;
    max-height: 350px;
    overflow-y: auto;
    padding: 12px;
}

.sticker-header {
    font-weight: 700;
    color: var(--color-text-light);
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border-default);
    font-size: 0.9rem;
}

.sticker-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}

.sticker-item {
    aspect-ratio: 1;
    cursor: pointer;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s ease, background 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-bg-medium);
}

.sticker-item:hover {
    transform: scale(1.1);
    background: var(--color-bg-dark);
}

.sticker-item img {
    width: 80%;
    height: 80%;
    object-fit: contain;
}

.sticker-upload-btn {
    background: rgba(229, 0, 0, 0.1);
    border: 2px dashed var(--color-primary);
    color: var(--color-primary);
    font-size: 1.5rem;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    aspect-ratio: 1;
}

.sticker-upload-btn:hover {
    background: var(--color-primary);
    color: #fff;
    transform: scale(1.05);
}

.sticker-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: var(--color-primary);
    font-weight: bold;
    display: none;
}

@media (min-width: 768px) {
    .chat-container { grid-template-columns: 220px 1fr; }
    .chat-sidebar { display: flex; }
}

@media (min-width: 1024px) {
    .chat-container { grid-template-columns: 280px 1fr; }
    .msg-bubble { max-width: 70%; }
}

@media (max-aspect-ratio: 9/16) and (max-width: 480px) {
    .chat-header h1 { font-size: var(--font-base); }
    .chat-header-left span { display: none; }
    #chat-box { padding: var(--sp-lg); }
    .msg-bubble { max-width: 95%; }
    .msg-text { font-size: var(--font-sm); padding: var(--sp-sm) var(--sp-md); }
    .msg-media { max-width: 250px; }
    .chat-input-area button[type="submit"] { padding: var(--sp-md) var(--sp-lg); min-height: 40px; }
    #emoji-picker-container, #sticker-picker-container { left: 10px; right: 10px; width: auto; } 
}

:focus-visible { outline: 2px solid var(--color-primary); outline-offset: 2px; }
.sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0; }
</style>

<div class="chat-container">
    <!-- SIDEBAR com usuários -->
    <div class="chat-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">👥 Usuários Online</div>
            <div class="online-count"><span id="online-count">{{ count($users) }}</span> Usuários</div>
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
                    <button class="reset-filter-btn" onclick="resetUserFilter()" title="Voltar para conversa com todos" style="padding: 8px 16px; background: rgba(229, 0, 0, 0.15); color: var(--color-primary); border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                        Ver Todos
                    </button>
                </div>
            </div>
            <div class="chat-header-right">
                <a href="{{ route('courses.index') }}" class="chat-exit-btn" style="color: var(--color-text-medium); text-decoration: none; font-weight: 600;">← Voltar</a>
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
                                            <div class="msg-media {{ str_contains($msg->media_path, 'sticker_') ? 'sticker' : '' }}">
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

                <!-- TYPING INDICATOR -->
                <div class="typing-indicator-container" id="typing-indicator">
                    <div class="typing-bubble">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <span class="typing-name" id="typing-user-name">Alguém está digitando...</span>
                    </div>
                </div>

            </div>
        </div>
        
        <!-- Input Area -->
        <form class="chat-input-area" id="chat-form">
            @csrf
            
            <!-- Container do Emoji Mart -->
            <div id="emoji-picker-container"></div>

            <!-- Container do Sticker Picker -->
            <div id="sticker-picker-container">
                <div class="sticker-header">🏷️ Figurinhas da Tapemag</div>
                <div class="sticker-grid" id="sticker-grid">
                    <div class="sticker-upload-btn" id="custom-sticker-btn" title="Enviar sua própria figurinha">+</div>
                    <input type="file" id="custom-sticker-input" style="display: none;" accept="image/*">
                </div>
                <div class="sticker-loading" id="sticker-loading">Enviando... 🚀</div>
            </div>

            <div id="file-preview"></div>
            <div class="input-controls">
                <div class="input-wrapper">
                    <!-- Botão de Emoji -->
                    <span class="input-icon" id="emoji-trigger" title="Emoji" style="cursor:pointer">
                        😀
                    </span>
                    
                    <!-- Botão de Figurinhas -->
                    <span class="input-icon" id="sticker-trigger" title="Figurinhas" style="cursor:pointer; font-size: 1.3rem;">
                        🏷️
                    </span>

                    <input 
                        type="text" 
                        name="body" 
                        id="chat-input" 
                        placeholder="Digite sua mensagem..." 
                        autocomplete="off" 
                        maxlength="500"
                    >
                    <span class="input-icon" onclick="document.getElementById('file-input').click()" title="Upload de arquivo">📎</span>
                    <input type="file" id="file-input" style="display: none;" accept="image/*,video/*,.pdf,.doc,.docx,.xlsx,.txt, application/*,.zip,.rar,.7z,.tar,.gz,.mp3,.wav,.ogg">
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
        <div class="char-edit-count" style="font-size: 0.75rem; color: var(--color-text-muted); margin-bottom: 16px;">0/500</div>
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
    const currentUserName = "{{ auth()->user()->name }}";
    
    let selectedFile = null;
    let editingMessageId = null;
    let lastMessageCount = 0;
    let messageIds = [];
    let selectedUserId = null;
    let sidebarPaused = false;
    let sidebarPauseTimer = null;
    let lastSidebarHash = '';

    // 
    // LÓGICA DO TYPING INDICATOR
    // 
    const typingIndicator = document.getElementById('typing-indicator');
    const typingUserName = document.getElementById('typing-user-name');
    let typingTimeout = null;
    let isTyping = false;

    chatInput.addEventListener('input', () => {
        charCount.textContent = chatInput.value.length + '/500';

        if (!isTyping) {
            isTyping = true;
            notifyTypingStatus(true);
        }

        clearTimeout(typingTimeout);
        
        typingTimeout = setTimeout(() => {
            isTyping = false;
            notifyTypingStatus(false);
        }, 2500);
    });

    function notifyTypingStatus(status) {
        const formData = new FormData();
        formData.append('is_typing', status);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        if (selectedUserId !== null) {
            formData.append('recipient_id', selectedUserId);
        }

        fetch('/chat/typing', {
            method: 'POST',
            body: formData
        }).catch(e => console.log('Typing route not ready yet'));
    }

    function showTypingIndicator(userName) {
        typingUserName.textContent = `${userName} está digitando...`;
        typingIndicator.style.display = 'flex';
        scrollToBottom();
    }

    function hideTypingIndicator() {
        typingIndicator.style.display = 'none';
    }


    // 
    // INTEGRAÇÃO EMOJI MART
    // 
    document.addEventListener('DOMContentLoaded', () => {
        const pickerOptions = {
            onEmojiSelect: (emoji) => {
                chatInput.value += emoji.native;
                chatInput.focus();
                charCount.textContent = chatInput.value.length + '/500';
            },
            theme: document.documentElement.getAttribute('data-theme') || 'dark',
            locale: 'pt',
            set: 'apple',
            navPosition: 'bottom',
            previewPosition: 'none',
            skinTonePosition: 'none'
        };

        const picker = new EmojiMart.Picker(pickerOptions);
        const pickerContainer = document.getElementById('emoji-picker-container');
        pickerContainer.appendChild(picker);

        const emojiTrigger = document.getElementById('emoji-trigger');
        const stickerTrigger = document.getElementById('sticker-trigger');
        const stickerContainer = document.getElementById('sticker-picker-container');
        
        emojiTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            stickerContainer.style.display = 'none'; 
            pickerContainer.style.display = pickerContainer.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (e) => {
            if (!pickerContainer.contains(e.target) && e.target !== emojiTrigger) {
                pickerContainer.style.display = 'none';
            }
        });

        const themeToggleBtn = document.getElementById('theme-toggle');
        if(themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                setTimeout(() => {
                    const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                    picker.update({ theme: currentTheme });
                }, 100);
            });
        }
    });

    // 
    // INTEGRAÇÃO STICKER PICKER (FIGURINHAS)
    // 
    document.addEventListener('DOMContentLoaded', () => {
        const stickerTrigger = document.getElementById('sticker-trigger');
        const stickerContainer = document.getElementById('sticker-picker-container');
        const emojiContainer = document.getElementById('emoji-picker-container');
        const stickerGrid = document.getElementById('sticker-grid');
        const loadingIndicator = document.getElementById('sticker-loading');
        
        const customStickerBtn = document.getElementById('custom-sticker-btn');
        const customStickerInput = document.getElementById('custom-sticker-input');

        customStickerBtn.addEventListener('click', () => {
            customStickerInput.click();
        });

        customStickerInput.addEventListener('change', async (e) => {
            const file = e.target.files[0];
            if (!file) return;

            stickerGrid.style.opacity = '0.3';
            loadingIndicator.style.display = 'block';

            try {
                const fileExtension = file.name.split('.').pop();
                const newFileName = 'sticker_custom_' + Date.now() + '.' + fileExtension;
                const renamedFile = new File([file], newFileName, { type: file.type });

                const formData = new FormData();
                formData.append('media', renamedFile);
                formData.append('body', ''); 
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                if (selectedUserId !== null) {
                    formData.append('recipient_id', selectedUserId);
                }

                const uploadResponse = await fetch('{{ route("chat.store") }}', {
                    method: 'POST',
                    body: formData
                });

                if (uploadResponse.ok) {
                    stickerContainer.style.display = 'none';
                    customStickerInput.value = ''; 
                    fetchMessages(); 
                } else {
                    alert('Erro ao enviar sua figurinha.');
                }
            } catch (error) {
                console.error('Erro:', error);
            } finally {
                stickerGrid.style.opacity = '1';
                loadingIndicator.style.display = 'none';
            }
        });

        const stickerUrls = [
            '/images/stickers/1.jpg',
        ];

        stickerUrls.forEach(url => {
            const div = document.createElement('div');
            div.className = 'sticker-item';
            
            const img = document.createElement('img');
            img.src = url;
            img.alt = 'Sticker';
            
            div.appendChild(img);

            div.addEventListener('click', async (e) => {
                e.stopPropagation();
                stickerGrid.style.opacity = '0.3';
                loadingIndicator.style.display = 'block';

                try {
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Imagem não encontrada');
                    
                    const blob = await response.blob();
                    const fileName = 'sticker_' + Date.now() + '.png';
                    const file = new File([blob], fileName, { type: 'image/png' });

                    const formData = new FormData();
                    formData.append('media', file);
                    formData.append('body', '');
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    
                    if (selectedUserId !== null) {
                        formData.append('recipient_id', selectedUserId);
                    }

                    const uploadResponse = await fetch('{{ route("chat.store") }}', {
                        method: 'POST',
                        body: formData
                    });

                    if (uploadResponse.ok) {
                        stickerContainer.style.display = 'none';
                        fetchMessages(); 
                    }
                } catch (error) {
                    console.error('Erro:', error);
                } finally {
                    stickerGrid.style.opacity = '1';
                    loadingIndicator.style.display = 'none';
                }
            });

            stickerGrid.appendChild(div);
        });

        stickerTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            emojiContainer.style.display = 'none'; 
            stickerContainer.style.display = stickerContainer.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (e) => {
            if (!stickerContainer.contains(e.target) && e.target !== stickerTrigger) {
                stickerContainer.style.display = 'none';
            }
        });
    });

    // 
    // LÓGICA DO CHAT 
    // 

    usersList.addEventListener('scroll', () => pauseSidebarRefresh(1800));
    usersList.addEventListener('mouseenter', () => pauseSidebarRefresh(1800));
    usersList.addEventListener('wheel', () => pauseSidebarRefresh(1800));
    usersList.addEventListener('touchstart', () => pauseSidebarRefresh(1800));
    usersList.addEventListener('touchmove', () => pauseSidebarRefresh(1800));

    function buildSidebarHash(users) {
        return JSON.stringify(
            users.map(user => ({
                id: user.id,
                unread_count: user.unread_count || 0,
                last_message_body: user.last_message_body || '',
                last_message_time: user.last_message_time || '',
                last_message_at: user.last_message_at || 0
            }))
        );
    }
    
    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    scrollToBottom();

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

    document.getElementById('chat-form').addEventListener('submit', (e) => {
        e.preventDefault();

        const body = chatInput.value.trim();
        if (!body && !selectedFile) return;

        isTyping = false;
        notifyTypingStatus(false);
        clearTimeout(typingTimeout);

        const formData = new FormData();
        formData.append('body', body);
        
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
                document.getElementById('emoji-picker-container').style.display = 'none';
            } else {
                console.error('Erro ao enviar mensagem');
            }
        });
    });

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
        
        const isSticker = mediaPath.includes('sticker_');

        let mediaHtml = '';

        if (mediaPath) {
            if (isImage) {
                mediaHtml = `
                    <div class="msg-media ${isSticker ? 'sticker' : ''}">
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

    function fetchMessages() {
        const url = selectedUserId 
            ? `{{ route("chat.fetch") }}?selected_user_id=${selectedUserId}` 
            : '{{ route("chat.fetch") }}';

        fetch(url)
            .then(res => res.json())
            .then(data => {
                const filteredMsgs = data.messages || data; 
                const typingUser = data.typing_user;

                if (typingUser) {
                    showTypingIndicator(typingUser);
                } else {
                    hideTypingIndicator();
                }

                const newIds = filteredMsgs.map(m => m.id);
                const shouldScroll = lastMessageCount < filteredMsgs.length || chatBox.scrollTop >= chatBox.scrollHeight - chatBox.clientHeight - 50;

                let htmlContent = [];
                let lastDate = null;

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

                if (newIds.length !== messageIds.length || JSON.stringify(newIds) !== JSON.stringify(messageIds)) {
                    const currentTyping = document.getElementById('typing-indicator');
                    
                    chatBox.innerHTML = htmlContent.join('');
                    
                    if (currentTyping) {
                        chatBox.appendChild(currentTyping);
                    }
                    
                    messageIds = newIds;
                    if (shouldScroll || newIds.length > lastMessageCount) {
                        scrollToBottom();
                    }
                }
                lastMessageCount = newIds.length;
            })
            .catch(error => console.error('Erro ao buscar mensagens:', error));
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';

        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
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
                fetchMessages(); 
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

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });

    editInput.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'Enter') {
            confirmEdit();
        }
    });

    editModal.addEventListener('click', (e) => {
        if (e.target === editModal) {
            closeEditModal();
        }
    });

    function renderUsersList(users) {
        const previousScrollTop = usersList.scrollTop;
        const previousSelectedId = selectedUserId;

        usersList.innerHTML = '';

        users.forEach(user => {
            const isActive = Number(previousSelectedId) === Number(user.id);

            const item = document.createElement('div');
            item.className = `user-item ${isActive ? 'active' : ''}`;
            item.dataset.userId = user.id;

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

            item.onclick = () => selectUser(user.id, user.name, item);
            usersList.appendChild(item);
        });

        usersList.scrollTop = previousScrollTop;
    }

    function reloadSidebar() {
        fetch(`{{ route("chat.sidebarUsers") }}`)
            .then(res => res.json())
            .then(users => {
                const newHash = buildSidebarHash(users);

                if (newHash === lastSidebarHash) {
                                      return;
                }

                lastSidebarHash = newHash;
                renderUsersList(users);
            })
            .catch(error => console.error('Erro ao recarregar sidebar:', error));
    }

    function pauseSidebarRefresh(ms = 1500) {
        sidebarPaused = true;
        clearTimeout(sidebarPauseTimer);

        sidebarPauseTimer = setTimeout(() => {
            sidebarPaused = false;
        }, ms);
    }

    // 🚀 INICIALIZAÇÃO DO CHAT 🚀
    fetchMessages();
    reloadSidebar();

    // 🔄 POLLING DE MENSAGENS (A cada 2 segundos)
    setInterval(() => {
        fetchMessages();
    }, 2000);

    // 🔄 POLLING DA SIDEBAR (A cada 5 segundos)
    setInterval(() => {
        if (!sidebarPaused) {
            reloadSidebar();
        }
    }, 5000);

</script>

@endsection
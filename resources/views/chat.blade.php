@extends('layouts.app')

@section('content')
<style>
    .chat-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .chat-header {
        border-bottom: 1px solid #222;
        padding-bottom: 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-header h1 { font-size: 1.5rem; color: #fff; }
    .chat-header .dot { width: 10px; height: 10px; background: #00cc66; border-radius: 50%; animation: pulse 1.5s infinite; }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    #chat-box {
        background: #111;
        border: 1px solid #222;
        border-radius: 8px;
        height: 420px;
        overflow-y: auto;
        padding: 20px;
        margin-bottom: 16px;
        scroll-behavior: smooth;
    }

    #chat-box::-webkit-scrollbar { width: 6px; }
    #chat-box::-webkit-scrollbar-track { background: #111; }
    #chat-box::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }

    .msg-bubble {
        margin-bottom: 16px;
        display: flex;
        flex-direction: column;
    }

    .msg-bubble.mine { align-items: flex-end; }
    .msg-bubble.other { align-items: flex-start; }

    .msg-name {
        font-size: 0.75rem;
        color: #666;
        margin-bottom: 4px;
    }

    .msg-bubble.mine .msg-name { color: #e50000; }

    .msg-text {
        max-width: 70%;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 0.9rem;
        line-height: 1.5;
        word-break: break-word;
    }

    .msg-bubble.mine .msg-text {
        background: #e50000;
        color: #fff;
        border-bottom-right-radius: 2px;
    }

    .msg-bubble.other .msg-text {
        background: #1a1a1a;
        color: #f0f0f0;
        border-bottom-left-radius: 2px;
        border: 1px solid #2a2a2a;
    }

    .msg-time {
        font-size: 0.7rem;
        color: #555;
        margin-top: 4px;
    }

    .chat-input-area {
        display: flex;
        gap: 10px;
    }

    .chat-input-area input {
        flex: 1;
        padding: 13px 16px;
        background: #111;
        border: 1px solid #333;
        border-radius: 4px;
        color: #f0f0f0;
        font-size: 0.95rem;
        transition: border 0.2s;
    }

    .chat-input-area input:focus { outline: none; border-color: #e50000; }

    .chat-input-area button {
        padding: 13px 24px;
        background: #e50000;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        transition: background 0.2s;
    }

    .chat-input-area button:hover { background: #cc0000; }
</style>

<div class="chat-wrapper">
    <div class="chat-header">
        <div class="dot"></div>
        <h1>Chat da Equipe</h1>
    </div>

    <div id="chat-box">
        @foreach($messages as $msg)
            <div class="msg-bubble {{ $msg->user_id === auth()->id() ? 'mine' : 'other' }}">
                <span class="msg-name">{{ $msg->user->name }}</span>
                <div class="msg-text">{{ $msg->body }}</div>
                <span class="msg-time">{{ $msg->created_at->format('H:i') }}</span>
            </div>
        @endforeach
    </div>

    <form class="chat-input-area" method="POST" action="{{ route('chat.store') }}" id="chat-form">
        @csrf
        <input type="text" name="body" id="chat-input" placeholder="Digite sua mensagem..." autocomplete="off" required>
        <button type="submit">Enviar</button>
    </form>
</div>

<script>
    const chatBox   = document.getElementById('chat-box');
    const currentId = {{ auth()->id() }};

    // Scroll para o final
    chatBox.scrollTop = chatBox.scrollHeight;

    // Polling a cada 3 segundos
    setInterval(async () => {
        const res  = await fetch('{{ route('chat.fetch') }}');
        const msgs = await res.json();

        chatBox.innerHTML = '';
        msgs.forEach(msg => {
            const isMine = msg.user_id === currentId;
            chatBox.innerHTML += `
                <div class="msg-bubble ${isMine ? 'mine' : 'other'}">
                    <span class="msg-name">${msg.user.name}</span>
                    <div class="msg-text">${msg.body}</div>
                    <span class="msg-time">${new Date(msg.created_at).toLocaleTimeString('pt-BR', {hour:'2-digit', minute:'2-digit'})}</span>
                </div>
            `;
        });
        chatBox.scrollTop = chatBox.scrollHeight;
    }, 3000);
</script>
@endsection
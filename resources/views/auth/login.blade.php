@extends('layouts.app')

@section('content')
<style>
    .auth-box {
        max-width: 420px;
        margin: 80px auto;
        background: #111;
        border: 1px solid #222;
        border-top: 3px solid #e50000;
        border-radius: 8px;
        padding: 40px;
    }

    .auth-box h2 {
        text-align: center;
        font-size: 1.6rem;
        margin-bottom: 30px;
        color: #fff;
    }

    .auth-box h2 span { color: #e50000; }

    .form-group { margin-bottom: 18px; }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 0.85rem;
        color: #aaa;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-group input {
        width: 100%;
        padding: 12px 14px;
        background: #1a1a1a;
        border: 1px solid #333;
        border-radius: 4px;
        color: #f0f0f0;
        font-size: 0.95rem;
        transition: border 0.2s;
    }

    .form-group input:focus {
        outline: none;
        border-color: #e50000;
    }

    .btn-primary {
        width: 100%;
        padding: 13px;
        background: #e50000;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        letter-spacing: 1px;
        transition: background 0.2s;
        margin-top: 8px;
    }

    .btn-primary:hover { background: #cc0000; }

    .auth-footer {
        text-align: center;
        margin-top: 20px;
        font-size: 0.85rem;
        color: #666;
    }

    .auth-footer a { color: #e50000; text-decoration: none; }
    .auth-footer a:hover { text-decoration: underline; }
</style>

<div class="auth-box">
    <h2>Bem-vindo de volta <span>.</span></h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com" required autofocus>
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-primary">ENTRAR</button>
    </form>
    <div class="auth-footer">
        Não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
    </div>
</div>
@endsection
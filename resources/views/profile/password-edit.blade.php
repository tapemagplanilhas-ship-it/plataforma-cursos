@extends('layouts.app')

@section('content')
<div style="max-width: 520px; margin: 40px auto; background: #111; color: #fff; padding: 24px; border-radius: 14px; border: 1px solid rgba(229,0,0,0.15);">
    <h2 style="margin-bottom: 20px; color: #e50000;">Alterar senha</h2>

    @if($errors->any())
        <div style="background: #2a0d0d; color: #ff9f9f; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('profile.password.update') }}">
        @csrf

        <div style="margin-bottom: 16px;">
            <label for="current_password" style="display:block; margin-bottom: 6px;">Senha atual</label>
            <input
                type="password"
                name="current_password"
                id="current_password"
                style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid #333; background:#1a1a1a; color:#fff;"
                placeholder="Senha atual padrão: tapemag123"
                required
            >
        </div>

        <div style="margin-bottom: 16px;">
            <label for="password" style="display:block; margin-bottom: 6px;">Nova senha</label>
            <input
                type="password"
                name="password"
                id="password"
                style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid #333; background:#1a1a1a; color:#fff;"
                required
            >
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display:block; margin-bottom: 6px;">Confirmar nova senha</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid #333; background:#1a1a1a; color:#fff;"
                required
            >
        </div>

        <button
            type="submit"
            style="background: linear-gradient(135deg, #e50000 0%, #cc0000 100%); color:#fff; border:none; padding:12px 18px; border-radius:10px; font-weight:700; cursor:pointer;"
        >
            Salvar nova senha
        </button>
    </form>
</div>
@endsection
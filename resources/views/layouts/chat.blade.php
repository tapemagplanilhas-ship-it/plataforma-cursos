<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <title>Chat - Tapemag</title>
    
    <!-- SCRIPT DE TEMA NO HEAD (Evita o flash branco ao carregar a página) -->
    <script>
        (function() {
            const userOverride = localStorage.getItem('user_theme_override');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = userOverride || (systemPrefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <style>
        /* === VARIÁVEIS GLOBAIS DO SISTEMA (Copiadas do app.blade.php) === */
        :root {
            --bg-primary: #0a0a0a;
            --bg-secondary: #111111;
            --bg-tertiary: #1a1a1a;
            --bg-input: #161616;
            --text-primary: #ffffff;
            --text-secondary: #e8e8e8;
            --text-tertiary: #888888;
            --text-placeholder: #555555;
            --border: #333333;
            --border-light: #2a2a2a;
            --accent: #e50000;
        }

        [data-theme="light"] {
            --bg-primary: #f4f4f5;
            --bg-secondary: #ffffff;
            --bg-tertiary: #e9ecef;
            --bg-input: #ffffff;
            --text-primary: #1a1a1a;
            --text-secondary: #4a4a4a;
            --text-tertiary: #6c757d;
            --text-placeholder: #adb5bd;
            --border: #dee2e6;
            --border-light: #e9ecef;
            --accent: #e50000;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden !important;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Remove o padding do container para o chat ocupar a tela toda */
        body > .container {
            padding: 0 !important;
            max-width: 100% !important;
            margin: 0 !important;
        }

        /* 
         * MAPEAMENTO PARA AS VARIÁVEIS ESPECÍFICAS DO CHAT 
         * Isso faz o chat.blade.php herdar as cores do tema global
         */
        :root {
            --color-bg-dark: var(--bg-primary);
            --color-bg-medium: var(--bg-secondary);
            --color-bg-light: var(--bg-tertiary);
            --color-bg-input: var(--bg-input);
    
            --color-text-light: var(--text-primary);
            --color-text-medium: var(--text-secondary);
            --color-text-dark: var(--text-tertiary);
            --color-text-placeholder: var(--text-placeholder);
    
            --color-primary: var(--accent);
            --color-primary-dark: #cc0000;
            --color-primary-light: rgba(229, 0, 0, 0.15);
            --color-secondary: #00cc66;
            
            --border-default: var(--border);
            --border-sidebar: var(--border-light);
        }
    </style>
</head>
<body>

@yield('content')

<!-- Script para manter o tema atualizado se o usuário mudar a preferência do SO enquanto o chat está aberto -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const html = document.documentElement;
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)');

    systemPrefersDark.addEventListener('change', (e) => {
        if (!localStorage.getItem('user_theme_override')) {
            html.setAttribute('data-theme', e.matches ? 'dark' : 'light');
        }
    });
});
</script>

</body>
</html>
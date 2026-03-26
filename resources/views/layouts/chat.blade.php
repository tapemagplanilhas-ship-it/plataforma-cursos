<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <title>Chat - Tapemag</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden !important;
        }

        /* Remove o padding do container para o chat */
        body > .container {
            padding: 0 !important;
            max-width: 100% !important;
            margin: 0 !important;
        }
        :root {
            --color-bg-dark: var(--bg-primary);
            --color-bg-medium: var(--bg-secondary);
            --color-bg-light: var(--bg-tertiary);
            --color-bg-input: var(--bg-input);
    
            --color-text-light: var(--text-primary);
            --color-text-medium: var(--text-secondary);
            --color-text-dark: var(--text-tertiary);
            --color-text-placeholder: var(--text-placeholder);
    
            --color-primary: #e50000;
            --color-primary-dark: #cc0000;
            --color-primary-light: rgba(229, 0, 0, 0.15);
            --color-secondary: #00cc66;
        }
    </style>
</head>
<body>

@yield('content')

</body>
</html>
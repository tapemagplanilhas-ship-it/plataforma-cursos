// public/sw.js

self.addEventListener('install', (event) => {
    console.log('[Service Worker] Instalado com sucesso!');
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    console.log('[Service Worker] Ativado e pronto para operar!');
    event.waitUntil(clients.claim());
});

// O que acontece quando o usuário clica na notificação?
self.addEventListener('notificationclick', (event) => {
    event.notification.close(); // Fecha a notificação

    // Se tivermos uma URL na notificação, abrimos ela
    if (event.notification.data && event.notification.data.url) {
        event.waitUntil(
            clients.openWindow(event.notification.data.url)
        );
    }
});
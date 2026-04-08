// Service Worker básico para notificações
self.addEventListener('install', () => {
    console.log('Service Worker instalado');
});

self.addEventListener('activate', () => {
    console.log('Service Worker ativado');
});

// Lidar com clique em notificação
self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    
    // Abrir a URL do aviso ao clicar
    if (event.notification.tag) {
        clients.matchAll({ type: 'window' }).then(clientList => {
            const client = clientList[0];
            if (client) {
                client.navigate('/notices/' + event.notification.tag);
                client.focus();
            }
        });
    }
});
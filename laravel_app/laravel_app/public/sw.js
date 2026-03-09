self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    const data = event.data ? event.data.json() : {};
    const title = data.title || '予防接種リマインダー';
    const options = {
        body: data.body || '',
        icon: '/icon.png',
        badge: '/icon.png',
        data: data.data || {},
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    const url = event.notification.data.url || '/dashboard';

    event.waitUntil(
        clients.openWindow(url)
    );
});
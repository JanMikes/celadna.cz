importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-messaging.js');

let firebaseConfig = {
    apiKey: "AIzaSyDiapqBLxrVlck4i3vNYH9Ip7-nWDLBTPM",
    projectId: "notifee-2",
    messagingSenderId: "949234497594",
    appId: "1:949234497594:web:cf9e5a0b7ff9b6bc1b5d03",
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    const title = payload.data.title;
    const options = {
        body: payload.data.body,
        icon: payload.data.icon,
        image: payload.data.image,
        data: {
            click_action: payload.data.click_action
        }
    };
    return self.registration.showNotification(title, options);
});

self.addEventListener('notificationclick', function (event) {
    const action = event.notification.data.click_action;
    event.notification.close();
    event.waitUntil(clients.openWindow(action));
});

class Notifee {

    static init(web, enableIcon, scope = '/', logError = false) {
        this.web = web;
        this.enableIcon = enableIcon;
        this.scope = scope;
        this.logError = logError;
        let fcmToken = localStorage.getItem('notifee-fcm-token');
        let spnToken = localStorage.getItem('notifee-spn-token');
        let canceled = localStorage.getItem('canceled');
        if (firebase.messaging.isSupported() || ('safari' in window && 'pushNotification' in window.safari)) {
            if (Notification.permission !== 'denied' && fcmToken === null && spnToken === null && canceled === null) {
                let hostname = new URL(web).hostname;
                let domainName = hostname.replace('www.', '');
                let dialogIcon = 'https://notifee-manager.cz/icon/' + domainName + '/icon.png';
                getInfo().then(result => {
                    this.showDialog(dialogIcon, result.dialogText);
                }).catch(error => {
                    this.showDialog(dialogIcon, 'Chcete dostávat oznámení z našeho webu?');
                });
            }
            if (this.enableIcon) {
                this.showNotifeeIcon();
            }
        }

        if (window.matchMedia("(max-width: 480px)").matches) {
            let banner = this.getBanner();
            if (banner === null) {
                getBanner().then(result => {
                    let banner = this.setBanner(result.bannerImage, result.bannerLink, result.bannerTimeout);
                    this.showNotifeeBanner(banner);
                }).catch(error => {
                    if (Notifee.logError) {
                        console.log(error);
                    }
                });
            } else {
                this.showNotifeeBanner(banner);
            }
        }

        async function getInfo() {
            const response = await fetch('https://notifee-manager.cz/api/info', {
                method: 'GET',
                mode: 'cors'
            });
            return response.json();
        }

        async function getBanner() {
            const response = await fetch('https://notifee-manager.cz/api/banner', {
                method: 'GET',
                mode: 'cors'
            });
            return response.json();
        }
    }

    static checkNotifications() {
        let firebaseConfig = {
            apiKey: "AIzaSyDiapqBLxrVlck4i3vNYH9Ip7-nWDLBTPM",
            projectId: "notifee-2",
            messagingSenderId: "949234497594",
            appId: "1:949234497594:web:cf9e5a0b7ff9b6bc1b5d03",
        };
        let user = 'web.push.cz.celadna';

        if (firebase.messaging.isSupported()) {

            if (!firebase.apps.length) {
                firebase.initializeApp(firebaseConfig);
                const messaging = firebase.messaging();

                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.register(Notifee.scope + 'notifee-sw.js', {scope: Notifee.scope})
                        .then((registration) => {
                            messaging.useServiceWorker(registration);
                            if (Notifee.scope === '/') {
                                navigator.serviceWorker.ready.then(registration => {
                                    requestPermission(messaging, true);
                                });
                            } else {
                                requestPermission(messaging, true);
                            }
                        });
                }

                let requestPermission = function (messaging, requestOnError = false) {
                    messaging.requestPermission()
                        .then(function () {
                            return messaging.getToken()
                        })
                        .then(function (token) {
                            let fcmToken = localStorage.getItem('notifee-fcm-token');
                            if (fcmToken !== token) {
                                postData('https://notifee-manager.cz/api/subscribe', 'fcm', token)
                                    .then(data => {
                                        localStorage.setItem('notifee-fcm-token', token);
                                        localStorage.setItem('active', 'true');
                                        if (Notifee.enableIcon) {
                                            Notifee.showNotifeeIcon();
                                            Notifee.showNotificationStatus();
                                        }
                                    }).catch(error => {
                                    if (Notifee.logError) {
                                        console.log(error);
                                    }
                                });
                            }
                        })
                        .catch(function (err) {
                            if (requestOnError) {
                                requestPermission(messaging);
                            }
                        });
                }

                messaging.onMessage(function (payload) {
                    let notification = payload.data;
                    navigator.serviceWorker.ready.then(registration => {
                        let options = {
                            body: notification.body,
                            icon: notification.icon,
                            image: notification.image,
                            data: {
                                click_action: notification.click_action
                            }
                        };
                        registration.showNotification(notification.title, options);
                    });
                });
            }
        }

        let checkRemotePermission = function (permissionData) {
            if (permissionData.permission === 'default') {
                localStorage.removeItem('notifee-spn-token');
                window.safari.pushNotification.requestPermission(
                    'https://notifee-manager.cz/push',
                    user,
                    {'web': Notifee.web},
                    checkRemotePermission
                );
            } else if (permissionData.permission === 'granted') {
                let token = permissionData.deviceToken;
                let spnToken = localStorage.getItem('notifee-spn-token');
                if (spnToken !== token) {
                    postData('https://notifee-manager.cz/api/subscribe', 'spn', token)
                        .then(data => {
                            localStorage.setItem('notifee-spn-token', token);
                            localStorage.setItem('active', 'true');
                            if (Notifee.enableIcon) {
                                Notifee.showNotifeeIcon();
                                Notifee.showNotificationStatus();
                            }
                        }).catch(error => {
                        if (Notifee.logError) {
                            console.log(error);
                        }
                    });
                }
            }
        };

        if ('safari' in window && 'pushNotification' in window.safari) {
            let permissionData = window.safari.pushNotification.permission(user);
            checkRemotePermission(permissionData);
        }

        async function postData(url, type, token) {
            let formData = new FormData();
            formData.append('type', type);
            formData.append('token', token);
            const response = await fetch(url, {
                method: 'POST',
                mode: 'cors',
                body: formData
            });
            return response.json();
        }
    }

    static showDialog(dialogIcon, dialogText) {
        document.getElementById('notifee-dialog-wrapper').innerHTML += '<div id="notifee-dialog-container" class="notifee">\n' +
            '    <div id="notifee-dialog">\n' +
            '        <div id="notifee-body">\n' +
            '            <div id="notifee-body-icon">\n' +
            '                <img src="' + dialogIcon + '" alt="">\n' +
            '            </div>\n' +
            '            <div id="notifee-body-message">' + dialogText + '</div>\n' +
            '        </div>\n' +
            '        <div id="notifee-footer">\n' +
            '            <span id="notifee-link"><a href="https://www.notifee.cz/" target="_blank">Created by <img src="https://notifee-manager.cz/images/notifee.svg" /></a></span>' +
            '            <button onclick="Notifee.allow()" id="notifee-allow-button" class="notifee-button allow">POVOLIT</button>\n' +
            '            <button onclick="Notifee.cancelDialog()" id="notifee-cancel-button" class="notifee-button cancel">Ne, děkuji</button>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>';
    }

    static allow() {
        this.cancelDialog(false);
        this.checkNotifications();
    }

    static cancelDialog(setCancel = true) {
        let dialog = document.getElementById("notifee-dialog-container");
        if (dialog != null) {
            dialog.remove();
        }
        if (setCancel) {
            localStorage.setItem('canceled', 'true');
        }
    }

    static setSubscriber(active) {
        let type = 'fcm';
        let token = localStorage.getItem('notifee-fcm-token');
        if (token === null) {
            type = 'spn';
            token = localStorage.getItem('notifee-spn-token');
        }

        postData('https://notifee-manager.cz/api/token', type, token)
            .then(data => {
                localStorage.setItem('active', active)
                if (this.enableIcon) {
                    this.showNotifeeIcon();
                    this.showNotificationStatus();
                }
            }).catch(error => {
            if (Notifee.logError) {
                console.log(error);
            }
        });

        async function postData(url, type, token) {
            let formData = new FormData();
            formData.append('type', type);
            formData.append('token', token);
            formData.append('active', active);
            const response = await fetch(url, {
                method: 'POST',
                mode: 'cors',
                body: formData
            });
            return response.json();
        }
    }

    static showNotificationStatus() {
        let notifeeTooltip = document.getElementById("notifee-tooltip");
        let notifeeIconContainer = document.getElementById("notifee-icon-container");
        if (notifeeTooltip != null && notifeeIconContainer != null) {
            let active = localStorage.getItem('active');
            let text = notifeeTooltip.innerHTML;
            if (active === 'true') {
                notifeeTooltip.innerHTML = "Nyní jste přihlášeni k odběru novinek";
            } else {
                notifeeTooltip.innerHTML = "Jste odhlášeni";
            }
            notifeeTooltip.classList.add('notifee-tooltip-show');
            notifeeIconContainer.classList.add("notifee-icon-container-full");
            setTimeout(
                function () {
                    notifeeTooltip.innerHTML = text;
                    notifeeTooltip.classList.remove('notifee-tooltip-show');
                    notifeeIconContainer.classList.remove("notifee-icon-container-full");
                }, 1200);
        }
    }

    static setNotifications() {
        switch (Notification.permission) {
            case "default":
                this.checkNotifications();
                break;
            case "granted":
                let active = localStorage.getItem('active');
                if (active === 'true') {
                    this.setSubscriber('false');
                } else {
                    this.setSubscriber('true');
                }
                break;
            case "denied":
                break;
        }
    }

    static showNotifeeIcon() {
        let tooltipText = '';
        let iconDialogText = '';
        switch (Notification.permission) {
            case "default":
                tooltipText = 'Přihlásit se k odběru novinek';
                iconDialogText = 'ZAČÍT ODEBÍRAT';
                break;
            case "granted":
                let active = localStorage.getItem('active');
                if (active === 'true') {
                    tooltipText = 'Jste přihlášení k odběru novinek';
                    iconDialogText = 'ZRUŠIT ODBĚR';
                } else {
                    tooltipText = 'Přihlásit se k odběru novinek';
                    iconDialogText = 'ZAČÍT ODEBÍRAT';
                }
                break;
            case "denied":
                tooltipText = 'Máte zablokováno oznámení. Pro odběr novinek si jej povolte v nastavení prohlížeče.';
                break;
        }

        let oldNotifeeIconContainer = document.getElementById("notifee-icon-container");
        if (oldNotifeeIconContainer != null) {
            oldNotifeeIconContainer.remove();
        }
        document.getElementById('notifee-icon-wrapper').innerHTML += '<div id="notifee-icon-container" class="notifee">\n' +
            '    <div id="notifee-icon" class="notifee-tooltip notifee-icon-dialog">\n' +
            '        <div id="notifee-icon-circle">\n' +
            '            <svg id="notifee-icon-bell" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"\n' +
            '                 focusable="false" width="30px" height="30px" preserveAspectRatio="xMidYMid meet" viewBox="0 0 700 820">\n' +
            '                <path d="M579 372q0 24 9 45t25 37t37 25t45 9v93H0v-93q24 0 45-9t37-25t25-37t9-45V233q0-48 18-90t50-74t73-50t90-18t90 18t74 50t50 74t18 90v139zM347 696q-32 0-56-20t-33-49h179q-8 30-32 49t-58 20z"\n' +
            '                      fill="#ececec"/>\n' +
            '            </svg>\n' +
            '            <span id="notifee-tooltip" class="notifee-tooltip-text">\n' +
            '                ' + tooltipText + '\n' +
            '            </span>\n' +
            '            <div id="notifee-icon-dialog" class="notifee-icon-dialog-text">\n' +
            '                ' + iconDialogText + '\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>';

        let notifeeIconContainer = document.getElementById("notifee-icon-container");
        let notifeeIconDialog = document.getElementById("notifee-icon-dialog");
        let notifeeTooltip = document.getElementById("notifee-tooltip");
        document.body.addEventListener('click', function (ev) {
            if (notifeeIconContainer != null) {
                notifeeIconContainer.classList.remove("notifee-icon-container-full");
            }
            if (notifeeIconDialog != null) {
                notifeeIconDialog.classList.remove("notifee-visible");
            }
            if (notifeeTooltip != null) {
                notifeeTooltip.classList.remove("notifee-hidden");
                notifeeTooltip.classList.remove('notifee-tooltip-show');
            }
        }, false);
        document.getElementById('notifee-icon').addEventListener('click', function (ev) {
            if (notifeeIconContainer != null && notifeeIconDialog != null && notifeeTooltip != null && Notification.permission !== 'denied') {
                if (window.getComputedStyle(notifeeIconDialog).visibility === 'visible') {
                    notifeeIconContainer.classList.remove("notifee-icon-container-full");
                    notifeeIconDialog.classList.remove("notifee-visible");
                    notifeeTooltip.classList.remove("notifee-hidden");
                } else {
                    notifeeIconContainer.classList.add("notifee-icon-container-full");
                    notifeeIconDialog.classList.add("notifee-visible");
                    notifeeTooltip.classList.add("notifee-hidden");
                }
            }
            ev.stopPropagation();
        }, false);
        document.getElementById('notifee-icon-dialog').addEventListener('click', function (ev) {
            Notifee.setNotifications();
        }, false);
    }

    static showNotifeeBanner(banner) {
        if (banner !== null && banner.image !== null) {
            let bannerImageUrl = 'https://notifee-manager.cz/' + banner.image;
            setTimeout(function () {
                let link = '';
                if (banner.link && banner.link.length > 0) {
                    link = 'href="' + banner.link + '"';
                }
                document.getElementById('notifee-banner-wrapper').innerHTML += '<div id="notifee-banner" class="notifee">\n' +
                    '    <div id="notifee-banner-close">\n' +
                    '        <div id="notifee-banner-icon"></div>\n' +
                    '    </div>\n' +
                    '    <a ' + link + ' target="_blank">\n' +
                    '        <img src="' + bannerImageUrl + '" width="100%">\n' +
                    '    </a>\n' +
                    '</div>';
                document.getElementById('notifee-banner-close').addEventListener('click', function (ev) {
                    document.getElementById("notifee-banner").classList.add("notifee-gone");
                }, false);
            }, banner.timeout);
        }
    }

    static setBanner(image, link, timeout) {
        const banner = {
            image: image,
            link: link,
            timeout: timeout,
            expiration: new Date().getTime() + 24 * 60 * 60 * 1000
        }
        localStorage.setItem('notifee-banner', JSON.stringify(banner));
        return banner;
    }

    static getBanner() {
        const bannerStr = localStorage.getItem('notifee-banner');
        if (bannerStr === null) {
            return null;
        }
        const banner = JSON.parse(bannerStr);
        if (new Date().getTime() > banner.expiration) {
            localStorage.removeItem('notifee-banner');
            return null;
        }
        return banner;
    }

}
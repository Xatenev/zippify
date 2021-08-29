document.addEventListener("DOMContentLoaded", function(event) {
    const settings = document.querySelector('.settings');
    const settingsIcon = document.querySelector('.settings.open i');
    const settingsMenu = document.querySelector('.settings-menu');
    const dropzone = document.querySelector('.dropzone')

    const tar = document.querySelector('input#settings-tar');
    const gz = document.querySelector('input#settings-gz');
    const bz2 = document.querySelector('input#settings-bz2');
    const virus = document.querySelector('input#settings-virus');
    const share = document.querySelector('input#settings-share');
    const password = document.querySelector('input#settings-password');
    const passwordInput = document.querySelector('input#settings-password-input');

    settings.addEventListener('click', function(event) {
        clearTimeout(window.settingsAnimation);
        if (event.target.parentElement.classList.contains('close')) {
            settingsIcon.classList.remove('fa-times');
            settingsIcon.classList.add('fa-wrench');
            settingsMenu.classList.add('hidden');
        } else {
            settingsIcon.classList.remove('fa-wrench');
            settingsIcon.classList.add('fa-times');

            window.settingsAnimation = setTimeout(() => {
                settingsMenu.classList.remove('hidden');
            }, 500);
        }

        dropzone.classList.toggle('expanded');
        settings.classList.toggle('close');
    });

    virus.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            window.history.pushState({}, '', document.location.pathname + 'virus');
        } else {
            window.history.pushState({}, '', document.location.pathname.replace('virus', ''));
        }
    });

    share.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            window.history.pushState({}, '', document.location.pathname + 'share');
        } else {
            window.history.pushState({}, '', document.location.pathname.replace('share', ''));
        }
    });

    password.addEventListener('change', function(event) {
        passwordInput.parentElement.classList.toggle('hidden');
        requestAnimationFrame(function() {
            passwordInput.value = '';
        });

        if(event.currentTarget.checked) {
            window.history.pushState({}, '', document.location.pathname + 'password');
            tar.checked = false;
            gz.checked = false;
            bz2.checked = false;
            tar.disabled = true;
            gz.disabled = true;
            bz2.disabled = true;
            passwordInput.focus();
        } else {
            window.history.pushState({}, '', document.location.pathname.replace('password', ''));
            tar.disabled = false;
            gz.disabled = false;
            bz2.disabled = false;
        }
    });

    tar.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            window.history.pushState({}, '', document.location.pathname + 'tar');
            password.checked = false;
            password.disabled = true;
        } else {
            window.history.pushState({}, '', document.location.pathname.replace('tar', ''));
            gz.disabled = false;
            bz2.disabled = false;
            gz.checked = false;
            bz2.checked = false;
            password.disabled = false;
        }
    });

    gz.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            window.history.pushState({}, '', document.location.pathname + 'gz');
            password.checked = false;
            password.disabled = true;
            tar.checked = true;
            bz2.disabled = true;
            bz2.checked = false;
        } else {
            window.history.pushState({}, '', document.location.pathname.replace('gz', ''));
            bz2.disabled = false;
        }
    });

    bz2.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            window.history.pushState({}, '', document.location.pathname + 'bz2');
            password.checked = false;
            password.disabled = true;
            tar.checked = true;
            gz.disabled = true;
            gz.checked = false;
        } else {
            window.history.pushState({}, '', document.location.pathname.replace('bz2', ''));
            gz.disabled = false;
        }
    });

    if(document.location.pathname.indexOf('password') !== -1) {
        passwordInput.focus();
    }
});
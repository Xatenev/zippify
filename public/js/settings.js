document.addEventListener("DOMContentLoaded", function(event) {
    const settings = document.querySelector('.settings');
    const settingsIcon = document.querySelector('.settings.open i');
    const settingsMenu = document.querySelector('.settings-menu');
    const dropzone = document.querySelector('.dropzone')

    const tar = document.querySelector('input#settings-tar');
    const gz = document.querySelector('input#settings-gz');
    const bz2 = document.querySelector('input#settings-bz2');
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

    password.addEventListener('change', function(event) {
        passwordInput.parentElement.classList.toggle('hidden');

        if(event.currentTarget.checked) {
            tar.checked = false;
            gz.checked = false;
            tar.disabled = true;
            gz.disabled = true;
            passwordInput.focus();
        } else {
            tar.disabled = false;
            passwordInput.value = '';
        }
    });

    tar.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            gz.disabled = false;
            bz2.disabled = false;
            password.disabled = true;
        } else {
            gz.checked = false;
            gz.disabled = true;
            bz2.checked = false;
            bz2.disabled = true;
            password.disabled = false;
        }
    });

    gz.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            bz2.disabled = true;
            bz2.checked = false;
        } else {
            bz2.disabled = false;
        }
    });

    bz2.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            gz.disabled = true;
            gz.checked = false;
        } else {
            gz.disabled = false;
        }
    });

    if(document.location.pathname.indexOf('password') !== -1) {
        passwordInput.focus();
    }
});
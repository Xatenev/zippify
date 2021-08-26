document.addEventListener("DOMContentLoaded", function(event) {
    const settings = document.querySelector('.settings');
    const settingsIcon = document.querySelector('.settings.open i');
    const settingsMenu = document.querySelector('.settings-menu');
    const dropzone = document.querySelector('.dropzone')
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

    const tar = document.querySelector('input#settings-tar');
    const gz = document.querySelector('input#settings-gz');
    const password = document.querySelector('input#settings-password');
    const passwordInput = document.querySelector('input#settings-password-input');

    password.addEventListener('change', function(event) {
        passwordInput.parentElement.classList.toggle('hidden');

        if(event.currentTarget.checked) {
            tar.disabled = true;
            gz.disabled = true;
            passwordInput.focus();
        } else {
            tar.disabled = false;
            gz.disabled = false;
            passwordInput.value = '';
        }
    });


    tar.addEventListener('change', function(event) {
        if(event.currentTarget.checked) {
            password.disabled = true;
        } else {
            password.disabled = false;
        }
    });

    if(document.location.pathname.indexOf('password') !== -1) {
        passwordInput.focus();
    }
});
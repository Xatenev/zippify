document.addEventListener("DOMContentLoaded", function(event) {
    const settings = document.querySelector('.settings');
    const settingsIcon = document.querySelector('.settings.open i');
    const settingsMenu = document.querySelector('.settings-menu');
    const dropzone = document.querySelector('.dropzone')
    settings.addEventListener('click', function(event) {
        if (event.target.parentElement.classList.contains('close')) {
            settingsIcon.classList.remove('fa-times');
            settingsIcon.classList.add('fa-wrench');
            settingsMenu.classList.add('hidden');
        } else {
            settingsIcon.classList.remove('fa-wrench');
            settingsIcon.classList.add('fa-times');

            setTimeout(() => {
                settingsMenu.classList.remove('hidden');
            }, 500);
        }

        dropzone.classList.toggle('expanded');
        settings.classList.toggle('close');
    });

    const password = document.querySelector('input#settings-password');
    const passwordInput = document.querySelector('input#settings-password-input');

    password.addEventListener('change', function(event) {
        passwordInput.parentElement.classList.toggle('hidden');

        if(event.currentTarget.checked) {
            passwordInput.focus();
        } else {
            passwordInput.value = '';
        }
    })
});
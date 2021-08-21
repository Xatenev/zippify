document.addEventListener("DOMContentLoaded", function(event) {
    const settings = document.querySelector('.settings');
    const settingsIcon = document.querySelector('.settings.open i');
    const settingsMenu = document.querySelector('.settings-menu');
    const dropzone = document.querySelector('.dropzone')
    settings.addEventListener('click', function(event) {

        console.log(event.target.parentElement.className);
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
});
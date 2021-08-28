document.addEventListener("DOMContentLoaded", function (event) {
    const help = document.querySelector('.help');

    help.addEventListener('click', function (event) {
        MicroModal.show('help', {
            disableFocus: true
        });
    });
});
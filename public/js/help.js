document.addEventListener("DOMContentLoaded", function (event) {
    const help = document.querySelector('.help');
    const modal = document.querySelector('#help-modal');

    help.addEventListener('click', function (event) {
        if(modal.classList.contains('is-open')) {
            MicroModal.close('help-modal');
        } else {
            MicroModal.show('help-modal', {
                disableFocus: true
            });
        }
    });
});
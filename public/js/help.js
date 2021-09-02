document.addEventListener("DOMContentLoaded", function () {
    const help = document.querySelector('.help');
    const modal = document.querySelector('#help-modal');
    const copy = document.querySelector('#help-modal .copy');
    const code = document.querySelector('#help-modal .code');

    // Setup help button click listener, toggles modal display
    if(help) {
        help.addEventListener('click', function (event) {
            if (modal.classList.contains('is-open')) {
                MicroModal.close('help-modal');
            } else {
                MicroModal.show('help-modal', {
                    disableFocus: true
                });
            }
        });
    }

    // Setup command line usage code copy to clipboard functionality
    if(copy) {
        copy.addEventListener('click', function (event) {
            // Copy to clipboard automatically if possible
            const textarea = document.createElement("textarea");
            textarea.value = code.innerText;

            textarea.style.top = "0";
            textarea.style.left = "0";
            textarea.style.position = "fixed";

            document.body.appendChild(textarea);
            textarea.focus();
            textarea.select();
            document.execCommand('copy');

            document.body.removeChild(textarea);

            // Select text automatically, user can press Ctrl+C to copy manually if needed
            const range = document.createRange();
            range.selectNodeContents(code);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
        });
    }

});
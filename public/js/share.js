document.addEventListener("DOMContentLoaded", function () {
    const share = document.querySelector('#share');
    const url = document.querySelector('.url');

    // Setup help button click listener, toggles modal display
    share.addEventListener('click', function (event) {
        if(event.target === url || event.target.classList.contains('fa-copy')) return;
        // Force download zip file
        const link = document.createElement("a");
        link.href = share.dataset.url;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Setup help button click listener, toggles modal display
    url.addEventListener('click', function (event) {
        // Copy to clipboard automatically if possible
        const textarea = document.createElement("textarea");
        textarea.value = window.location.href;

        textarea.style.top = "0";
        textarea.style.left = "0";
        textarea.style.position = "fixed";

        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();
        document.execCommand('copy');

        document.body.removeChild(textarea);
    });
});
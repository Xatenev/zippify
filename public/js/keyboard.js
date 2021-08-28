document.addEventListener("DOMContentLoaded", function(event) {
    const dropzone = document.querySelector('.dropzone');

    const settingsButton = document.querySelector('.settings');
    const helpButton = document.querySelector('.help');

    const settings = {
        t: document.querySelector('input#settings-tar'),
        g: document.querySelector('input#settings-gz'),
        b: document.querySelector('input#settings-bz2'),
        p: document.querySelector('input#settings-password'),
        s: document.querySelector('input#settings-share'),
        v: document.querySelector('input#settings-virus'),
    };

    document.addEventListener('keypress', function(e) {
        if(e.target !== document.querySelector('body')) return;

        switch(e.key) {
            case 'u':
                dropzone.click();
                break;
            case 'h':
                helpButton.click();
                break;
            case 't':
            case 'g':
            case 'b':
            case 'p':
            case 's':
            case 'v':
                if(!dropzone.classList.contains('expanded')) {
                    settingsButton.click();
                }

                if(!settings[e.key].disabled) {
                    const event = document.createEvent('HTMLEvents');
                    event.initEvent('change', false, true);
                    settings[e.key].checked = !settings[e.key].checked;
                    settings[e.key].dispatchEvent(event);
                }
                break;
        }
    });
});
Dropzone.options.zippifyUpload = {
    url: '/file',
    autoProcessQueue: false,
    createImageThumbnails: false,
    uploadMultiple: true,
    sending: function(file, xhr, formData) {
        formData.append('password', document.querySelector('#settings-password-input').value);
        formData.append('tar', document.querySelector('#settings-tar').checked);
        formData.append('gz', document.querySelector('#settings-gz').checked);
        formData.append('share', document.querySelector('#settings-share').checked);
    },
    addedfiles: function() {
        const dropzone = document.querySelector('.dropzone');
        const dropzoneChilds = dropzone.querySelectorAll(':scope > *');
        const loading = dropzone.querySelector('.loading');

        dropzone.style.pointerEvents = 'none';
        dropzone.style.borderColor = 'transparent';
        dropzoneChilds.forEach((element) => {
            element.style.display = 'none';
        });

        loading.style.display = 'flex';

        this.processQueue();
    },
    successmultiple: function(files, url) {
        const link = document.createElement("a");
        link.href = url;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
};
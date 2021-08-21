Dropzone.options.zippifyUpload = {
    url: '/file',
    autoProcessQueue: false,
    createImageThumbnails: false,
    uploadMultiple: true,
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
        console.log(arguments);
        console.log("success");
        const link = document.createElement("a");
        link.download = name;
        link.href = url;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
};
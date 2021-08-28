Dropzone.options.zippifyUpload = {
    url: '/file',
    timeout: 120000,
    parallelUploads: 256,
    autoProcessQueue: false,
    createImageThumbnails: false,
    uploadMultiple: true,
    addedfiles: function() {
        // Hide dropzone
        const dropzone = document.querySelector('.dropzone');
        const dropzoneChilds = dropzone.querySelectorAll(':scope > *');
        const loading = dropzone.querySelector('.loading');

        dropzone.style.pointerEvents = 'none';
        dropzone.style.borderWidth = '0';
        dropzoneChilds.forEach((element) => {
            element.style.display = 'none';
        });

        // Show loading indicator
        loading.style.display = 'flex';

        // Send files
        this.processQueue();
    },
    successmultiple: function(files, url) {
        // Remove all files from the dropzone
        this.removeAllFiles();

        // Force download zip file
        const link = document.createElement("a");
        link.href = url;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Show dropzone
        const dropzone = document.querySelector('.dropzone');
        const dropzoneChilds = dropzone.querySelectorAll(':scope > *');
        const loading = dropzone.querySelector('.loading');

        dropzone.style.pointerEvents = 'auto';
        dropzone.style.borderWidth = '2px';
        dropzoneChilds.forEach((element) => {
            element.style.display = 'flex';
        });

        // Hide loading indicator
        loading.style.display = 'none';
    }
};
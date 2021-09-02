Dropzone.options.dropzone = {
    url: '/file',
    timeout: 120000,
    parallelUploads: 64,
    uploadMultiple: true,
    autoProcessQueue: false,
    createImageThumbnails: false,
    addedfiles: function (files) {
        // Get size of all files in MB
        const size = Array.from(files).map((file) => file.size / (1024 * 1024)).reduce((a, b) => a + b, 0);

        let error;
        if (files.length > 64) {
            error = 'Too many files selected, please only select up to 64 files';
        }
        if (size > 30) {
            error = 'Total file size is too large, please only select files up to 30 MB';
        }

        if (error) {
            Toastify({
                text: error,
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: 'top',
                position: 'right',
                className: 'toast',
                stopOnFocus: true, // Prevents dismissing of toast on hover
            }).showToast();
            this.removeAllFiles();
            return;
        }

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
    successmultiple: function (files, url) {
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
    },
    errormultiple: function (file, reason, response) {
        // Show notification
        Toastify({
            text: "An error occured while trying to upload your files. Please try again",
            duration: 3000,
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            className: "toast",
            stopOnFocus: true, // Prevents dismissing of toast on hover
        }).showToast();

        this.removeAllFiles();

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
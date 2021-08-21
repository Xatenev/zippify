<html lang="en">
<head>
    <title>Zippify</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="description" content="Zippify">
    <script src="../../vendor/js/dropzone.js"></script>
    <script src="../../js/dropzone_options.js"></script>
    <link rel="stylesheet" href="../../vendor/css/dropzone.css">
    <link rel="stylesheet" href="../../css/dropzone.css">
    <link rel="stylesheet" href="../../css/loading.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Inter:300,300italic,200,200italic,400,400italic%7CPoppins:200,200italic,400,400italic%7CManrope:300,300italic"
          rel="stylesheet" type="text/css">
</head>
<body>
<section id="main">
    <div class="inner">
        <div class="container">
            <div class="wrapper">
                <div class="inner">
                    <h3>Zip all your files instantly</h3>
                    <h1>Zippify</h1>
                    <form action="/upload" class="dropzone needsclick dz-clickable" id="zippify-upload">
                        <div class="dz-message needsclick">
                            <button type="button" class="dz-button">Drop files here or click to upload.</button>
                        </div>

                        <div class="loading">
                            <div class="line"></div>
                            <div class="subline inc"></div>
                            <div class="subline dec"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
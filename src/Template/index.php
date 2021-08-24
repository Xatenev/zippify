<html lang="en">
<head>
    <title>Zippify</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="description" content="Zippify">
    <script src="../../vendor/js/micromodal.js"></script>
    <script src="../../vendor/js/dropzone.js"></script>
    <script src="../../js/dropzone_options.js"></script>
    <script src="../../js/settings.js"></script>
    <link rel="stylesheet" href="../../vendor/css/dropzone.css">
    <link rel="stylesheet" href="../../vendor/css/hover-min.css">
    <link rel="stylesheet" href="../../css/checkbox.css">
    <link rel="stylesheet" href="../../css/dropzone.css">
    <link rel="stylesheet" href="../../css/loading.css">
    <link rel="stylesheet" href="../../css/main.css">
    <script src="https://kit.fontawesome.com/9843e0173c.js" crossorigin="anonymous"></script>
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
                    <form action="/upload" class="dropzone needsclick dz-clickable <?= $settings ? 'expanded' : '' ?>" id="zippify-upload">
                        <div class="dz-message needsclick">
                            <button type="button" class="dz-button">Drop files here or click to upload.</button>
                        </div>

                        <div class="settings-menu <?= $settings ? '' : 'hidden' ?>">
                            <hr>
                            <div class="checkbox-group">
                                <div>
                                    <div>
                                        <input type="checkbox" name="settings" id="settings-tar" <?= $tar ? 'checked' : '' ?>>
                                        <label for="settings-tar">tar<i class="fas fa-file-archive"></i></label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="settings" id="settings-gz" <?= $gz ? 'checked' : '' ?>>
                                        <label for="settings-gz">.gz compression<i class="fas fa-archive"></i></label>
                                    </div>
                                    <div class="password-input <?= $password ? '' : 'hidden' ?>">
                                        <input type="text" id="settings-password-input" name="password">
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <input type="checkbox" name="settings" id="settings-password" <?= $password ? 'checked' : '' ?>>
                                        <label for="settings-password">password<i class="fas fa-lock"></i></label>
                                    </div>
                                    <div>
                                        <input type="checkbox" name="settings" id="settings-share" <?= $share ? 'checked' : '' ?>>
                                        <label for="settings-share">share<i class="fas fa-share-alt"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="settings open <?= $settings ? 'close' : '' ?> hvr-pulse-grow">
                            <i class="fas <?= $settings ? 'fa-times' : 'fa-wrench' ?>"></i>
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
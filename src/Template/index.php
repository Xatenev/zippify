<?php

use Xatenev\Zippify\Model\ViewSettings;

/** @var $settings ViewSettings */
$settings = $this->getAttribute('settings');
?>

<html lang="en">
<head>
    <title>Zippify</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="description" content="Zippify - Generate zip/tar archives from files">
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL . 'img/favicon.png' ?>">
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
    <link rel="stylesheet" href="../../css/responsive.css">
    <script src="https://kit.fontawesome.com/9843e0173c.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Inter:300,300italic,200,200italic,400,400italic%7CPoppins:200,200italic,400,400italic%7CManrope:300,300italic"
          rel="stylesheet" type="text/css">
</head>
<body>
<section id="main">
    <div class="inner">
        <div class="container">
            <div class="inner">
                <h3>Zip all your files instantly</h3>
                <h1>Zippify</h1>
                <form action="/upload"
                      class="dropzone needsclick dz-clickable <?= $settings->hasAny() ? 'expanded' : '' ?>"
                      id="zippify-upload">
                    <div class="dz-message needsclick">
                        <button type="button" class="dz-button">Drop files here or click to upload</button>
                    </div>

                    <div class="settings-menu <?= $settings->hasAny() ? '' : 'hidden' ?>">
                        <hr>
                        <div class="checkbox-group">
                            <div>
                                <div>
                                    <input type="checkbox" name="settings"
                                           id="settings-tar" <?= $settings->hasTar() ? 'checked' : '' ?> <?= !$settings->hasTar() && $settings->hasPassword() ? 'disabled' : '' ?>>
                                    <label for="settings-tar">tar<i class="fas fa-file-archive"></i></label>
                                </div>
                                <div>
                                    <input type="checkbox" name="settings"
                                           id="settings-gz" <?= $settings->hasGz() ? 'checked' : '' ?> <?= !$settings->hasTar() ? 'disabled' : '' ?>>
                                    <label for="settings-gz">.gz<i class="fas fa-archive"></i></label>
                                </div>
                                <div>
                                    <input type="checkbox" name="settings"
                                           id="settings-bz2" <?= $settings->hasBz2() ? 'checked' : '' ?> <?= !$settings->hasTar() ? 'disabled' : '' ?>>
                                    <label for="settings-bz2">.bz2<i class="fas fa-archive"></i></label>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <input type="checkbox" name="settings"
                                           id="settings-password" <?= !$settings->hasTar() && $settings->hasPassword() ? 'checked' : '' ?> <?= $settings->hasTar() ? 'disabled' : '' ?>>
                                    <label for="settings-password">password<i class="fas fa-lock"></i></label>
                                </div>
                                <div class="password-input <?= !$settings->hasTar() && $settings->hasPassword() ? '' : 'hidden' ?>">
                                    <input type="text" id="settings-password-input" name="password">
                                </div>
                                <div>
                                    <input type="checkbox" name="settings"
                                           id="settings-share" <?= $settings->hasShare() ? 'checked' : '' ?>>
                                    <label for="settings-share">share<i class="fas fa-share-alt"></i></label>
                                </div>
                                <div>
                                    <input type="checkbox" name="settings"
                                           id="settings-virus" <?= $settings->hasVirus() ? 'checked' : '' ?>>
                                    <label for="settings-virus">virus<i class="fas fa-shield-virus"></i></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="settings open <?= $settings->hasAny() ? 'close' : '' ?> hvr-pulse-grow">
                        <i class="fas <?= $settings->hasAny() ? 'fa-times' : 'fa-wrench' ?>"></i>
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
</section>
</body>
</html>

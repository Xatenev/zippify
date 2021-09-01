<?php


$token = $this->getAttribute('token');
$expiration = $this->getAttribute('expiration');
$size = $this->getAttribute('size');
$count = $this->getAttribute('count');
$url = $this->getAttribute('url');
?>

<html lang="en">
<head>
    <title>Zippify</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="description" content="Zippify - Generate zip/tar archives from files">
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_URL . 'img/favicon.png' ?>">
    <script src="../../js/share.js"></script>
    <link rel="stylesheet" href="../../vendor/css/hover-min.css">
    <link rel="stylesheet" href="../../css/share.css">
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
                <div id="share" class="hvr-grow" data-url="<?= $url ?>">
                    <table>
                        <tr>
                            <td>Url:</td>
                            <td class="url hvr-pulse-grow"><span class="fas fa-copy"></span> Copy</td>
                        </tr>
                        <tr>
                            <td>Size:</td>
                            <td><?= $size / 4096 ?> MB</td>
                        </tr>
                        <tr>
                            <td>Expires at:</td>
                            <td><?= $expiration->format('d.m.Y H:i') ?></td>
                        </tr>
                        <tr>
                            <td>Files:</td>
                            <td><?= $count ?></td>
                        </tr>
                    </table>

                    <span class="download hvr-pulse-grow"><span class="fas fa-download"></span> Download</span>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>

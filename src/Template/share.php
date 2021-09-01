<?php


$token = $this->getAttribute('token');
$expiration = $this->getAttribute('expiration');
$size = $this->getAttribute('size');
$count = $this->getAttribute('count');
$url = $this->getAttribute('url');

require_once 'Partials/header.php'; ?>

<h3>Zip all your files instantly</h3>
<a class="title" href="/"><h1>Zippify</h1></a>
<div id="share" class="hvr-grow" data-url="<?= $url ?>">
    <table>
        <tr>
            <td>Url:</td>
            <td class="url hvr-pulse-grow"><span class="fas fa-copy"></span> Copy</td>
        </tr>
        <tr>
            <td>Size:</td>
            <td><?= $size ?> MB</td>
        </tr>
        <tr>
            <td>Expires on:</td>
            <td><?= $expiration->format('d.m.Y H:i') ?></td>
        </tr>
        <tr>
            <td>Files:</td>
            <td><?= $count ?></td>
        </tr>
    </table>

    <span class="download hvr-pulse-grow"><span class="fas fa-download"></span> Download</span>
</div>

<?php require_once 'Partials/footer.php'; ?>

<?php

use Xatenev\Zippify\Model\ViewSettingsModel;

/** @var $settings ViewSettingsModel */
$settings = $this->getAttribute('settings');

require_once 'Partials/header.php'; ?>

<h3>Zip all your files instantly</h3>
<a class="title" href="/"><h1>Zippify</h1></a>
<form action="/upload" class="dropzone needsclick dz-clickable <?= $settings->hasAny() ? 'expanded' : '' ?>"
      id="dropzone">
    <div class="dz-message needsclick">
        <button type="button" class="dz-button">Drop files here or click to upload</button>
    </div>

    <div class="settings-menu <?= $settings->hasAny() ? '' : 'hidden' ?>">
        <hr>
        <div class="checkbox-group">
            <div>
                <div>
                    <input type="checkbox" name="settings[tar]"
                           id="settings-tar" <?= $settings->hasTar() ? 'checked' : '' ?> <?= $settings->hasPassword() ? 'disabled' : '' ?>>
                    <label for="settings-tar">tar<i class="fas fa-file-archive"></i></label>
                </div>
                <div>
                    <input type="checkbox" name="settings[gz]"
                           id="settings-gz" <?= $settings->hasGz() ? 'checked' : '' ?> <?= $settings->hasPassword() || $settings->hasBz2() ? 'disabled' : '' ?>>
                    <label for="settings-gz">.gz<i class="fas fa-archive"></i></label>
                </div>
                <div>
                    <input type="checkbox" name="settings[bz2]"
                           id="settings-bz2" <?= $settings->hasBz2() ? 'checked' : '' ?> <?= $settings->hasPassword() || $settings->hasGz() ? 'disabled' : '' ?>>
                    <label for="settings-bz2">.bz2<i class="fas fa-archive"></i></label>
                </div>
            </div>
            <div>
                <div>
                    <input type="checkbox" name="settings[password]"
                           id="settings-password" <?= $settings->hasPassword() ? 'checked' : '' ?> <?= $settings->hasTar() ? 'disabled' : '' ?>>
                    <label for="settings-password">password<i class="fas fa-lock"></i></label>
                </div>
                <div class="password-input <?= $settings->hasPassword() ? '' : 'hidden' ?>">
                    <input type="text" id="settings-password-input" name="settings[password-input]">
                </div>
                <div>
                    <input type="checkbox" name="settings[share]"
                           id="settings-share" <?= $settings->hasShare() ? 'checked' : '' ?>>
                    <label for="settings-share">share<i class="fas fa-share-alt"></i></label>
                </div>
                <div>
                    <input type="checkbox" name="settings[virus]"
                           id="settings-virus" <?= $settings->hasVirus() ? 'checked' : '' ?>>
                    <label for="settings-virus">virus<i class="fas fa-shield-virus"></i></label>
                </div>
            </div>
        </div>
    </div>

    <div class="buttons">
        <div class="help hvr-pulse-grow">
            <i class="fas fa-question-circle"></i>
        </div>

        <div class="settings open <?= $settings->hasAny() ? 'close' : '' ?> hvr-pulse-grow">
            <i class="fas <?= $settings->hasAny() ? 'fa-times' : 'fa-wrench' ?>"></i>
        </div>
    </div>

    <div class="loading">
        <div class="line"></div>
        <div class="subline inc"></div>
        <div class="subline dec"></div>
    </div>
</form>

<?php require_once 'Partials/help.php' ?>
<?php require_once 'Partials/footer.php' ?>


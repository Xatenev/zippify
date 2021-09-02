<div class="modal micromodal-slide" id="help-modal" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="help-modal-title">
            <header class="modal__header">
                <h2 class="modal__title" id="help-modal-title">
                    Help
                </h2>
                <button class="modal__close hvr-pulse-grow" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <div class="modal__content" id="help-modal-content">
                <h3>Set settings by url</h3>
                <p>Settings can be passed directly via url, for example: <a class="highlight" target="_blank"
                                                                            href="<?= BASE_URL . 'targz' ?>"><?= BASE_URL . 'targz' ?></a>
                    would enable 'tar' and 'gz'. Commonly used settings can also be stored as <span class="highlight">bookmarks</span>
                    in your browser.</p>
                <br>
                <p>Available settings: </p>
                <p><span class="highlight">tar</span>,
                    <span class="highlight">gz</span>,
                    <span class="highlight">bz2</span>,
                    <span class="highlight">password</span>,
                    <span class="highlight">share</span>,
                    <span class="highlight">virus</span>
                </p>

                <h3>Keyboard navigation</h3>
                <p><span class="highlight">U</span> - Open upload dialogue</p>
                <p><span class="highlight">H</span> - Toggle help</p>
                <p><span class="highlight">T</span> - Toggle tar</p>
                <p><span class="highlight">G</span> - Toggle gz</p>
                <p><span class="highlight">B</span> - Toggle bz2</p>
                <p><span class="highlight">P</span> - Toggle password</p>
                <p><span class="highlight">S</span> - Toggle share</p>
                <p><span class="highlight">V</span> - Toggle virus</p>

                <h3>Command line usage <a href="#" class="copy"><i class="fas fa-copy"></i></a></h3>
                <p class="code">
                    <span class="highlight">url</span>=$(<span class="highlight">curl</span> -F 'file[0]=@sample.txt' -F
                    'settings[tar]=1' <?= BASE_URL . 'file' ?>) &&
                    <span class="highlight">wget</span> $url;</p>
            </div>
        </div>
    </div>
</div>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['idioma'])) {
    $_SESSION['idioma'] = $_GET['idioma'];
}

$idioma = $_SESSION['idioma'] ?? 'eng';
?>

<button id="helperBtn" class="btn btn-helper" data-bs-toggle="modal" data-bs-target="#helperModal">
    <i class="bi bi-question"></i>
</button>

<div id="helperModal" class="modal fade" tabindex="-1" aria-labelledby="helperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $idioma === 'eng' ? 'About this page' : 'Sobre esta página' ?></h1>
                <button type="button" class="btn-close btn-lang" data-lang="ESP">ESP</button>
                <button type="button" class="btn-close btn-lang" data-lang="ENG">ENG</button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div
                class="modal-body"
                id="helperBody"
                data-es="<?= htmlspecialchars($helper_body_es) ?>"
                data-en="<?= htmlspecialchars($helper_body_en) ?>">
                <?= $idioma === 'eng' ? $helper_body_en : $helper_body_es ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
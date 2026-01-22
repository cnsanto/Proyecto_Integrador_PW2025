<?php

/**
 * Footer component for FutMatch
 * Includes "Back to original site" button and contact icons
 */
?>
<footer class="futmatch-footer">
    <div class="container">
        <div class="footer-content">
            <!-- Back to original site button -->
            <a href="<?= BASE_URL ?>../../index.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Volver al sitio original
            </a>

            <!-- Contact icons -->
            <div class="footer-socials">
                <a href="https://wa.link/hzrlh7" target="_blank" title="WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                </a>
                <a href="https://www.linkedin.com/in/camila-natalia-santo/" target="_blank" title="LinkedIn">
                    <i class="bi bi-linkedin"></i>
                </a>
                <a href="https://github.com/cnsanto" target="_blank" title="GitHub">
                    <i class="bi bi-github"></i>
                </a>
                <a href="javascript:void(0);" class="copy-email-footer" data-email="cnsanto@gmail.com" title="Email">
                    <i class="bi bi-envelope-fill"></i>
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-copyright">
            <p class="mb-0">&copy; <?= date('Y') ?> Camila Natalia Santo. FutMatch - Proyecto Integrador PW2025</p>
        </div>
    </div>
</footer>

<script>
    // Email copy functionality for footer
    document.addEventListener('DOMContentLoaded', function() {
        const copyBtn = document.querySelector('.copy-email-footer');
        if (copyBtn) {
            copyBtn.addEventListener('click', function() {
                const email = this.dataset.email;
                navigator.clipboard.writeText(email).then(() => {
                    // Show toast if available
                    if (window.showToast) {
                        window.showToast('Email copiado: ' + email, 'success', 2000);
                    } else {
                        alert('Email copiado: ' + email);
                    }
                });
            });
        }
    });
</script>
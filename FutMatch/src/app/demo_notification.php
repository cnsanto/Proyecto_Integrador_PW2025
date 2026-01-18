<?php

/**
 * Demo Mode Notification Component
 * ----------------------------------
 * Include this component in pages where you want to show a notification
 * to users when they're in demo mode.
 * 
 * Usage: include this AFTER the toast.js script is loaded
 */

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is in demo mode
if (isset($_SESSION['is_demo'])):
    $demoMode = $_SESSION['is_demo'];
    $isStatic = ($demoMode === 'static');
?>
    <script>
        // Show demo mode notification when page loads
        document.addEventListener('DOMContentLoaded', function() {
            if (window.showToast) {
                <?php if ($isStatic): ?>
                    window.showToast(
                        '⚠️ Estás en modo DEMO (solo lectura). No podrás modificar datos.',
                        'warning',
                        5000
                    );
                <?php else: ?>
                    window.showToast(
                        'ℹ️ Esta es una cuenta demo temporal. Tus datos serán eliminados en 24 horas.',
                        'info',
                        5000
                    );
                <?php endif; ?>
            }
        });
    </script>
<?php endif; ?>
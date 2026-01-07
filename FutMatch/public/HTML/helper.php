<?php

/**
 * Helper Component
 * ----------------
 * Renders a floating "Help" button that opens a modal with instructions or details about the current page.
 * 
 * Usage:
 * 1. Define $helper_content string before including this component.
 *    $helper_content = "<p>This is how you use this page...</p>";
 * 2. include HELPER_COMPONENT;
 */

// Default content if not defined
$content = isset($helper_content) ? $helper_content : "No instruction available for this page.";
$title = isset($helper_title) ? $helper_title : "Page Guide";
?>

<!-- Floating Helper Button -->
<div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1050;">
    <button type="button" class="btn btn-primary rounded-circle shadow-lg p-3" data-bs-toggle="modal" data-bs-target="#helperModal" title="Help / Guide">
        <i class="bi bi-question-lg fs-3"></i>
    </button>
</div>

<!-- Helper Modal -->
<div class="modal fade" id="helperModal" tabindex="-1" aria-labelledby="helperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content text-dark"> <!-- Added text-dark to ensure readability if parent theme is dark -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="helperModalLabel">
                    <i class="bi bi-info-circle-fill me-2"></i><?= $title ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-white">
                <?= $content ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
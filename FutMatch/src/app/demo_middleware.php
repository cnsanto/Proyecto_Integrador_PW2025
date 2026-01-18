<?php

/**
 * Demo Middleware
 * ---------------
 * Include this file at the top of any controller that performs write operations
 * to prevent demo static accounts from modifying data.
 * 
 * Usage:
 * require_once __DIR__ . '/../app/demo_middleware.php';
 */

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is in static demo mode
if (isset($_SESSION['is_demo']) && $_SESSION['is_demo'] === 'static') {
    error_log("[DEMO_MIDDLEWARE] Blocked write operation for static demo user: " . ($_SESSION['email'] ?? 'unknown'));

    // Return JSON error for AJAX requests
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Las cuentas demo en modo estático no pueden modificar datos. Para probar las funcionalidades completas, utiliza el modo dinámico.'
    ]);
    exit();
}

// For dynamic demo accounts, allow all operations (they can modify data normally)

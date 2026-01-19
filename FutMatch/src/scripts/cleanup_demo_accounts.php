<?php

/**
 * Cleanup Demo Accounts Script
 * -----------------------------
 * Deletes expired dynamic demo accounts from the database.
 * Run this script periodically via cron job or manually.
 * 
 * Example cron (runs daily at 3 AM):
 * 0 3 * * * /usr/bin/php /path/to/cleanup_demo_accounts.php
 */

require_once __DIR__ . '/../app/config.php';

// Log start
$startTime = date('Y-m-d H:i:s');
echo "[CLEANUP] Starting demo account cleanup at $startTime\n";
error_log("[CLEANUP] Starting demo account cleanup at $startTime");

//primero borramos los participantes / equipos
try {
    $querySelect = "SELECT FROM usuarios
                    WHERE tipo_demo = 'dynamic'
                    AND demo_expiracion < NOW ()";

    $stmtSelect = $conn->prepare($querySelect);
    $stmtSelect->execute();
    $resultSelect = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultSelect as $row) {
        $idUsuario = $row['id_usuario'];
        $queryDelete = "DELETE FROM jugadores_equipos
                        WHERE id_usuario = :id_usuario";

        $stmtDelete = $conn->prepare($queryDelete);
        $stmtDelete->execute(['id_usuario' => $idUsuario]);
    }

    try {
        // Delete expired dynamic demo accounts
        $query = "DELETE FROM usuarios 
              WHERE tipo_demo = 'dynamic' 
              AND demo_expiracion < NOW()";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $deletedCount = $stmt->rowCount();

        // Log result
        $endTime = date('Y-m-d H:i:s');
        $message = "[CLEANUP] Deleted $deletedCount expired demo accounts at $endTime";
        echo "$message\n";
        error_log($message);

        // Optional: Clean up orphaned jugadores entries
        if ($deletedCount > 0) {
            $cleanupJugadores = "DELETE FROM " . TABLE_JUGADORES . " 
                            WHERE id_jugador NOT IN (SELECT id_usuario FROM " . TABLE_USUARIOS . ")";
            $stmtClean = $conn->prepare($cleanupJugadores);
            $stmtClean->execute();
            $cleanedJugadores = $stmtClean->rowCount();

            if ($cleanedJugadores > 0) {
                echo "[CLEANUP] Cleaned up $cleanedJugadores orphaned jugador entries\n";
                error_log("[CLEANUP] Cleaned up $cleanedJugadores orphaned jugador entries");
            }
        }
    } catch (PDOException $e) {
        $errorMessage = "[CLEANUP] Error: " . $e->getMessage();
        echo "$errorMessage\n";
        error_log($errorMessage);
        exit(1);
    }
} catch (PDOException $e) {
    $errorMessage = "[CLEANUP] Error: " . $e->getMessage();
    echo "$errorMessage\n";
    error_log($errorMessage);
    exit(1);
}
echo "[CLEANUP] Cleanup completed successfully\n";
exit(0);

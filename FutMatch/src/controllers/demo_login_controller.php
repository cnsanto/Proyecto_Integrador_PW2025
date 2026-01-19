<?php

/**
 * Demo Login Controller
 * ---------------------
 * Handles automatic login for demo accounts (both static and dynamic modes).
 * 
 * Static mode: Logs in with pre-configured read-only demo accounts
 * Dynamic mode: Creates temporary demo account with incremental username
 */

require_once '../../src/app/config.php';

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Get parameters
$role = $_POST['role'] ?? '';
$mode = $_POST['mode'] ?? 'dynamic';

error_log("[DEMO_LOGIN] Starting demo login");
error_log("[DEMO_LOGIN] Role: $role");
error_log("[DEMO_LOGIN] Mode: $mode");

// Validate role
$validRoles = ['jugador', 'admin_cancha', 'admin_sistema'];
if (!in_array($role, $validRoles)) {
    error_log("[DEMO_LOGIN] Invalid role: $role");
    echo json_encode(['success' => false, 'message' => 'Rol inválido']);
    exit();
}

try {
    // Only dynamic mode now
    error_log("[DEMO_LOGIN] Creating dynamic demo account for role: $role");
    loginDynamicDemo($role, $conn);
} catch (Exception $e) {
    error_log("[DEMO_LOGIN] Error: " . $e->getMessage());
    error_log("[DEMO_LOGIN] Stack trace: " . $e->getTraceAsString());
    echo json_encode(['success' => false, 'message' => 'Error al iniciar sesión demo: ' . $e->getMessage()]);
    exit();
}

/**
 * Create and login with dynamic demo account
 */
function loginDynamicDemo($role, $conn)
{
    error_log("[DEMO_LOGIN] Starting loginDynamicDemo for role: $role");

    // Find next available demo number
    $prefix = "demo_{$role}_";
    $query = "SELECT j.username 
              FROM jugadores j 
              WHERE j.username LIKE :pattern 
              ORDER BY j.id_jugador DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute(['pattern' => $prefix . '%@demo.com']);
    $lastUser = $stmt->fetch();

    error_log("[DEMO_LOGIN] Last user query result: " . ($lastUser ? $lastUser['username'] : 'none'));

    $nextNumber = 1;
    if ($lastUser) {
        // Extract number from last username
        preg_match('/demo_' . $role . '_(\d+)/', $lastUser['username'], $matches);
        if (isset($matches[1])) {
            $nextNumber = (int)$matches[1] + 1;
        }
    }

    error_log("[DEMO_LOGIN] Next number: $nextNumber");

    $username = $prefix . $nextNumber;
    $email = $username . '@demo.com';
    $nombre = 'Demo';
    $apellido = ucfirst($role) . ' ' . $nextNumber;

    error_log("[DEMO_LOGIN] Creating user: $username ($email)");

    // Password: demo2026
    $password = password_hash('demo2026', PASSWORD_DEFAULT);

    // Expiration: 24 hours from now
    $expiration = date('Y-m-d H:i:s', time() + (24 * 60 * 60));

    error_log("[DEMO_LOGIN] Expiration: $expiration");

    // Create user
    $queryUser = "INSERT INTO usuarios
                  (nombre, apellido, email, password, id_estado, tipo_demo, demo_expiracion) 
                  VALUES (:nombre, :apellido, :email, :password, 1, 'dynamic', :expiration)";

    error_log("[DEMO_LOGIN] Executing user insert query...");
    try {
        $stmtUser = $conn->prepare($queryUser);
        $stmtUser->execute([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'password' => $password,
            'expiration' => $expiration
        ]);

        $userId = $conn->lastInsertId();
        error_log("[DEMO_LOGIN] User created with ID: $userId");
    } catch (PDOException $e) {
        error_log("[DEMO_LOGIN] Failed to create user: " . $e->getMessage());
        throw $e;
    }

    // Assign role
    $roleIds = [
        'jugador' => 1,
        'admin_cancha' => 2,
        'admin_sistema' => 3
    ];

    error_log("[DEMO_LOGIN] Assigning role ID: " . $roleIds[$role]);
    $queryRole = "INSERT INTO usuarios_roles (id_usuario, id_rol) VALUES (:user_id, :role_id)";
    try {
        $stmtRole = $conn->prepare($queryRole);
        $stmtRole->execute([
            'user_id' => $userId,
            'role_id' => $roleIds[$role]
        ]);
        error_log("[DEMO_LOGIN] Role assigned successfully");
    } catch (PDOException $e) {
        error_log("[DEMO_LOGIN] Failed to assign role: " . $e->getMessage());
        throw $e;
    }

    // If jugador, create jugador entry
    if ($role === 'jugador') {
        error_log("[DEMO_LOGIN] Creating jugador profile...");
        $queryJugador = "INSERT INTO jugadores
                        (id_jugador, username, telefono, fecha_nacimiento, id_sexo) 
                        VALUES (:id, :username, '1100000000', '1990-01-01', 1)";
        try {
            $stmtJugador = $conn->prepare($queryJugador);
            $stmtJugador->execute([
                'id' => $userId,
                'username' => $username
            ]);
            error_log("[DEMO_LOGIN] Jugador profile created");
        } catch (PDOException $e) {
            error_log("[DEMO_LOGIN] Failed to create jugador profile: " . $e->getMessage());
            throw $e;
        }
    }

    // AGREGAR EQUIPOS
    if ($role === 'jugador') {
        error_log("[DEMO_LOGIN] Creating equipo profile...");
        $queryEquipo = "INSERT INTO equipos
                        (id_lider, nombre, foto, abierto, descripcion, creado_por)
                        VALUES (:user_id, 'HUDSON FC', 'uploads/equipos/equipo_1768451742_69686e9e0b18f.png', 1, 'Football Amateur', :user_id)";
        try {
            $stmtEquipo = $conn->prepare($queryEquipo);
            $stmtEquipo->execute([
                'user_id' => $userId
            ]);
            error_log("[DEMO_LOGIN] Equipo profile created");
            $equipoId = $conn->lastInsertId();
            $queryParticipantes = "INSERT INTO jugadores_equipos
                                    (id_jugador, id_equipo, estado_solicitud, invitado_por)
                                    VALUES
                                    (:user_id, :id_equipo, 3),
                                    (:user_id, 25, 1, 36),
                                    (:user_id, 2, 3, 3);";
            try {
                $stmtParticipantes = $conn->prepare($queryParticipantes);
                $stmtParticipantes->execute([
                    'user_id' => $userId,
                    'id_equipo' => $equipoId
                ]);
                error_log("[DEMO_LOGIN] Jugador added to equipo");
            } catch (PDOException $e) {
                error_log("[DEMO_LOGIN] Failed to add jugador to equipo: " . $e->getMessage());
                throw $e;
            }
        } catch (PDOException $e) {
            error_log("[DEMO_LOGIN] Failed to create equipo profile: " . $e->getMessage());
            throw $e;
        }
    }



    // Set session
    error_log("[DEMO_LOGIN] Setting up session...");
    $_SESSION['user_id'] = $userId;
    $_SESSION['email'] = $email;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellido'] = $apellido;
    $_SESSION['user_type'] = $role;
    $_SESSION['is_demo'] = 'dynamic';

    error_log("[DEMO_LOGIN] Dynamic demo created and logged in: $email (expires: $expiration)");

    // Force session write
    session_write_close();

    // Determine redirect URL based on role
    $redirectUrls = [
        'jugador' => PAGE_INICIO_JUGADOR,
        'admin_cancha' => PAGE_INICIO_ADMIN_CANCHA,
        'admin_sistema' => PAGE_INICIO_ADMIN_SISTEMA
    ];

    $redirectUrl = $redirectUrls[$role] ?? PAGE_INICIO_JUGADOR;
    error_log("[DEMO_LOGIN] Redirect URL: $redirectUrl");
    error_log("[DEMO_LOGIN] Sending success response");

    echo json_encode([
        'success' => true,
        'message' => 'Cuenta demo temporal creada',
        'mode' => 'dynamic',
        'user_type' => $role,
        'username' => $username,
        'expiration' => $expiration,
        'redirect_url' => $redirectUrl
    ]);
    exit();
}

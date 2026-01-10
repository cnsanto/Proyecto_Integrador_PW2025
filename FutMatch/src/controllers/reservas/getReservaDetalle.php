<?php

/**
 * Controller: getReservaDetalle.php
 * Obtiene el detalle completo de una reserva específica
 * Usa la vista vista_reserva_detalle para datos completos
 */

require_once '../../app/config.php';

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

// Validar que haya sesión iniciada
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'No hay sesión iniciada'
    ]);
    exit;
}

try {
    // Validar que se reciba el id_reserva
    if (!isset($_GET['id_reserva']) || empty($_GET['id_reserva'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Falta el parámetro id_reserva'
        ]);
        exit;
    }

    $id_reserva = intval($_GET['id_reserva']);
    $id_usuario = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'] ?? null;

    // Obtener el detalle de la reserva desde la vista
    $stmt = $conn->prepare("SELECT 
        r.id_reserva,
        r.id_cancha,
        r.id_tipo_reserva,
        r.fecha,
        r.fecha_fin,
        r.hora_inicio,
        r.hora_fin,
        r.titulo,
        r.descripcion,
        r.id_estado,
        r.fecha_solicitud,

        -- Creador de la reserva (admin que la creó)
        r.id_creador_usuario,
        u_creador.nombre AS nombre_creador,
        u_creador.apellido AS apellido_creador,
        CONCAT(u_creador.nombre, ' ', u_creador.apellido) AS creador_nombre_completo,
        
        -- Titular de la reserva (jugador o persona externa)
        r.id_titular_jugador,
        r.id_titular_externo,
        
        -- Datos del titular si es jugador
        j_titular.username AS username_titular,
        u_titular.nombre AS nombre_titular_jugador,
        u_titular.apellido AS apellido_titular_jugador,
        j_titular.telefono AS telefono_titular_jugador,
        CONCAT(u_titular.nombre, ' ', u_titular.apellido) AS titular_jugador_nombre_completo,
        
        -- Datos del titular si es persona externa
        pe.nombre AS nombre_titular_externo,
        pe.apellido AS apellido_titular_externo,
        pe.telefono AS telefono_titular_externo,
        CONCAT(pe.nombre, ' ', pe.apellido) AS titular_externo_nombre_completo,
        
        -- Nombre completo del titular (jugador o externo)
        CASE
            WHEN r.id_titular_jugador IS NOT NULL THEN CONCAT(u_titular.nombre, ' ', u_titular.apellido)
            WHEN r.id_titular_externo IS NOT NULL THEN CONCAT(pe.nombre, ' ', pe.apellido)
            ELSE 'Sin titular'
        END AS titular_nombre_completo,
        
        -- Teléfono del titular (jugador o externo)
        COALESCE(j_titular.telefono, pe.telefono) AS titular_telefono,
        
        -- Indicador de tipo de reserva
        CASE
            WHEN r.id_titular_jugador IS NOT NULL THEN 'jugador'
            WHEN r.id_titular_externo IS NOT NULL THEN 'externo'
            ELSE NULL
        END AS tipo_titular,

        tr.nombre AS tipo_reserva,
        tr.descripcion AS descripcion_tipo_reserva,
        e.nombre AS estado_reserva,
        c.nombre AS nombre_cancha,
        c.descripcion AS descripcion_cancha
    
    FROM reservas r
    INNER JOIN tipos_reserva tr ON r.id_tipo_reserva = tr.id_tipo_reserva
    INNER JOIN estados_solicitudes e ON r.id_estado = e.id_estado
    INNER JOIN usuarios u_creador ON r.id_creador_usuario = u_creador.id_usuario
    INNER JOIN canchas c ON r.id_cancha = c.id_cancha
    LEFT JOIN jugadores j_titular ON r.id_titular_jugador = j_titular.id_jugador
    LEFT JOIN usuarios u_titular ON j_titular.id_jugador = u_titular.id_usuario
    LEFT JOIN personas_externas pe ON r.id_titular_externo = pe.id_externo

    WHERE id_reserva = :id_reserva");

    $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
    $stmt->execute();
    $reserva = $stmt->fetch();

    if (!$reserva) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Reserva no encontrada'
        ]);
        exit;
    }

    // Verificar permisos según tipo de usuario
    if ($user_type === 'admin_cancha') {
        // Admin: verificar que la cancha le pertenece
        $stmt = $conn->prepare("SELECT id_admin_cancha FROM canchas WHERE id_cancha = :id_cancha");
        $stmt->bindParam(':id_cancha', $reserva['id_cancha'], PDO::PARAM_INT);
        $stmt->execute();
        $cancha = $stmt->fetch();

        if (!$cancha || $cancha['id_admin_cancha'] != $id_usuario) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'No tienes permisos para ver esta reserva'
            ]);
            exit;
        }
    } elseif ($user_type === 'jugador') {
        // Jugador: solo puede ver si es titular o creador
        if ($reserva['id_titular_jugador'] != $id_usuario && $reserva['id_creador_usuario'] != $id_usuario) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'No tienes permisos para ver esta reserva'
            ]);
            exit;
        }

        // Verificar que la reserva está confirmada (id_estado = 6)
        if ($reserva['id_estado'] != 6) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Solo puedes ver reservas confirmadas'
            ]);
            exit;
        }
    }

    echo json_encode([
        'success' => true,
        'reserva' => $reserva
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener el detalle de la reserva',
        'error' => $e->getMessage()
    ]);
}

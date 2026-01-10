<?php

/**
 * Controller: getReservas.php
 * Obtiene todas las reservas de una cancha específica
 * Usa la vista vista_reservas para datos completos
 */

require_once '../../app/config.php';

// Iniciar sesión si no está iniciada (opcional para vista pública)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

try {
    // Validar que se reciba el id_cancha
    if (!isset($_GET['id_cancha']) || empty($_GET['id_cancha'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Falta el parámetro id_cancha'
        ]);
        exit;
    }

    $id_cancha = intval($_GET['id_cancha']);
    $id_usuario = $_SESSION['user_id'] ?? null;
    $user_type = $_SESSION['user_type'] ?? null;

    // Verificar que la cancha existe
    $stmt = $conn->prepare("SELECT id_admin_cancha FROM canchas WHERE id_cancha = :id_cancha");
    $stmt->bindParam(':id_cancha', $id_cancha, PDO::PARAM_INT);
    $stmt->execute();
    $cancha = $stmt->fetch();

    if (!$cancha) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Cancha no encontrada'
        ]);
        exit;
    }

    // Si es admin de cancha, verificar permisos
    if ($user_type === 'admin_cancha' && $cancha['id_admin_cancha'] != $id_usuario) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'No tienes permisos para ver las reservas de esta cancha'
        ]);
        exit;
    }

    // Si es jugador o usuario no logueado, mostrar solo horarios ocupados (reservas confirmadas)
    if ($user_type === 'jugador' || $user_type === null) {
        // Solo mostrar fecha, hora_inicio, hora_fin de reservas confirmadas (id_estado = 6)
        // Y datos completos si es titular o creador (solo si hay sesión)
        if ($id_usuario) {
            $stmt = $conn->prepare("SELECT 
                    r.id_reserva,
                    r.fecha,
                    r.fecha_fin,
                    r.hora_inicio,
                    r.hora_fin,
                    r.id_estado,
                    e.nombre AS estado_reserva,
                    c.id_cancha,
                    CASE 
                        WHEN (r.id_titular_jugador = :id_usuario OR r.id_creador_usuario = :id_usuario) 
                        THEN r.titulo
                        ELSE NULL 
                    END as titulo,
                    CASE 
                        WHEN (r.id_titular_jugador = :id_usuario OR r.id_creador_usuario = :id_usuario) 
                        THEN r.descripcion
                        ELSE NULL 
                    END as descripcion,
                    CASE 
                        WHEN (r.id_titular_jugador = :id_usuario OR r.id_creador_usuario = :id_usuario) 
                        THEN r.tipo_reserva
                        ELSE NULL 
                    END as tipo_reserva,
                    CASE
                        WHEN (r.id_titular_jugador = :id_usuario 
                            OR r.id_creador_usuario = :id_usuario)
                        THEN
                            CASE
                                WHEN r.id_titular_jugador IS NOT NULL 
                                    THEN CONCAT(u_titular.nombre, ' ', u_titular.apellido)
                                WHEN r.id_titular_externo IS NOT NULL 
                                    THEN CONCAT(pe.nombre, ' ', pe.apellido)
                                ELSE 'Sin titular'
                            END
                        ELSE NULL
                    END AS titular_nombre_completo,

                    -- Indicador de propiedad
                    CASE 
                        WHEN r.id_titular_jugador = :id_usuario THEN true
                        ELSE false 
                    END as es_mi_reserva
                
                FROM reservas r
                INNER JOIN tipos_reserva tr ON r.id_tipo_reserva = tr.id_tipo_reserva
                INNER JOIN estados_solicitudes e ON r.id_estado = e.id_estado
                INNER JOIN usuarios u_creador ON r.id_creador_usuario = u_creador.id_usuario
                INNER JOIN canchas c ON r.id_cancha = c.id_cancha
                LEFT JOIN jugadores j_titular ON r.id_titular_jugador = j_titular.id_jugador
                LEFT JOIN usuarios u_titular ON j_titular.id_jugador = u_titular.id_usuario
                LEFT JOIN personas_externas pe ON r.id_titular_externo = pe.id_externo;

                WHERE id_cancha = :id_cancha 
                AND id_estado = 6
                ORDER BY fecha, hora_inicio
            ");
            $stmt->bindParam(':id_cancha', $id_cancha, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        } else {
            // Usuario no logueado: solo mostrar horarios ocupados sin datos sensibles
            $stmt = $conn->prepare("SELECT 
                    r.id_reserva,
                    r.fecha,
                    r.fecha_fin,
                    r.hora_inicio,
                    r.hora_fin, 
                    r.id_estado,
                    e.nombre AS estado_reserva,
                    c.id_cancha
                FROM reservas r
                INNER JOIN estados_solicitudes e ON r.id_estado = e.id_estado
                INNER JOIN canchas c ON r.id_cancha = c.id_cancha

                WHERE id_cancha = :id_cancha 
                AND id_estado = 6
                ORDER BY fecha, hora_inicio
            ");
            $stmt->bindParam(':id_cancha', $id_cancha, PDO::PARAM_INT);
        }
    } else {
        // Admin ve todas las reservas con todos los datos
        $stmt = $conn->prepare("SELECT 
                    r.id_reserva,
                    r.fecha,
                    r.fecha_fin,
                    r.hora_inicio,
                    r.hora_fin,
                    r.titulo,
                    r.descripcion,
    
                    r.id_tipo_reserva,
                    tr.nombre AS tipo_reserva,

                    r.id_estado,
                    e.nombre AS estado_reserva,
    
                    -- Creador de la reserva (admin que la creó)
                    r.id_creador_usuario,
                    u_creador.nombre AS nombre_creador,
                    u_creador.apellido AS apellido_creador,
    
                    -- Titular de la reserva (jugador o persona externa)
                    r.id_titular_jugador,
                    r.id_titular_externo,
    
                    -- Datos del titular si es jugador
                    j_titular.username AS username_titular,
                    u_titular.nombre AS nombre_titular_jugador,
                    u_titular.apellido AS apellido_titular_jugador,
                    j_titular.telefono AS telefono_titular_jugador,
    
                    -- Datos del titular si es persona externa
                    pe.nombre AS nombre_titular_externo,
                    pe.apellido AS apellido_titular_externo,
                    pe.telefono AS telefono_titular_externo,
    
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
    
                    c.id_cancha,
                    c.nombre AS nombre_cancha

                FROM reservas r
                INNER JOIN tipos_reserva tr ON r.id_tipo_reserva = tr.id_tipo_reserva
                INNER JOIN estados_solicitudes e ON r.id_estado = e.id_estado
                INNER JOIN usuarios u_creador ON r.id_creador_usuario = u_creador.id_usuario
                INNER JOIN canchas c ON r.id_cancha = c.id_cancha
                LEFT JOIN jugadores j_titular ON r.id_titular_jugador = j_titular.id_jugador
                LEFT JOIN usuarios u_titular ON j_titular.id_jugador = u_titular.id_usuario
                LEFT JOIN personas_externas pe ON r.id_titular_externo = pe.id_externo 
                
                WHERE id_cancha = :id_cancha 
                ORDER BY fecha, hora_inicio");

        $stmt->bindParam(':id_cancha', $id_cancha, PDO::PARAM_INT);
    }

    $stmt->execute();
    $reservas = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'reservas' => $reservas
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener las reservas',
        'error' => $e->getMessage()
    ]);
}

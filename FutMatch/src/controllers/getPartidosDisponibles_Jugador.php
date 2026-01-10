<?php
// Habilitar display de errores para debugging (QUITAR EN PRODUCCIÓN)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../app/config.php';

// Configurar salida JSON desde el inicio
header('Content-Type: application/json');

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    // Verificar si hay usuario autenticado
    $id_jugador = null;
    if (isset($_SESSION['user_id'])) {
        $id_jugador = $_SESSION['user_id'];
        error_log("GET_PARTIDOS: id_jugador de sesión: " . $id_jugador);
    } else {
        error_log("GET_PARTIDOS: Modo guest - sin sesión activa");
    }

    // Construir query según si hay usuario autenticado
    if ($id_jugador) {
        // Excluir partidos en los que ya participa el jugador
        $query = "SELECT 
        -- Información del partido
        p.id_partido,
        p.id_anfitrion,
        p.abierto,
        p.id_reserva,
    
        -- Información de la reserva
        r.fecha AS fecha_partido,
        DATE_FORMAT(r.fecha, '%d/%m/%Y') AS fecha_partido_formato,
        CASE DAYOFWEEK(r.fecha)
            WHEN 1 THEN 'Domingo'
            WHEN 2 THEN 'Lunes'
            WHEN 3 THEN 'Martes'
            WHEN 4 THEN 'Miércoles'
            WHEN 5 THEN 'Jueves'
            WHEN 6 THEN 'Viernes'
            WHEN 7 THEN 'Sábado'
        END as dia_semana,
        TIME_FORMAT(r.hora_inicio, '%H:%i') as hora_inicio,
        TIME_FORMAT(r.hora_fin, '%H:%i') as hora_fin,
        r.hora_inicio as hora_inicio_raw,
        r.titulo,
        r.descripcion,
        r.id_tipo_reserva,
    
        -- Información de la cancha
        c.id_cancha,
        c.nombre AS nombre_cancha,
        c.foto AS foto_cancha,
    
        -- Dirección de la cancha
        d.direccion_completa,
        d.latitud,
        d.longitud,
    
        -- Información del tipo de partido
        tp.id_tipo_partido,
        tp.nombre AS tipo_partido,
        tp.min_participantes,
        tp.max_participantes,
    
        -- Superficie de la cancha
        s.nombre AS tipo_superficie,
    
        -- Información del anfitrión
        j_anfitrion.id_jugador AS id_jugador_anfitrion,
        j_anfitrion.username AS username_anfitrion,
    
        -- Cantidad de participantes actual
        (SELECT COUNT(*) 
            FROM participantes_partidos pp 
            WHERE pp.id_partido = p.id_partido) AS participantes_actuales,

        -- Cantidad de participantes en pp.equipo=1
        (SELECT COUNT(*)
            FROM participantes_partidos pp 
            WHERE pp.id_partido = p.id_partido AND pp.equipo = 1) AS cant_participantes_equipo_A,

        -- Cantidad de participantes en pp.equipo=2
        (SELECT COUNT(*)
            FROM participantes_partidos pp 
            WHERE pp.id_partido = p.id_partido AND pp.equipo = 2) AS cant_participantes_equipo_B

    FROM partidos p

    -- Unir con reservas para obtener fecha, hora y cancha
    INNER JOIN reservas r ON p.id_reserva = r.id_reserva

    -- Unir con canchas
    INNER JOIN canchas c ON r.id_cancha = c.id_cancha

    -- Unir con direcciones
    INNER JOIN direcciones d ON c.id_direccion = d.id_direccion

    -- Unir con tipo de partido
    INNER JOIN tipos_partido tp ON p.id_tipo_partido = tp.id_tipo_partido

    -- Unir con superficie de cancha
    INNER JOIN superficies_canchas s ON c.id_superficie = s.id_superficie

    -- Información del anfitrión
    INNER JOIN jugadores j_anfitrion ON p.id_anfitrion = j_anfitrion.id_jugador

    -- Condiciones: solo partidos abiertos y futuros
    WHERE p.abierto = 1 
        AND r.fecha >= CURDATE()
        AND r.id_tipo_reserva = 1 -- Solo partidos (no torneos)
        AND  id_partido NOT IN (
                      SELECT id_partido FROM participantes_partidos WHERE id_jugador = :id_jugador
                  )

    ORDER BY r.fecha ASC, r.hora_inicio ASC ";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_jugador', $id_jugador, PDO::PARAM_INT);
    } else {
        // Modo guest: mostrar todos los partidos disponibles
        $query = "SELECT -- Información del partido
            p.id_partido,
            p.id_anfitrion,
            p.abierto,
            p.id_reserva,
    
            -- Información de la reserva
            r.fecha AS fecha_partido,
            DATE_FORMAT(r.fecha, '%d/%m/%Y') AS fecha_partido_formato,
            CASE DAYOFWEEK(r.fecha)
                WHEN 1 THEN 'Domingo'
                WHEN 2 THEN 'Lunes'
                WHEN 3 THEN 'Martes'
                WHEN 4 THEN 'Miércoles'
                WHEN 5 THEN 'Jueves'
                WHEN 6 THEN 'Viernes'
                WHEN 7 THEN 'Sábado'
            END as dia_semana,
            TIME_FORMAT(r.hora_inicio, '%H:%i') as hora_inicio,
            TIME_FORMAT(r.hora_fin, '%H:%i') as hora_fin,
            r.hora_inicio as hora_inicio_raw,
            r.titulo,
            r.descripcion,
            r.id_tipo_reserva,
    
            -- Información de la cancha
            c.id_cancha,
            c.nombre AS nombre_cancha,
            c.foto AS foto_cancha,
    
            -- Dirección de la cancha
            d.direccion_completa,
            d.latitud,
            d.longitud,
    
            -- Información del tipo de partido
            tp.id_tipo_partido,
            tp.nombre AS tipo_partido,
            tp.min_participantes,
            tp.max_participantes,
    
            -- Superficie de la cancha
            s.nombre AS tipo_superficie,
    
            -- Información del anfitrión
            j_anfitrion.id_jugador AS id_jugador_anfitrion,
            j_anfitrion.username AS username_anfitrion,
    
            -- Cantidad de participantes actual
            (SELECT COUNT(*) 
            FROM participantes_partidos pp 
            WHERE pp.id_partido = p.id_partido) AS participantes_actuales,

            -- Cantidad de participantes en pp.equipo=1
            (SELECT COUNT(*)
            FROM participantes_partidos pp 
            WHERE pp.id_partido = p.id_partido AND pp.equipo = 1) AS cant_participantes_equipo_A,

            -- Cantidad de participantes en pp.equipo=2
            (SELECT COUNT(*)
            FROM participantes_partidos pp 
            WHERE pp.id_partido = p.id_partido AND pp.equipo = 2) AS cant_participantes_equipo_B

        FROM partidos p

        -- Unir con reservas para obtener fecha, hora y cancha
        INNER JOIN reservas r ON p.id_reserva = r.id_reserva

        -- Unir con canchas
        INNER JOIN canchas c ON r.id_cancha = c.id_cancha

        -- Unir con direcciones
        INNER JOIN direcciones d ON c.id_direccion = d.id_direccion

        -- Unir con tipo de partido
        INNER JOIN tipos_partido tp ON p.id_tipo_partido = tp.id_tipo_partido

        -- Unir con superficie de cancha
        INNER JOIN superficies_canchas s ON c.id_superficie = s.id_superficie

        -- Información del anfitrión
        INNER JOIN jugadores j_anfitrion ON p.id_anfitrion = j_anfitrion.id_jugador

        -- Condiciones: solo partidos abiertos y futuros
        WHERE p.abierto = 1 
        AND r.fecha >= CURDATE()
        AND r.id_tipo_reserva = 1 -- Solo partidos (no torneos)

        ORDER BY r.fecha ASC, r.hora_inicio ASC";
        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    $partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("GET_PARTIDOS: Partidos obtenidos: " . count($partidos));

    echo json_encode($partidos);
} catch (PDOException $e) {
    error_log("GET_PARTIDOS ERROR PDO: " . $e->getMessage());
    error_log("GET_PARTIDOS ERROR TRACE: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al obtener partidos',
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
} catch (Exception $e) {
    error_log("GET_PARTIDOS ERROR GENERAL: " . $e->getMessage());
    error_log("GET_PARTIDOS ERROR TRACE: " . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode([
        'error' => 'Error inesperado',
        'message' => $e->getMessage()
    ]);
}

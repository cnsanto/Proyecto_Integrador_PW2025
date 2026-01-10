<?php
require_once '../app/config.php';

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}


$id_jugador = $_SESSION['user_id'];
$query =
    'SELECT 
        e.id_equipo,
        e.id_lider,
        -- agregar nombre del lider
        e.nombre AS nombre_equipo,
        e.foto AS foto_equipo,
        e.abierto,
        e.clave,
        e.descripcion,

        u.nombre AS nombre_lider,
        u.apellido AS apellido_lider,

        -- Cantidad de integrantes del equipo
        (SELECT COUNT(*) 
         FROM jugadores_equipos je 
         WHERE je.id_equipo = e.id_equipo
         AND je.estado_solicitud = 3) AS cantidad_integrantes,
         je.id_jugador,
         je.estado_solicitud,

        -- Cantidad de torneos participados por el equipo
        (SELECT COUNT(DISTINCT t.id_torneo)
         FROM torneos t
         INNER JOIN equipos_torneos et ON t.id_torneo = et.id_torneo
         WHERE et.id_equipo = e.id_equipo) AS torneos_participados,

        -- Cantidad de partidos jugados por el equipo
        (SELECT COUNT(*) 
         FROM equipos_partidos ep
         WHERE ep.id_equipo = e.id_equipo) AS partidos_jugados

    FROM equipos e
    INNER JOIN usuarios u ON e.id_lider = u.id_usuario
    INNER JOIN jugadores_equipos je ON e.id_equipo = je.id_equipo 
    WHERE id_jugador = :id 
    ORDER BY nombre_equipo ASC';

$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id_jugador);
$stmt->execute();
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($equipos);

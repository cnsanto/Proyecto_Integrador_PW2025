<?php
require_once '../app/config.php';


// Iniciar sesión (opcional para perfiles públicos)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* PERFIL JUGADOR
vista_perfil_jugador

PERFIL CANCHA
vista_perfil_cancha

NOTA: Los perfiles son públicos y no requieren autenticación
*/

$query = '';

try {

    if (isset($_GET['tipo']) && $_GET['tipo'] === 'cancha') {
        // Perfil cancha
        $id_cancha = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_cancha <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de cancha inválido']);
            exit();
        }

        $query = "SELECT
            c.id_cancha,
            c.nombre AS nombre_cancha,
            c.descripcion AS descripcion_cancha,
            c.foto AS foto_cancha,
            c.banner AS banner_cancha,
            c.politicas_reservas AS politicas_reservas,
            e.nombre AS estado_cancha,
            d.direccion_completa AS direccion_cancha,
            d.latitud AS latitud_cancha,
            d.longitud AS longitud_cancha,
            s.nombre AS tipo_superficie
        FROM canchas c
        INNER JOIN estados_canchas e ON c.id_estado = e.id_estado
        INNER JOIN direcciones d ON c.id_direccion = d.id_direccion
        INNER JOIN superficies_canchas s ON c.id_superficie = s.id_superficie
        WHERE id_cancha = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id_cancha, PDO::PARAM_INT);
        $stmt->execute();
        $perfil = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$perfil) {
            http_response_code(404);
            echo json_encode(['error' => 'Perfil no encontrado']);
            exit();
        }

        // Obtener tipos de partido de la cancha
        $queryTipos = "
            SELECT 
                tp.id_tipo_partido,
                tp.nombre,
                tp.min_participantes,
                tp.max_participantes
            FROM canchas_tipos_partido ctp
            INNER JOIN tipos_partido tp 
                ON tp.id_tipo_partido = ctp.id_tipo_partido
            WHERE ctp.id_cancha = :id AND ctp.activo = 1
        ";
        $stmtTipos = $conn->prepare($queryTipos);
        $stmtTipos->bindParam(':id', $id_cancha, PDO::PARAM_INT);
        $stmtTipos->execute();
        $perfil['tipos_partido'] = $stmtTipos->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($perfil);
        exit();
    } else {
        // Perfil jugador
        $id_jugador = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id_jugador <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de jugador inválido']);
            exit();
        }

        $query = "SELECT 
            u.id_usuario,
            u.nombre,
            u.apellido,
            u.email,
            u.fecha_registro,
    
            j.id_jugador,
            j.username,
            j.telefono,
            j.foto_perfil,
            j.banner,
            j.fecha_nacimiento,
            j.id_sexo,
            j.reputacion,
            j.descripcion,

            -- Sexo
            s.nombre AS sexo,
    
            e.nombre AS estado_usuario

        FROM usuarios u
        INNER JOIN jugadores j ON u.id_usuario = j.id_jugador
        INNER JOIN sexo s ON j.id_sexo = s.id_sexo
        INNER JOIN estados_usuarios e ON u.id_estado = e.id_estado
        WHERE id_jugador = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id_jugador, PDO::PARAM_INT);
        $stmt->execute();
        $perfil = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$perfil) {
            http_response_code(404);
            echo json_encode(['error' => 'Perfil no encontrado']);
            exit();
        }

        header('Content-Type: application/json');
        echo json_encode($perfil);
        exit();
    }
} catch (PDOException $e) {
    error_log("GET_INFO_PERFIL ERROR: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error al buscar perfil']);
    exit();
};

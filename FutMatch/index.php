<!--

Pagina INDICE para seleccionar el proyecto que se desea visualizar

-->

<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar configuración
require_once '../../../src/app/config.php';

// Resalta la página actual en el navbar
$current_page = 'index';

// CSS adicional específico de esta página
$page_title = "Inicio";

// Cargar head común (incluye <!DOCTYPE html> y <html data-bs-theme="dark">)
require_once HEAD_COMPONENT;
?>

<body>
    <main class="container my-4">
        <h1 class="mb-4">Portfolio de CAMILA NATALIA</h1>

        <h1 class="mb-4">Proyectos</h1>
        <div class="list-group">
            <a href="FutMatch.php" class="list-group-item list-group-item-action">
                FutMatch - Plataforma de gestión de partidos de fútbol
            </a>
    </main>
</body>
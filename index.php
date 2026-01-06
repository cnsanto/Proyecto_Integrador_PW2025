<!--

Pagina INDICE para seleccionar el proyecto que se desea visualizar

-->

<!DOCTYPE html>

<html lang="es" data-bs-theme="dark">

<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cargar configuración
require_once 'Futmatch/src/app/config.php';

// Resalta la página actual en el navbar
$current_page = 'index';

// CSS adicional específico de esta página
$page_title = "Inicio";

$idioma = $_GET['idioma'] ?? 'eng';

?>


<?php
$cv = [
    'esp' => [
        'titulo' => 'Camila Santo',
        'subtitulo' => 'Desarrolladora de Software',
        'resumen_it' => 'Resumen IT',
        'experiencia' => 'Experiencia Laboral',
        'educacion' => 'Historia Académica',
        'idiomas' => 'Idiomas',
        'contacto' => 'Contacto',

        'backoffice' => [
            'puesto' => 'Back Office de Desarrollo | Project Management',
            'empresa' => 'SoftGuard Tech de Argentina SRL',
            'periodo' => 'Enero 2025 - Junio 2026',
            'tareas' => [
                'Organización de tareas en el área de Desarrollo.',
                'Asistencia y planificación de proyectos.',
                'QA: detección y análisis de problemas.',
                'Optimización de flujos de trabajo.',
                'Gestión de recursos internos y externos.'
            ]
        ],

        'junior' => [
            'puesto' => 'Desarrolladora Junior | Full-Stack',
            'empresa' => 'ANSES - Administración Nacional de la Seguridad Social',
            'periodo' => 'Junio 2026 - Actualidad',
            'tareas' => [
                'Documentación y planificación de sistemas.',
                'QA y análisis de incidencias.',
                'Manejo de COBOL y DB2 en Mainframe.',
                'Desarrollo web con HTML, CSS, JavaScript y Java.'
            ]
        ],

        'educacion_detalle' => [
            'institucion' => 'Universidad Provincial de Ezeiza (Argentina)',
            'titulo' => 'Tecnicatura en Desarrollo de Software',
            'extra' => '32 de 34 materias aprobadas | Promedio: 8.72'
        ],

        'idiomas_detalle' => [
            'Español nativo',
            'Inglés fluido',
            'Húngaro avanzado'
        ]
    ],

    'eng' => [
        'titulo' => 'Camila Santo',
        'subtitulo' => 'Software Developer',
        'resumen_it' => 'IT Summary',
        'experiencia' => 'Work Experience',
        'educacion' => 'Academic Background',
        'idiomas' => 'Languages',
        'contacto' => 'Contact',

        'backoffice' => [
            'puesto' => 'Development Back Office | Project Management',
            'empresa' => 'SoftGuard Tech de Argentina SRL',
            'periodo' => 'January 2025 – June 2026',
            'tareas' => [
                'Organized tasks within the Development area.',
                'Assisted in development planning.',
                'QA: detected and analyzed issues.',
                'Improved workflow efficiency.',
                'Managed internal and external resources.'
            ]
        ],

        'junior' => [
            'puesto' => 'Junior Developer | Full-Stack',
            'empresa' => 'ANSES - National Administration of Social Security',
            'periodo' => 'June 2026 - Now',
            'tareas' => [
                'System documentation and planning.',
                'QA and issue analysis.',
                'COBOL and DB2 on Mainframe.',
                'Web development with HTML, CSS, JavaScript and Java.'
            ]
        ],

        'educacion_detalle' => [
            'institucion' => 'Universidad Provincial de Ezeiza (Argentina)',
            'titulo' => 'Technical Degree in Software Development',
            'extra' => '32 of 34 courses completed | GPA: 8.72'
        ],

        'idiomas_detalle' => [
            'Spanish: Native',
            'English: Fluent',
            'Hungarian: Advanced'
        ]
    ]
];

$data = $cv[$idioma];
?>


<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <base href="<?= BASE_URL ?>" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= CSS_BOOTSTRAP ?>" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= CSS_ICONS ?>" />

    <!-- Fuente Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="<?= FONT_MONTSERRAT ?>" rel="stylesheet" />

    <!-- CSS Unificados del Proyecto -->
    <link rel="stylesheet" href="<?= CSS_BASE ?>" />
    <link rel="stylesheet" href="<?= CSS_LAYOUT ?>" />
    <link rel="stylesheet" href="<?= CSS_COMPONENTS ?>" />

</head>

<body>
    <main class="container my-4">
        <!-- Boton para mostrar INGLES / ESPAÑOL -->
        <div class="d-flex justify-content-end">
            <button id="inglesBtn" class="btn btn-dark me-2">
                <i class="English"></i> ENG
            </button>

            <button id="espanolBtn" class="btn btn-dark">
                <i class="Spanish"></i> ESP
            </button>
        </div>

        <?php if ($idioma === 'eng'): ?>
            <h1 class="m-4">CAMILA NATALIA SANTO's Portfolio</h1>
            <p>Hi! My name is Camila. I am a software developer and this is my Portfolio.</p>
            <p>I am so </p>

            <h2 class="mb-4">Projects</h2>
            <div class="list-group">
                <a href="FutMatch.php" class="list-group-item list-group-item-action">
                    FutMatch - Football Matchmaking Platform
                </a>
            </div>

        <?php else: ?>
            <h1 class="m-4">Portafolio de CAMILA NATALIA SANTO</h1>
            <p>¡Hola! Mi nombre es Camila. Soy desarrolladora de software y este es mi portafolio.</p>
            <h2 class="mb-4">Proyectos</h2>
            <div class="list-group">
                <a href="FutMatch.php" class="list-group-item list-group-item-action">
                    FutMatch - Plataforma de Emparejamiento de Partidos de Fútbol
                </a>
            </div>
        <?php endif; ?>

        <h1><?= $data['titulo'] ?></h1>
        <h3><?= $data['subtitulo'] ?></h3>

        <h2><?= $data['experiencia'] ?></h2>

        <h4><?= $data['backoffice']['puesto'] ?></h4>
        <p><?= $data['backoffice']['empresa'] ?> | <?= $data['backoffice']['periodo'] ?></p>
        <ul>
            <?php foreach ($data['backoffice']['tareas'] as $tarea): ?>
                <li><?= $tarea ?></li>
            <?php endforeach; ?>
        </ul>

        <h4><?= $data['junior']['puesto'] ?></h4>
        <p><?= $data['junior']['empresa'] ?> | <?= $data['junior']['periodo'] ?></p>
        <ul>
            <?php foreach ($data['junior']['tareas'] as $tarea): ?>
                <li><?= $tarea ?></li>
            <?php endforeach; ?>
        </ul>

        <h2><?= $data['educacion'] ?></h2>
        <p><strong><?= $data['educacion_detalle']['institucion'] ?></strong></p>
        <p><?= $data['educacion_detalle']['titulo'] ?></p>
        <p><?= $data['educacion_detalle']['extra'] ?></p>

        <h2><?= $data['idiomas'] ?></h2>
        <ul>
            <?php foreach ($data['idiomas_detalle'] as $idiomaItem): ?>
                <li><?= $idiomaItem ?></li>
            <?php endforeach; ?>
        </ul>


    </main>

    <script src="index.js"></script>
</body>
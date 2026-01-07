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
$page_title = "Inicio";

$idioma = $_GET['idioma'] ?? 'eng';

// Definición de datos
$cv = [
    'esp' => [
        'titulo' => 'Camila Santo', // Used in hero
        'subtitulo' => 'Desarrolladora de Software',
        'intro' => '¡Hola!',
        'carta_presentacion' => '¡Muchas gracias por visitar mi portafolio! Aquí encontrarás un resumen de mi trayectoria laboral y académica.
        También podrás conocer mis habilidades técnicas y lingüísticas, así como demos de proyectos. 
        Si te interesa mi perfil para una oportunidad laboral, encontrarás mis datos de contacto tanto en el encabezado como al final de la página.
        Un poco sobre mí: soy una persona con mucha energía, apasionada por aprender y crecer, y siempre dispuesta a desafiarme en cada proyecto. 
        Soy detallista y disfruto resolver problemas de forma creativa.
        Me apasionan el diseño y la atención a los detalles. Soy muy organizada en mi trabajo y me gusta documentar todo lo que puedo. 
        Además, disfruto estandarizar tareas y buscar la máxima eficiencia: todo lo que se pueda automatizar, será automatizado.
        ¡Espero que disfrutes recorriendo mi portafolio!
        
        DISCLAIMER: Por favor tener en cuenta que tanto este portafolio como los proyectos aquí demostrados fueron desarrollados con fines personales y/o educativos, por lo que no están disponibles para su uso comercial.
        ',
        'resumen_it' => 'Resumen IT',
        'experiencia' => 'Experiencia Laboral',
        'educacion' => 'Historia Académica',
        'idiomas' => 'Idiomas',
        'proyectos' => 'Proyectos',
        'contacto' => 'Contacto',
        'ver_mas' => 'Ver Proyecto',

        'skills_titulo' => 'Habilidades IT',
        'skills_lista' => [
            'COBOL',
            'HTML',
            'CSS',
            'JavaScript',
            'PHP',
            'C',
            'C++',
            'C# (.NET)',
            'QA & Testing',
            'SQL Server',
            'DB2',
            'Google Apps Script',
            'Documentación',
            'JIRA',
            'Azure DevOps'
        ],

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
            'empresa' => 'ANSES',
            'periodo' => 'Junio 2026 - Actualidad',
            'tareas' => [
                'Documentación y planificación de sistemas.',
                'QA y análisis de incidencias.',
                'Manejo de COBOL y DB2 en Mainframe.',
                'Desarrollo web con HTML, CSS, JavaScript y Java.'
            ]
        ],

        'educacion_detalle' => [
            'institucion' => 'Universidad Provincial de Ezeiza',
            'titulo' => 'Tecnicatura en Desarrollo de Software',
            'extra' => [
                '32 de 34 materias aprobadas | Promedio: 8.72.',
                'Formación en programación estructurada y orientada a objetos.',
                'Especialización en diseño, modelado y gestión de bases de datos con SQL Server.',
                'Conocimientos adquiridos en C, C++, C# (.NET), HTML, CSS y JavaScript.'
            ],
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
        'intro' => 'Hi!',
        'carta_presentacion' => 'Thank you very much for visiting my portfolio. 
        Here you will find a summary of my professional and academic background.
        You will also be able to explore my technical and language skills, as well as project demos. 
        If you are interested in my profile for a job opportunity, you can find my contact information both at the top and at the bottom of the page.      
        A little about me: I am a highly energetic person, passionate about learning and growing, and always willing to challenge myself in every project. 
        I am detail-oriented and enjoy solving problems in creative ways.        
        I have a strong interest in design and attention to detail. 
        I am very organized in my work and I like to document everything I can. 
        I also enjoy standardizing tasks and striving for maximum efficiency — anything that can be automated, will be automated!
        I hope you enjoy exploring my portfolio.

        DISCLAIMER: Please note that this portfolio and the projects showcased here were developed for personal and/or educational purposes only and are not available for commercial use.
        Additionally, please understand that some of the projects are designed and documented exclusively in Spanish.
        ',
        'resumen_it' => 'IT Summary',
        'experiencia' => 'Work Experience',
        'educacion' => 'Academic Background',
        'idiomas' => 'Languages',
        'proyectos' => 'Projects',
        'contacto' => 'Contact',
        'ver_mas' => 'View Project',

        'skills_titulo' => 'IT Skills',
        'skills_lista' => [
            'COBOL',
            'HTML',
            'CSS',
            'JavaScript',
            'PHP',
            'C',
            'C++',
            'C# (.NET)',
            'QA & Testing',
            'SQL Server',
            'DB2',
            'Google Apps Script',
            'System Doc',
            'JIRA',
            'Azure DevOps'
        ],

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
            'empresa' => 'ANSES',
            'periodo' => 'June 2026 - Now',
            'tareas' => [
                'System documentation and planning.',
                'QA and issue analysis.',
                'COBOL and DB2 on Mainframe.',
                'Web development with HTML, CSS, JavaScript and Java.'
            ]
        ],

        'educacion_detalle' => [
            'institucion' => 'Universidad Provincial de Ezeiza',
            'titulo' => 'Technical Degree in Software Development',
            'extra' => [
                '32 out of 34 courses completed | GPA: 8.72',
                'Training in structured and object-oriented programming.',
                'Specialization in database design, modeling, and management with SQL Server.',
                'Knowledge acquired in C, C++, C# (.NET), HTML, CSS, and JavaScript.'
            ],
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
    <!-- Base tag removed to ensure local assets (index.css, index.js) load correctly relative to this file -->

    <title><?= $data['titulo'] ?> - Portfolio</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= CSS_BOOTSTRAP ?>" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= CSS_ICONS ?>" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Proyectos -->
    <!-- Note: We are linking local index.css via relative path since it's in the same folder -->
    <link rel="stylesheet" href="index.css?v=<?= time() ?>" />
</head>

<body>

    <!-- Top Header (Lang + Socials) -->
    <div class="top-header">

        <!-- CV Download Dropdown -->
        <div class="dropdown">
            <button class="btn btn-sm text-muted dropdown-toggle border-0 me-3" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Download CV">
                <i class="bi bi-file-earmark-arrow-down-fill fs-5"></i> Download CV
            </button>
            <ul class="dropdown-menu dropdown-menu-dark shadow">
                <li><a class="dropdown-item" href="CV Camila Santo ESP.pdf" download><i class="bi bi-flag-fill me-2"></i>Español</a></li>
                <li><a class="dropdown-item" href="CV Camila Santo ENG.pdf" download><i class="bi bi-flag me-2"></i>English</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="CV Camila Santo ESP-ENG.pdf" download><i class="bi bi-files me-2"></i>Ambos / Both</a></li>
            </ul>
        </div>

        <div class="header-socials">
            <a href="https://wa.link/hzrlh7" target="_blank" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.linkedin.com/in/camila-natalia-santo/" target="_blank" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="https://github.com/cnsanto" target="_blank" title="GitHub"><i class="bi bi-github"></i></a>
            <a href="mailto:cnsanto@gmail.com" title="Email"><i class="bi bi-envelope-fill"></i></a>
        </div>
        <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.2);"></div>
        <div class="lang-toggle">
            <button id="inglesBtn" class="lang-btn <?= $idioma === 'eng' ? 'active' : '' ?>">ENG</button>
            <button id="espanolBtn" class="lang-btn <?= $idioma === 'esp' ? 'active' : '' ?>">ESP</button>
        </div>
    </div>

    <!-- Hero Section -->
    <section id="hero" class="hero-section container">
        <div class="row w-100">
            <!-- Left Column: Photo, Title, Subtitle -->
            <!-- Removed justify-content-center to align to top -->
            <div class="d-flex flex-column align-items-center text-center mb-5 mb-lg-0 pt-lg-4">
                <img src="picture.jpeg" alt="Profile Picture" class="profile-picture mb-4">
                <h1 class="hero-title lh-1">
                    <span class="text-gradient" data-text="<?= $data['titulo'] ?>"><?= $data['titulo'] ?></span>
                </h1>
                <p class="hero-subtitle mb-0"><?= $data['subtitulo'] ?></p>
            </div>

            <!-- Right Column: Intro, Letter, Buttons -->
            <div class="">
                <p class="lead mb-3 text-start text-white fw-bold display-6">
                    <?= $data['intro'] ?>
                </p>

                <!-- Carta de Presentación -->
                <div class="glass-card text-start mb-4 p-4">
                    <p class="mb-0 text-muted " style="line-height: 2;">
                        <?= nl2br($data['carta_presentacion']) ?>
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-3 justify-content-start">
                    <a href="#projects" class="btn btn-glow"><?= $data['proyectos'] ?></a>
                    <a href="#experience" class="btn btn-glow"><?= $data['experiencia'] ?></a>
                    <a href="#education" class="btn btn-glow"><?= $data['educacion'] ?></a>
                    <a href="#languages" class="btn btn-glow"><?= $data['idiomas'] ?></a>
                    <a href="#skills" class="btn btn-glow"><?= $data['skills_titulo'] ?></a>
                    <!-- Point to footer for contact since section was removed -->
                    <a href="mailto:cnsanto@gmail.com" class="btn btn-glow"><?= $data['contacto'] ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="container">
        <h2 class="text-center mb-5"><span class="text-gradient"><?= $data['proyectos'] ?></span></h2>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <!-- Project Card: FutMatch -->
                <!-- Corrected link to the actual landing page -->
                <a href="FutMatch/public/HTML/auth/landing.php" target="_blank" class="project-card text-decoration-none">
                    <div class="glass-card text-center">
                        <div class="project-icon">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <h3 class="mb-3">FutMatch</h3>
                        <?php if ($idioma === 'eng'): ?>
                            <p class="text-muted">Football Matchmaking Platform. Connect with players, book pitches, and organize tournaments instantly.</p>
                        <?php else: ?>
                            <p class="text-muted">Plataforma de Emparejamiento de Partidos. Conecta con jugadors, reserva canchas y organiza torneos al instante.</p>
                        <?php endif; ?>
                        <span class="btn btn-sm btn-outline-primary rounded-pill mt-3"><?= $data['ver_mas'] ?> <i class="bi bi-arrow-right"></i></span>
                    </div>
                </a>
            </div>
            <!-- Placeholder for more projects -->
        </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="container">
        <div class="row">
            <!-- Left Column: Experience + Languages -->
            <div class="col-lg-6 mb-5 mb-lg-0">
                <!-- XP -->
                <h2 class="mb-4"><i class="bi bi-briefcase me-2"></i> <?= $data['experiencia'] ?></h2>

                <div class="glass-card p-4 mb-5">
                    <!-- Job 1 -->
                    <div class="timeline-item">
                        <div class="role-title"><?= $data['junior']['puesto'] ?></div>
                        <div class="company-name"><?= $data['junior']['empresa'] ?></div>
                        <div class="period-badge"><?= $data['junior']['periodo'] ?></div>
                        <ul class="text-muted ps-3 mb-0">
                            <?php foreach ($data['junior']['tareas'] as $tarea): ?>
                                <li><?= $tarea ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Job 2 -->
                    <div class="timeline-item border-0 mb-0 pb-0">
                        <div class="role-title"><?= $data['backoffice']['puesto'] ?></div>
                        <div class="company-name"><?= $data['backoffice']['empresa'] ?></div>
                        <div class="period-badge"><?= $data['backoffice']['periodo'] ?></div>
                        <ul class="text-muted ps-3 mb-0">
                            <?php foreach ($data['backoffice']['tareas'] as $tarea): ?>
                                <li><?= $tarea ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Languages (Moved here) -->
                <h2 id="languages" class="mb-4"><i class="bi bi-translate me-2"></i> <?= $data['idiomas'] ?></h2>
                <div class="glass-card p-4">
                    <div>
                        <?php foreach ($data['idiomas_detalle'] as $idiomaItem): ?>
                            <span class="skill-tag fs-6 px-3 py-2 m-1"><?= $idiomaItem ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Education + IT Skills -->
            <div id="education" class="col-lg-6">
                <!-- Education -->
                <h2 class="mb-4"><i class="bi bi-mortarboard me-2"></i> <?= $data['educacion'] ?></h2>
                <div class="glass-card p-4 mb-5">
                    <h4 class="mb-1"><?= $data['educacion_detalle']['institucion'] ?></h4>
                    <p class="text-primary fw-bold mb-3"><?= $data['educacion_detalle']['titulo'] ?></p>

                    <ul class="text-muted ps-3 mb-0">
                        <?php foreach ($data['educacion_detalle']['extra']  as $extra): ?>
                            <li class="mb-2"><?= $extra ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- IT Skills -->
                <h2 id="skills" class="mb-4"><i class="bi bi-cpu me-2"></i> <?= $data['skills_titulo'] ?></h2>
                <div class="glass-card p-4">
                    <div class="d-flex flex-wrap">
                        <?php foreach ($data['skills_lista'] as $skill): ?>
                            <span class="skill-tag fs-6 px-3 py-2 m-1"><?= $skill ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <div class="d-flex justify-content-center gap-4 fs-3 mb-3">
                <a href="https://wa.link/hzrlh7" class="text-white hover-primary"><i class="bi bi-whatsapp"></i></a>
                <a href="https://www.linkedin.com/in/camila-natalia-santo/" class="text-white hover-primary"><i class="bi bi-linkedin"></i></a>
                <a href="https://github.com/cnsanto" class="text-white hover-primary"><i class="bi bi-github"></i></a>
                <a href="mailto:cnsanto@gmail.com" class="text-white hover-primary"><i class="bi bi-envelope-fill"></i></a>
            </div>
            <p class="mb-0">&copy; <?= date('Y') ?> Camila Natalia Santo. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS (Required for Dropdowns) -->
    <script src="<?= JS_BOOTSTRAP ?>"></script>
    <script src="index.js"></script>
</body>

</html>
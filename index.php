<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['idioma'])) {
    $_SESSION['idioma'] = $_GET['idioma'];
}

$idioma = $_SESSION['idioma'] ?? 'eng';

// Cargar configuración
require_once 'FutMatch/src/app/config.php';

// Define root URL for portfolio CSS/JS (different from BASE_URL which points to FutMatch/)
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    define("ROOT_URL", "/Proyecto_Integrador_PW2025/");
} else {
    define("ROOT_URL", "/");
}

// Resalta la página actual en el navbar
$current_page = 'index';
$page_title = "Inicio";

// Definición de datos
$cv = [
    'esp' => [
        'titulo' => 'Camila Santo', // Used in hero
        'subtitulo' => 'Analista de Datos | Técnica en Desarrollo de Software | Optimización y Automatización de procesos',
        'intro' => '¡Hola!',
        'carta_presentacion' => '¡Muchas gracias por visitar mi portafolio! Aquí encontrarás un resumen de mi trayectoria laboral y académica,
mis habilidades técnicas y lingüísticas, así como demos de proyectos.
Si te interesa mi perfil, encontrarás mis datos de contacto tanto en el encabezado como al final de la página.

Soy una persona apasionada por el análisis de datos y la tecnología, con especial interés en especializarme en Ciencia de Datos.
Disfruto transformar datos en información útil para la toma de decisiones, y me entusiasma trabajar con SQL y automatización de procesos.
Soy organizada, detallista y convencida de que todo lo que se pueda automatizar, debe automatizarse.

¡Espero que disfrutes recorriendo mi portafolio!

DISCLAIMER: Este portafolio y los proyectos aquí demostrados fueron desarrollados con fines personales y/o educativos, por lo que no están disponibles para su uso comercial.',
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
            'puesto' => 'IT Back-Office | Análisis de Datos y Sistemas | Optimización de Procesos',
            'empresa' => 'SoftGuard Tech de Argentina SRL',
            'location' => 'Buenos Aires, Argentina',
            'periodo' => 'Enero 2025 - Junio 2025',
            'tareas' => [
                'Análisis y modelado de datos en SQL Server, asegurando integridad y consistencia de la información.',
                'Automatización de reportes con JavaScript y Google Apps Script, reduciendo tiempos de procesamiento manual.',
                'Monitoreo de métricas bajo metodología Kanban (Jira) para detección de cuellos de botella.',
                'Detección de incidencias (QA) y documentación de soluciones en Confluence.',
                'Desarrollo de scripts de automatización (Ext JS / Google Apps Script) para estructuración de información.'
            ]
        ],

        'junior' => [
            'puesto' => 'IT Back-Office | Análisis de Datos y Sistemas | Optimización de Procesos',
            'empresa' => 'Administración Nacional de Seguridad Social (ANSES)',
            'location' => 'Buenos Aires, Argentina',
            'periodo' => 'Junio 2025 - Actualidad',
            'tareas' => [
                'Gestión y consulta de grandes volúmenes de datos con SQL Server y DB2 en entornos Mainframe.',
                'Análisis de métricas operativas y monitoreo de incidencias en Azure DevOps.',
                'Automatización de reportes mediante Google Sheets avanzado (fórmulas, gráficos y tablas dinámicas).',
                'Documentación técnica y modelado de flujos de datos para la optimización de procesos.',
                'Colaboración en planificación de sistemas con enfoque analítico.'
            ]
        ],

        'zen_hostel' => [
            'puesto' => 'Asistente Administrativa | Automatización y Gestión de Información (Inglés)',
            'empresa' => 'Zen Hostel',
            'location' => 'Budapest, Hungary',
            'periodo' => 'Mayo 2024 – Agosto 2024',
            'tareas' => [
                'Estructuración de bases de datos operativas con Google Spreadsheets y Forms para control administrativo.',
                'Auditoría y reporte de información ante organismos gubernamentales.'
            ]

        ],

        'cosco' => [
            'puesto' => 'Back Office | Document Organization and Information Management',
            'empresa' => 'Cosco Shipping Lines',
            'location' => 'Buenos Aires, Argentina',
            'periodo' => 'April 2022 – February 2024',
            'tareas' => [
                'Gestión y control de documentación crítica de exportación con sucursales internacionales y clientes.',
                'Estandarización de procesos y estructuración de flujos de información para mejorar trazabilidad y archivo digital.',
                'Optimización de flujos administrativos, reduciendo inconsistencias en registros de seguimiento.',
                'Coordinación de bases de datos para soporte de auditorías y reportes corporativos.'
            ]

        ],

        'bratton' => [
            'puesto' => 'Back Office | Document Organization and Information Management',
            'empresa' => 'Bratton S.R.L',
            'location' => 'Buenos Aires, Argentina',
            'periodo' => 'August 2021 – April 2022',
            'tareas' => [
                'Seguimiento y control de operaciones de importación y exportación, garantizando cumplimiento de plazos.',
                'Estandarización de procesos administrativos para optimizar la trazabilidad de información de clientes.',
                'Gestión de inventarios y soporte en compras con actualización constante de registros operativos.'
            ]

        ],

        'educacion_detalle' => [
            'institucion' => 'Universidad Provincial de Ezeiza',
            'titulo' => 'Tecnicatura en Desarrollo de Software',
            'extra' => [
                '32 de 34 materias aprobadas | Promedio: 8.72.',
                'Formación en programación estructurada y orientada a objetos.',
                'Especialización en diseño, modelado y gestión de bases de datos con SQL Server.',
                'Conocimientos adquiridos en C, C++, C# (.NET), HTML, CSS y JavaScript.',
                'Fundamentos de electrónica, arquitectura de computadoras y sistemas de numeración.',
                'Estructuras de datos y algoritmos: recursividad, listas, árboles, memoria dinámica y análisis numérico.',
                'Sistemas operativos: procesos, administración de memoria, filesystem y entrada/salida.',
                'Redes de computadoras: protocolos de comunicación, arquitecturas de red, ruteo IP y redes WiFi.',
                'Programación en tiempo real: procesos, hilos, semáforos, sincronización y comunicación entre procesos.',
                'Testing: fundamentos, métodos y técnicas de prueba, manejo de excepciones y niveles de testing.',
                'Ingeniería de requisitos: análisis, especificación, casos de uso y modelado en UML.',
                'Ingeniería de software: arquitectura, diseño, gestión de proyectos, administración de riesgos y metodologías ágiles.',
                'Seguridad informática: seguridad perimetral, control de acceso, criptografía y administración de datos.',
                'Programación web: cliente/servidor, PHP, XML/JSON, webservices y patrón MVC.',
                'Matemática aplicada: cálculo, álgebra lineal, lógica proposicional, grafos y análisis numérico.'
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
        'subtitulo' => 'Data Analysis | Software Development Technician | Process Automation',
        'intro' => 'Hi!',
        'carta_presentacion' => "Thank you so much for visiting my portfolio! Here you'll find a summary of my professional and academic background,
          my technical and language skills, as well as project demos.
          If my profile interests you, feel free to reach out — my contact details are in the header and at the bottom of the page.

          I'm passionate about data analysis and technology, with a strong interest in specializing in Data Science.
          I enjoy turning data into meaningful insights for decision-making, and I'm enthusiastic about SQL and process automation.
          I'm organized, detail-oriented, and firmly believe that everything that can be automated, should be automated.

          I hope you enjoy exploring my portfolio!

          DISCLAIMER: This portfolio and the projects demonstrated here were developed for personal and/or educational purposes and are not available for commercial use.",
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

        'junior' => [
            'puesto' => 'IT Back-Office | Data Analysis & Process Optimization',
            'empresa' => 'ANSES (National Social Security Administration)',
            'location' => 'Buenos Aires, Argentina',
            'periodo' => 'June 2025 - Now',
            'tareas' => [
                'Manage and query large-scale datasets using SQL Server and DB2 in Mainframe environments, ensuring technical data integrity.',
                'Analyze operational metrics and monitor incidents via Azure DevOps to ensure process quality and business continuity.',
                'Automate control reports using advanced Google Sheets techniques (logical functions, charts, data blending, and pivot tables).',
                'Create technical documentation and data flow modeling aimed at process optimization and systemic efficiency.',
                'Collaborate in systems planning, providing analytical insights for workflow streamlining and information structuring.'
            ]
        ],

        'backoffice' => [
            'puesto' => 'IT Back-Office | Data Analysis & Process Optimization',
            'empresa' => 'SoftGuard Tech de Argentina SRL',
            'location' => 'Buenos Aires, Argentina',
            'periodo' => 'January 2025 – June 2025',
            'tareas' => [
                'Performed data modeling and analysis in SQL Server, ensuring information consistency across the product ecosystem.',
                'Automated operational reports using JavaScript and Google Apps Script, significantly reducing manual data processing time.',
                'Monitored performance metrics under Kanban (Jira) methodology to detect bottlenecks and optimize development lifecycles.',
                'Conducted incident detection (QA) and continuous technical process improvement, documenting solutions in Confluence for knowledge traceability.',
                'Developed automation scripts (Ext JS / Google Apps Script) focused on information structuring and operational order.'
            ]
        ],

        'zen_hostel' => [
            'puesto' => 'Administrative Assistant | Data Management & Automation (English)',
            'empresa' => 'Zen Hostel',
            'location' => 'Budapest, Hungary',
            'periodo' => 'June 2025 - Now',
            'tareas' => [
                'Structured operational databases using Google Spreadsheets and Google Forms for corporate administrative control.',
                'Audited and reported information to government agencies, ensuring the accuracy of submitted data.'
            ]

        ],

        'cosco' => [
            'puesto' => 'Back Office | Document Organization and Information Management',
            'empresa' => 'Cosco Shipping Lines',
            'location' => 'Buenos Aires, Argentina',
            'periodo' => 'April 2022 – February 2024',
            'tareas' => [
                'Managed critical export documentation, guaranteeing data integrity in communications with international branches and clients.',
                'Standardized operational processes and structured data flows to improve traceability and digital archiving of large datasets.',
                'Optimized administrative workflows, reducing data entry inconsistencies and ensuring precision in tracking records.'
            ]

        ],

        'bratton' => [
            'puesto' => 'Back Office | Document Organization and Information Management',
            'empresa' => 'Bratton S.R.L',
            'location' => 'Buenos Aires, Argentina',
            'periodo' => 'August 2021 – April 2022',
            'tareas' => [
                'Tracked import/export operations, ensuring the integrity of critical documentation and meeting strict deadlines.',
                'Improved operational order and standardized administrative processes to optimize customer information traceability.'
            ]

        ],

        'educacion_detalle' => [
            'institucion' => 'Universidad Provincial de Ezeiza',
            'titulo' => 'Technical Degree in Software Development',
            'extra' => [
                '32 out of 34 courses completed | GPA: 8.72',
                'Training in structured and object-oriented programming.',
                'Specialization in database design, modeling, and management with SQL Server.',
                'nowledge acquired in C, C++, C# (.NET), HTML, CSS, and JavaScript.',
                'Fundamentals of electronics, computer architecture, and numbering systems.',
                'Data structures and algorithms: recursion, linked lists, trees, dynamic memory, and numerical analysis.',
                'Operating systems: processes, memory management, filesystem, and I/O.',
                'Computer networks: communication protocols, network architectures, IP routing, and WiFi networks.',
                'Real-time programming: processes, threads, semaphores, synchronization, and inter-process communication.',
                'Testing: fundamentals, testing methods and techniques, exception handling, and testing levels.',
                'Requirements engineering: analysis, specification, use cases, and UML modeling.',
                'Software engineering: architecture, design, project management, risk administration, and agile methodologies.',
                'Computer security: perimeter security, access control, cryptography, and data administration.',
                'Web programming: client/server architecture, PHP, XML/JSON, web services, and MVC pattern.',
                'Applied mathematics: calculus, linear algebra, propositional logic, graph theory, and numerical analysis.'
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
    <link rel="stylesheet" href="<?= ROOT_URL ?>index.css?v=<?= time() ?>" />
    <link rel="stylesheet" href="<?= ROOT_URL ?>contact-bubble.css?v=<?= time() ?>" />
</head>

<body>

    <!-- Top Header (Lang + Socials) -->
    <div class="top-header">

        <!-- CV View Dropdown -->
        <div class="dropdown">
            <button class="btn btn-sm text-muted dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="CV">
                <i class="bi bi-file-earmark-arrow-down-fill fs-5"></i> CV
            </button>
            <ul class="dropdown-menu dropdown-menu-dark shadow">
                <li><a class="dropdown-item" href="https://drive.google.com/file/d/12dJlfdxKq5GtW7a6Vfyw2u400JxZJCMv/view?usp=drive_link" target="_blank"><i class="bi bi-flag-fill me-2"></i>Español</a></li>
                <li><a class="dropdown-item" href="https://drive.google.com/file/d/1WO_OnuFwMZa9AKB_hs03HWMhZbDpJOyj/view?usp=drive_link" target="_blank"><i class="bi bi-flag me-2"></i>English</a></li>
                <!--<li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="https://drive.google.com/file/d/1WLsTf_6H9nsn2q9oeuQDjIT-kqePhaLr/view?usp=drive_link" target="_blank"><i class="bi bi-files me-2"></i>Ambos / Both</a></li>-->
            </ul>
        </div>

        <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.2);"></div>

        <div class="header-socials">
            <a href="https://wa.link/hzrlh7" target="_blank" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            <a href="https://www.linkedin.com/in/camila-natalia-santo/" target="_blank" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
            <a href="https://github.com/cnsanto" target="_blank" title="GitHub"><i class="bi bi-github"></i></a>
            <a href="javascript:void(0);" class="copy-email-btn" data-email="cnsanto@gmail.com" title="Copy Email"><i class="bi bi-envelope-fill"></i></a>
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
                    <a href="javascript:void(0);" class="btn btn-glow copy-email-btn" data-email="cnsanto@gmail.com"><?= $data['contacto'] ?></a>
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
                            <p class="text-muted">The texts of the page will be in Spanish, but I added english instructions for you to help you navigate the page.</p>
                            <p class="text-muted">Look for the helper button in the bottom right corner of your screen!</p>
                            <div class="d-flex flex-wrap">
                                <span class="skill-tag fs-6 px-3 py-2 m-1">Full Stack</span>
                                <span class="skill-tag fs-6 px-3 py-2 m-1">Bootstrap</span>
                                <span class="skill-tag fs-6 px-3 py-2 m-1">PHP</span>
                                <span class="skill-tag fs-6 px-3 py-2 m-1">MySQL</span>
                                <span class="skill-tag fs-6 px-3 py-2 m-1">JavaScript</span>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Plataforma de Emparejamiento de Partidos. Conecta con jugadores, reserva canchas y organiza torneos al instante.</p>
                            <p class="text-muted">Si no sabés cómo navegar la página, buscá el botón de ayuda en la esquina inferior derecha de tu pantalla.</p>
                            <div class="d-flex flex-wrap">
                                <span class="skill-tag fs-6 px-3 py-2 m-1">Desarrollo Full Stack</span>
                                <span class="skill-tag fs-6 px-3 py-2 m-1">Bootstrap</span>
                                <span class="skill-tag fs-6 px-3 py-2 m-1">PHP</span>
                                <span class="skill-tag fs-6 px-3 py-2 m-1">MySQL</span>
                                <span class="skill-tag fs-6 px-3 py-2 m-1">JavaScript</span>
                            </div>
                        <?php endif; ?>
                        <div class="lg:flex lg:justify-between">
                            <span class="btn btn-sm btn-outline-primary rounded-pill mt-3"><?= $data['ver_mas'] ?> <i class="bi bi-arrow-right"></i></span>
                        </div>
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
                        <div class="period-badge"><?= $data['junior']['location'] ?></div>
                        <ul class="text-muted ps-3 mb-0">
                            <?php foreach ($data['junior']['tareas'] as $tarea): ?>
                                <li><?= $tarea ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Job 2 -->
                    <div class="timeline-item">
                        <div class="role-title"><?= $data['backoffice']['puesto'] ?></div>
                        <div class="company-name"><?= $data['backoffice']['empresa'] ?></div>
                        <div class="period-badge"><?= $data['backoffice']['periodo'] ?></div>
                        <div class="period-badge"><?= $data['backoffice']['location'] ?></div>
                        <ul class="text-muted ps-3 mb-0">
                            <?php foreach ($data['backoffice']['tareas'] as $tarea): ?>
                                <li><?= $tarea ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Job 4 -->
                    <div class="timeline-item">
                        <div class="role-title"><?= $data['cosco']['puesto'] ?></div>
                        <div class="company-name"><?= $data['cosco']['empresa'] ?></div>
                        <div class="period-badge"><?= $data['cosco']['periodo'] ?></div>
                        <div class="period-badge"><?= $data['cosco']['location'] ?></div>
                        <ul class="text-muted ps-3 mb-0">
                            <?php foreach ($data['cosco']['tareas'] as $tarea): ?>
                                <li><?= $tarea ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Job 5 -->
                    <div class="timeline-item">
                        <div class="role-title"><?= $data['bratton']['puesto'] ?></div>
                        <div class="company-name"><?= $data['bratton']['empresa'] ?></div>
                        <div class="period-badge"><?= $data['bratton']['periodo'] ?></div>
                        <div class="period-badge"><?= $data['bratton']['location'] ?></div>
                        <ul class="text-muted ps-3 mb-0">
                            <?php foreach ($data['bratton']['tareas'] as $tarea): ?>
                                <li><?= $tarea ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column: Education + IT Skills -->
            <div id="education" class="col-lg-6">
                <!-- Education -->
                <h2 class="mb-4"><i class="bi bi-mortarboard me-2"></i> <?= $data['educacion'] ?></h2>
                <div class="glass-card p-4 mb-5">
                    <h4 class="mb-1"><a href="https://web.upe.edu.ar/" target="_blank"><?= $data['educacion_detalle']['institucion'] ?></a></h4>
                    <p class="text-primary fw-bold mb-3"><?= $data['educacion_detalle']['titulo'] ?></p>

                    <ul class="text-muted ps-3 mb-0">
                        <?php foreach ($data['educacion_detalle']['extra']  as $extra): ?>
                            <li class="mb-2"><?= $extra ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- IT Skills -->
                <h2 id="skills" class="mb-4"><i class="bi bi-cpu me-2"></i> <?= $data['skills_titulo'] ?></h2>
                <div class="glass-card p-4 mb-5">
                    <div class="d-flex flex-wrap">
                        <?php foreach ($data['skills_lista'] as $skill): ?>
                            <span class="skill-tag fs-6 px-3 py-2 m-1"><?= $skill ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Languages -->
                <h2 id="languages" class="mb-4"><i class="bi bi-translate me-2"></i> <?= $data['idiomas'] ?></h2>
                <div class="glass-card p-4">
                    <div>
                        <?php foreach ($data['idiomas_detalle'] as $idiomaItem): ?>
                            <span class="skill-tag fs-6 px-3 py-2 m-1"><?= $idiomaItem ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating Contact Bubble -->
    <div class="contact-bubble-container">
        <button id="contactBubbleBtn" class="btn-contact-bubble" aria-label="Contact Menu">
            <i class="bi bi-chat-dots"></i>
        </button>
        <div class="contact-bubble-menu">
            <a href="https://wa.link/hzrlh7" target="_blank" class="contact-item contact-whatsapp" title="WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </a>
            <a href="https://www.linkedin.com/in/camila-natalia-santo/" target="_blank" class="contact-item contact-linkedin" title="LinkedIn">
                <i class="bi bi-linkedin"></i>
            </a>
            <a href="https://github.com/cnsanto" target="_blank" class="contact-item contact-github" title="GitHub">
                <i class="bi bi-github"></i>
            </a>
            <a href="javascript:void(0);" class="contact-item contact-email copy-email-btn" data-email="cnsanto@gmail.com" title="Email">
                <i class="bi bi-envelope-fill"></i>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <div class="d-flex justify-content-center gap-4 fs-3 mb-3">
                <a href="https://wa.link/hzrlh7" class="text-white hover-primary"><i class="bi bi-whatsapp"></i></a>
                <a href="https://www.linkedin.com/in/camila-natalia-santo/" class="text-white hover-primary"><i class="bi bi-linkedin"></i></a>
                <a href="https://github.com/cnsanto" class="text-white hover-primary"><i class="bi bi-github"></i></a>
                <a href="javascript:void(0);" class="text-white hover-primary copy-email-btn" data-email="cnsanto@gmail.com"><i class="bi bi-envelope-fill"></i></a>
            </div>
            <p class="mb-0">&copy; <?= date('Y') ?> Camila Natalia Santo. All rights reserved.</p>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div id="toast-notification" class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3" style="z-index: 1055;">
        <div id="emailToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i> Email copied to clipboard!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Required for Dropdowns) -->
    <script src="<?= JS_BOOTSTRAP ?>"></script>
    <script src="index.js"></script>
</body>

</html>
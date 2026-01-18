<!--
Página principal (home).
Muestra el título, lema y las tarjetas para:
- Entrar como invitado
- Iniciar sesión o registrarse
También enlaza al formulario para inscribirse como admin. de canchas.
-->
<?php
require_once __DIR__ . '/../../../src/app/config.php';

// Iniciar sesión para mostrar errores de login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = "FutMatch";

$page_css = [CSS_PAGES_LANDING, CSS_COMPONENTS];

include HEAD_COMPONENT;

$helper_body_es = '
<div class="mb-3"> 
<p>¡Hola! Bienvenido a FutMatch.</p>
<p>Esta página fue creada de manera grupal para la materia "Programación Web" de la
<a href="https://web.upe.edu.ar/" target="_blank"> Universidad Provincial de Ezeiza</a>.</p>
<p>Si le gustaría ver el proyecto original en GitHub, les dejo el
<a href="https://github.com/cnsanto/Proyecto_Integrador_PW2025" target="_blank"> enlace</a>.</p>
</div>
<hr class="my-3">
<div class="mb-3"> 
<p>¿Qué es FutMatch?</p>
<p>FutMatch es una plataforma que permite a los usuarios buscar y reservar canchas para jugar fútbol.</p>
<p>También permite a los Administradores de las Canchas gestionar su agenda, partidos y torneos.</p>
<p>FutMatch fue creado pensando en aquellas personas a las que les gusta jugar fútbol de manera no profesional, pero 
que muchas veces encuentran dificultades para encontrar un lugar para jugar, o para organizar un partido con sus amigos.</p>
<p>Además, FutMatch funciona como página de conexión entre Jugadores, solucionando el típico problema de falta de compañeros de equipo.</p>
</div>
<hr class="my-3">
<div class="mb-3"> 
<p>Ahora mismo, se encuentran en la página de inicio. Aquí puede: </p>
<ul>
    <li class="mb-3">Entrar como invitado: puede revisar canchas y partidos disponibles, pero no puede reservar ni solicitar unirse.</li>
    <li class="mb-3">
    <p>Iniciar sesión o registrarse como jugador: puede hacerlo inmediatamente.</p>
    <button type="button" class="btn btn-secondary login-jugador">Iniciar sesión como jugador de ejemplo</button>
    <p class="text-muted">Este es una cuenta demostrativa. Sus datos serán eliminados a corto plazo.</p>
    </li>
    <li class="mb-3">
    <p>Iniciar sesión o registrarse como administrador de canchas: exige un par de pasos extras.</p>
    <button type="button" class="btn btn-secondary login-admin">Iniciar sesión como administrador de ejemplo</button>
    <p class="text-muted">Este es una cuenta demostrativa. Sus datos serán eliminados a corto plazo.</p>
    </li>
    <li class="mb-3">Iniciar sesión como administrador de FutMatch (no hay un botón especial, sólo con las credenciales correctas): 
    <p class="text-muted">Este usuario es necesario para la aceptación de nuevos administradores de canchas.</p>
    <button type="button" class="btn btn-secondary login-admin-futmatch">Iniciar sesión como administrador de FutMatch</button>
    </li>
</ul>
</div>
';

$helper_body_en = '
<div class="mb-3"> 
<p>Hello! Welcome to FutMatch.</p>
<p>This page was created as a group project for the subject "Web Programming" at the 
    <a href="https://web.upe.edu.ar/" target="_blank"> Provincial University of Ezeiza</a>.</p>
<p>If you would like to see the original project on GitHub, here is the
    <a href="https://github.com/cnsanto/Proyecto_Integrador_PW2025" target="_blank"> link</a>.</p>
</div>
<hr class="my-3">
<div class="mb-3"> 
<p>What is FutMatch?</p>
<p>FutMatch is a platform that allows users to search for and book football fields.</p>
<p>It also allows field administrators to manage their schedule, matches, and tournaments.</p>
<p>FutMatch was created for people who enjoy playing football in a non-professional way, but who often have trouble finding a place to play or organizing a match with friends.</p>
<p>In addition, FutMatch works as a connection platform between players, solving the common problem of not having enough teammates.</p>
</div>
<hr class="my-3">
<div class="mb-3"> 
<p>You are currently on the landing page. Here you can:</p>
<ul>
    <li class="mb-3">Enter as a guest: you can browse available fields and matches, but you cannot make reservations or request to join.</li>
    <li class="mb-3">
    <p>Log in or register as a player: you can do it right away.</p>
    <button type="button" class="btn btn-secondary login-jugador">Log in as example player</button>
    <p class="text-muted">This is a demo account. The data will be deleted in a short-term period.</p>
    </li>
    <li class="mb-3">
    <p>Log in or register as a field administrator: this requires a few extra steps.</p>
    <button type="button" class="btn btn-secondary login-admin">Log in as example field administrator</button>
    <p class="text-muted">This is a demo account. The data will be deleted in a short-term period.</p>
    </li>
    <li class="mb-3">Log in as a FutMatch administrator (no special button, only with the right credentials).
    <p class="text-muted">This user is necessary for the acceptance of new field administrators.</p>
    <button type="button" class="btn btn-secondary login-admin-futmatch">Log in as example administrator</button>
    </li>
</ul>
</div>
';


?>

<body>

    <script>
        // Set global variable for demo login URL (needed by landing.js)
        window.DEMO_LOGIN_URL = '<?= CONTROLLER_DEMO_LOGIN ?>';
    </script>
    <header class="hero bg-image" style="background-image: url('<?= IMG_LANDING ?>');">
        <?php include HELPER_COMPONENT; ?>
        <div class="hero-overlay"></div>

        <div class="container position-relative">
            <!-- Logo - SVG -->
            <!-- <div class="text-center mb-3">[SVG LOGO]</div> -->

            <!-- Título y lema -->
            <div class="row justify-content-center text-center text-light">
                <div class="col-11 col-lg-9">
                    <h1 class="display-3 fw-800 brand-title mb-2">FutMatch</h1>
                    <p class="lead brand-tagline mb-5">
                        La pasión es la chispa que enciende el fuego del éxito
                    </p>
                </div>
            </div>

            <!-- Tarjetas de acción -->
            <div class="row g-4 justify-content-center">
                <!-- Card: Invitado -->
                <div class="col-11 col-md-5 col-lg-4">
                    <a href="<?= PAGE_INICIO_JUGADOR ?>" class="text-decoration-none">
                        <div class="card card-action h-100" role="button" tabindex="0" aria-label="Entrar como invitado">
                            <div class="card-body py-4">
                                <h2 class="h4 fw-600 mb-2">Entrar como invitado</h2>
                                <p class="text-muted mb-0">
                                    Explorá canchas y partidos sin registrarte. Ideal para una primera mirada rápida.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Card: Iniciar sesión / Registrarse (expandible) -->
                <div class="col-11 col-md-5 col-lg-4">
                    <div class="guest card card-action h-100" id="loginCard" role="button" tabindex="0"
                        aria-controls="loginCollapse" aria-expanded="false">
                        <div class="card-body py-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h2 class="h4 fw-600 mb-1">Iniciar sesión</h2>
                                    <p class="text-muted mb-0">O registrate en segundos para guardar tus partidos.</p>
                                </div>
                                <span class="chevron" aria-hidden="true">▾</span>
                            </div>

                            <!-- Mostrar error si existe -->
                            <?php if (isset($_SESSION['login_error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <?= htmlspecialchars($_SESSION['login_error']) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <!-- Contenido expandible -->
                            <div class="collapse mt-3 <?= isset($_SESSION['login_error']) ? 'show' : '' ?>" id="loginCollapse">
                                <form id="loginForm" action="<?= CONTROLLER_LOGIN ?>" method="POST" novalidate>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            autocomplete="username" required
                                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
                                        <div class="invalid-feedback">Ingresá un email válido.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            autocomplete="current-password" required />
                                        <div class="invalid-feedback">La contraseña es obligatoria.</div>
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                                        </button>
                                        <a class="btn btn-dark"
                                            href="<?= PAGE_REGISTRO_JUGADOR_PHP ?>">
                                            <i class="bi bi-person-plus me-2"></i>Registrarme
                                        </a>
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="<?= PAGE_FORGOT_PHP ?>"
                                            class="small">¿Olvidaste tu contraseña?</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enlace discreto para gestores de canchas -->
                <div class="col-12 text-center">
                    <a href="<?= PAGE_REGISTRO_ADMIN_CANCHA_PHP ?>"
                        class="link-cancha">¿Sos dueño de una cancha? Te ayudamos a gestionarla</a>
                </div>
            </div>
        </div>
    </header>


    <!-- Scripts -->
    <script src="<?= JS_BOOTSTRAP ?>"></script>
    <script src="<?= JS_TOAST_MODULE ?>"></script>
    <script src="<?= JS_LANDING ?>"></script>
    <script src="<?= JS_HELPER ?>"></script>

    <script>
        // Auto-expandir formulario si hay error de login
        <?php if (isset($_SESSION['login_error'])): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const loginCard = document.getElementById('loginCard');
                if (loginCard) {
                    loginCard.setAttribute('aria-expanded', 'true');
                }
                // Focus en el campo de email
                const emailInput = document.getElementById('email');
                if (emailInput) {
                    emailInput.focus();
                }
            });
            <?php
            // Limpiar el error después de mostrarlo
            unset($_SESSION['login_error']);
            ?>
        <?php endif; ?>
    </script>
</body>

</html>
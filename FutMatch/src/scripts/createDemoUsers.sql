-- =================================================================
-- DEMO USERS SEEDING SCRIPT FOR FUTMATCH
-- =================================================================
-- This script creates three permanent demo accounts (one per role)
-- for static demo mode. These accounts are read-only for page viewers.
--
-- IMPORTANT: Run this script AFTER adding the tipo_demo and 
-- demo_expiracion columns to the usuarios table.
--
-- Password for all demo accounts: demo2026
-- =================================================================

-- Demo Jugador (Player)
INSERT INTO `usuarios` (`nombre`, `apellido`, `email`, `password`, `id_estado`, `tipo_demo`, `demo_expiracion`, `fecha_registro`) 
VALUES 
('Demo', 'Jugador', 'demo_jugador@futmatch.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'static', NULL, NOW());

SET @demo_jugador_id = LAST_INSERT_ID();

-- Assign jugador role
INSERT INTO `usuarios_roles` (`id_usuario`, `id_rol`) 
VALUES (@demo_jugador_id, 1);

-- Create jugador profile
INSERT INTO `jugadores` (`id_jugador`, `username`, `telefono`, `fecha_nacimiento`, `id_sexo`, `id_posicion`, `descripcion`) 
VALUES 
(@demo_jugador_id, 'demo_player', '1100000001', '1990-01-01', 2, 3, 'Cuenta demostrativa de jugador. Solo lectura.');

-- -----------------------------------------------------------------

-- Demo Admin Cancha (Field Administrator)
INSERT INTO `usuarios` (`nombre`, `apellido`, `email`, `password`, `id_estado`, `tipo_demo`, `demo_expiracion`, `fecha_registro`) 
VALUES 
('Demo', 'Admin', 'demo_admin@futmatch.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'static', NULL, NOW());

SET @demo_admin_id = LAST_INSERT_ID();

-- Assign admin_cancha role
INSERT INTO `usuarios_roles` (`id_usuario`, `id_rol`) 
VALUES (@demo_admin_id, 2);

-- Note: For admin_cancha, you would need to:
-- 1. Create a solicitud_admin_cancha entry
-- 2. Create an admin_canchas entry
-- 3. Optionally create canchas entries
-- This is commented out as it requires specific direccion and solicitud IDs
-- that may not exist yet. Uncomment and adjust as needed:

/*
-- Create solicitud (adjust id_direccion as needed)
INSERT INTO `solicitudes_admin_cancha` (`id_usuario`, `id_direccion`, `id_estado`, `fecha_solicitud`) 
VALUES (@demo_admin_id, 1, 3, NOW());

SET @demo_solicitud_id = LAST_INSERT_ID();

-- Create admin_canchas entry
INSERT INTO `admin_canchas` (`id_admin_cancha`, `id_solicitud`, `telefono`) 
VALUES (@demo_admin_id, @demo_solicitud_id, '1100000002');
*/

-- -----------------------------------------------------------------

-- Demo Admin Sistema (System Administrator)
INSERT INTO `usuarios` (`nombre`, `apellido`, `email`, `password`, `id_estado`, `tipo_demo`, `demo_expiracion`, `fecha_registro`) 
VALUES 
('Demo', 'Sistema', 'demo_sistema@futmatch.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 'static', NULL, NOW());

SET @demo_sistema_id = LAST_INSERT_ID();

-- Assign admin_sistema role
INSERT INTO `usuarios_roles` (`id_usuario`, `id_rol`) 
VALUES (@demo_sistema_id, 3);

-- =================================================================
-- VERIFICATION
-- =================================================================
-- Run this query to verify demo accounts were created:
-- SELECT u.id_usuario, u.nombre, u.apellido, u.email, u.tipo_demo, r.nombre as rol
-- FROM usuarios u
-- INNER JOIN usuarios_roles ur ON u.id_usuario = ur.id_usuario
-- INNER JOIN roles r ON ur.id_rol = r.id_rol
-- WHERE u.tipo_demo = 'static';
-- =================================================================

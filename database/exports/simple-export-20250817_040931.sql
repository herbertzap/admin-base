-- =====================================================
-- EXPORTACIÓN SIMPLIFICADA SQLITE A MYSQL
-- Sistema Admin-Base - Datos Básicos
-- Fecha: $(date)
-- =====================================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS `admin_base` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `admin_base`;

-- Limpiar tablas existentes (cuidado en producción)
SET FOREIGN_KEY_CHECKS = 0;

-- Datos exportados desde SQLite:
-- Datos de usuarios:
INSERT INTO users VALUES (1, 'Admin', 'admin@material.com', '2025-07-02 22:22:02', NULL, NULL, NULL, '$2y$10$9Az9.XoDDV.CQrmf/vHr7.tquOUZVp0TDsmTmu4.lxMuV3VhM9MDO', 'JPKydI438S6iJJ9cXVdiHssTppUt54CTJyCfKodaJIE7rfn11FqWhJfA79hm', '2025-07-02 22:22:03', '2025-08-12 04:28:49', 1, NULL, '10958991-8', 'Activo', '2025-08-12 04:28:49', NULL, 0);
INSERT INTO users VALUES (2, 'Herbert Zapata', 'herbert.zapata19@gmail.com', NULL, NULL, NULL, NULL, '$2y$10$i3sPT5SxudaonsFo1wjnC.BHZE4j9OK99u.cfdgDNK7I5swBxE64y', NULL, '2025-07-02 22:24:27', '2025-08-13 19:48:59', 1, NULL, NULL, 'Activo', '2025-08-13 19:48:59', NULL, 0);
-- Datos de operadores:
INSERT INTO operadors VALUES (1, 'S46', '76666087-8', 'Contenedores Tomas Dagnino Vicencio  E.I.R.L.', 'CONTENEDORES DAVI E.I.R.L.', 'Julio Fossa Calderon 190, Viña del Mar', 'Res. Nro. 2635 del 26/08/2020', 'logos/DCaYB5fXRskoC1Pe8zYw62tszHiYEcwxSk3j5QmS.jpg', 'firmas/RsqSXHBrE3X2HFX8dfLYehJ1fSv4pPbQCmRigRKj.jpg', '17119371-0', 'Tomas Dagnino Vicencio', 'Gerente General', 'Activo', '2025-08-11 15:29:40', '2025-08-11 15:29:40', 2, 'CONTENEDORES DAVI E.I.R.L.', 'davicontainer@gmail.com', NULL, 1, 'gtarifeno@gmail.com', '2025-08-11 15:29:40', '2025-08-11 15:29:40');
-- Datos de aduanas:
INSERT INTO aduana_chiles VALUES (1, '03', 'Arica', NULL, 'Arica', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 21:40:04', '2025-08-12 21:18:49');
INSERT INTO aduana_chiles VALUES (2, '07', 'Iquique', NULL, 'Iquique', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 21:56:33', '2025-08-12 21:29:38');
INSERT INTO aduana_chiles VALUES (3, '14', 'Antofagasta', NULL, 'Antofagasta', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 21:57:34', '2025-08-12 21:28:55');
INSERT INTO aduana_chiles VALUES (4, '33', 'Santiago', NULL, 'Los Andes', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 22:03:43', '2025-08-14 05:23:15');
INSERT INTO aduana_chiles VALUES (5, '34', 'Valparaíso', NULL, 'Valparaíso', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 22:04:01', '2025-08-14 05:23:15');
INSERT INTO aduana_chiles VALUES (6, '39', 'San Antonio', NULL, 'San Antonio', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 22:04:14', '2025-08-14 05:23:15');
INSERT INTO aduana_chiles VALUES (7, '48', 'Santiago', NULL, 'Santiago', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 22:04:28', '2025-08-12 21:31:15');
INSERT INTO aduana_chiles VALUES (8, '55', 'Talcahuano', NULL, 'Talcahuano', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 22:04:41', '2025-08-12 21:30:52');
INSERT INTO aduana_chiles VALUES (9, '69', 'Puerto Montt', NULL, NULL, NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 22:04:57', '2025-08-12 21:30:12');
INSERT INTO aduana_chiles VALUES (10, '92', 'Punta Arenas', NULL, 'Punta Arenas', NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 22:05:13', '2025-08-12 21:30:25');
-- Datos de tipos de contenedores:
INSERT INTO tipo_contenedors VALUES (1, 'REE', 'Reefer (Refrigerado)', 'Activo', '2025-08-11 23:35:53', '2025-08-12 21:10:44', NULL);
INSERT INTO tipo_contenedors VALUES (2, 'TNK', 'Tank (Estanque)', 'Activo', '2025-08-11 23:36:13', '2025-08-12 21:10:44', NULL);
INSERT INTO tipo_contenedors VALUES (3, 'FR', 'Flat Rack', 'Activo', '2025-08-11 23:36:34', '2025-08-12 21:10:44', 1);
INSERT INTO tipo_contenedors VALUES (4, 'OT', 'Open Top', 'Activo', '2025-08-11 23:36:52', '2025-08-12 21:10:44', NULL);
INSERT INTO tipo_contenedors VALUES (5, 'DRY', 'Dry (Seco)', 'Activo', '2025-08-11 23:37:07', '2025-08-12 21:10:44', 1);
INSERT INTO tipo_contenedors VALUES (6, 'HC', 'High Cube', 'Activo', '2025-08-11 23:37:30', '2025-08-12 21:10:44', NULL);
INSERT INTO tipo_contenedors VALUES (7, 'RHC', 'Reefer High Cube', 'Activo', '2025-08-11 23:37:47', '2025-08-12 21:10:44', NULL);
-- Datos de empresas transportistas:
INSERT INTO empresa_transportistas VALUES (1, 'Almarza servicios transportes e izajes', '14275360-K', 'calle de prueba  0123', 'SANTIAGO', '98745632', 'contacto-prueba@gmail.com', 'persona de prueba', '942710205', NULL, 'Activo', NULL, '2025-08-05 17:31:18', '2025-08-05 17:31:44');
INSERT INTO empresa_transportistas VALUES (2, 'Hector Enrique Borvaran Astorga', '15047588-0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 21:21:00', '2025-08-11 21:21:00');
INSERT INTO empresa_transportistas VALUES (3, 'Transportes José Infestas  Rementería E.I.R.L.', '76052703-3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Activo', NULL, '2025-08-11 21:21:33', '2025-08-11 21:21:33');
-- Datos de lugares de depósito:
INSERT INTO lugar_depositos VALUES (1, '01', 'DyC Placilla', 'Bernardo OHiggins 388, Valparaíso.', 'Valparaíso', 'Valparaíso', NULL, NULL, NULL, 1, 'Activo', NULL, '2025-08-11 22:07:21', '2025-08-11 22:08:33');
INSERT INTO lugar_depositos VALUES (2, '02', 'DyC San Antonio', 'Ruta G 94 F Nuevo Acceso al Puerto 3559 Barrio Industrial San Antonio, Valparaíso', 'San Antonio', 'Valparaíso', NULL, NULL, NULL, 1, 'Activo', NULL, '2025-08-11 22:08:26', '2025-08-11 22:08:26');
INSERT INTO lugar_depositos VALUES (3, '03', 'DyC Santiago', 'La divisa 700, Santiago', 'Santiago', 'Santiago', NULL, NULL, NULL, 1, 'Activo', NULL, '2025-08-11 22:09:15', '2025-08-11 22:09:25');
-- Datos de tickets:
INSERT INTO tickets VALUES (1, 'articulo 1', 'easto es una prueba 222', 'nuevo', 2, NULL, '2025-07-03 17:29:01', '2025-07-11 17:10:50');
INSERT INTO tickets VALUES (2, 'prueba 2', 'pruweba ticket 2', 'nuevo', 2, NULL, '2025-08-12 04:27:16', '2025-08-12 04:27:16');
-- Datos de companies:
INSERT INTO companies VALUES (1, 'Importadora Ejemplo S.A.', '76.123.456-7', 'Av. Providencia 1234', 'Santiago', '+56 2 2345 6789', 'contacto@importadoraejemplo.cl', 'Juan Pérez', '+56 9 8765 4321', 'juan.perez@importadoraejemplo.cl', 1, 'Empresa de ejemplo para pruebas del sistema Hermes', '2025-07-02 22:43:03', '2025-07-02 22:43:03');
INSERT INTO companies VALUES (2, 'Comercial Internacional Ltda.', '78.987.654-3', 'Las Condes 5678', 'Santiago', '+56 2 3456 7890', 'info@comercialinternacional.cl', 'María González', '+56 9 1234 5678', 'maria.gonzalez@comercialinternacional.cl', 1, 'Empresa especializada en importaciones de tecnología', '2025-07-02 22:43:03', '2025-07-02 22:43:03');
SET FOREIGN_KEY_CHECKS = 1;

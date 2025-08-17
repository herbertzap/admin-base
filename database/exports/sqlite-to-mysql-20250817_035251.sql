-- =====================================================
-- ARCHIVO DE IMPORTACIÓN SQLITE A MYSQL
-- Exportado desde SQLite - Sistema Admin-Base
-- Fecha: $(date)
-- =====================================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS `admin_base` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `admin_base`;

-- Limpiar tablas existentes (cuidado en producción)
SET FOREIGN_KEY_CHECKS = 0;

-- Datos reales exportados desde SQLite:
-- Datos de usuarios:
INSERT INTO users VALUES (1, 'Admin', 'admin@material.com', '2025-07-02 22:22:02', NULL, NULL, NULL, '$2y$12$rvF5iE6p8x99ey4I0Lxwa.tIfW3Ori6rxylNiFZ3X9WzZ3bpe0Ysa', 'JPKydI438S6iJJ9cXVdiHssTppUt54CTJyCfKodaJIE7rfn11FqWhJfA79hm', '2025-07-02 22:22:03', '2025-08-12 04:28:49', 1, NULL, '10958991-8', 'Activo', '2025-08-12 04:28:49', NULL, 0);
INSERT INTO users VALUES (2, 'Herbert Zapata', 'herbert.zapata19@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$/4qtzyC9yWO/PISsktMRXeonn3U.E92DHVIC/TnHUeR4wvHZmWLT6', NULL, '2025-07-02 22:24:27', '2025-08-13 19:48:59', 1, NULL, NULL, 'Activo', '2025-08-13 19:48:59', NULL, 0);
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

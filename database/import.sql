-- =====================================================
-- ARCHIVO DE IMPORTACIÓN DE BASE DE DATOS
-- Sistema de Administración de Contenedores (Admin-Base)
-- Versión: 1.0
-- Fecha: 2025-01-27
-- =====================================================

-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS `admin_base` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `admin_base`;

-- =====================================================
-- TABLA: users (Usuarios del sistema)
-- =====================================================
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: password_reset_tokens
-- =====================================================
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: failed_jobs
-- =====================================================
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL UNIQUE,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: personal_access_tokens
-- =====================================================
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL UNIQUE,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: migrations
-- =====================================================
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: operadores (Operadores de contenedores)
-- =====================================================
CREATE TABLE `operadores` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_operador` varchar(10) NOT NULL UNIQUE,
  `nombre_operador` varchar(255) NOT NULL,
  `rut_operador` varchar(20) NOT NULL UNIQUE,
  `direccion_operador` text,
  `telefono_operador` varchar(20),
  `email_operador` varchar(255),
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: aduana_chiles (Aduanas de Chile)
-- =====================================================
CREATE TABLE `aduana_chiles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) NOT NULL UNIQUE,
  `nombre_aduana` varchar(255) NOT NULL,
  `region` varchar(100),
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: tipo_contenedors (Tipos de contenedores)
-- =====================================================
CREATE TABLE `tipo_contenedors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_tipo` varchar(10) NOT NULL UNIQUE,
  `descripcion` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: lugar_depositos (Lugares de depósito)
-- =====================================================
CREATE TABLE `lugar_depositos` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_lugar` varchar(10) NOT NULL UNIQUE,
  `nombre_lugar` varchar(255) NOT NULL,
  `direccion_lugar` text,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: empresa_transportistas (Empresas transportistas)
-- =====================================================
CREATE TABLE `empresa_transportistas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_empresa` varchar(10) NOT NULL UNIQUE,
  `nombre_empresa` varchar(255) NOT NULL,
  `rut_empresa` varchar(20) NOT NULL UNIQUE,
  `direccion_empresa` text,
  `telefono_empresa` varchar(20),
  `email_empresa` varchar(255),
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: tatcs (Títulos de Admisión Temporal de Contenedores)
-- =====================================================
CREATE TABLE `tatcs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_tatc` varchar(20) NOT NULL UNIQUE,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `operador_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_ingreso` enum('Por Desembarque','Por Traspaso','Por Reingreso') NOT NULL,
  `ingreso_pais` datetime NOT NULL,
  `numero_contenedor` varchar(11) NOT NULL,
  `tatc_origen` varchar(20),
  `tipo_contenedor_id` bigint(20) UNSIGNED NOT NULL,
  `ingreso_deposito` datetime NOT NULL,
  `documento_ingreso` varchar(100) NOT NULL,
  `fecha_traspaso` datetime,
  `tara_contenedor` decimal(10,2) NOT NULL,
  `tipo_bulto` varchar(100) NOT NULL,
  `valor_fob` decimal(15,2) NOT NULL,
  `valor_cif` decimal(15,2) NOT NULL,
  `comentario` text,
  `aduana_ingreso_id` bigint(20) UNSIGNED NOT NULL,
  `eir` varchar(50),
  `tamano_contenedor` enum('20 pies','40 pies','45 pies') NOT NULL,
  `puerto_ingreso` varchar(100) NOT NULL,
  `estado_contenedor` enum('Bueno','Regular','Malo') NOT NULL,
  `ano_fabricacion` int(4) NOT NULL,
  `ubicacion_fisica` varchar(100),
  `estado` enum('activo','cancelado','finalizado') DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tatcs_user_id_foreign` (`user_id`),
  KEY `tatcs_operador_id_foreign` (`operador_id`),
  KEY `tatcs_tipo_contenedor_id_foreign` (`tipo_contenedor_id`),
  KEY `tatcs_aduana_ingreso_id_foreign` (`aduana_ingreso_id`),
  CONSTRAINT `tatcs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tatcs_operador_id_foreign` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tatcs_tipo_contenedor_id_foreign` FOREIGN KEY (`tipo_contenedor_id`) REFERENCES `tipo_contenedors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tatcs_aduana_ingreso_id_foreign` FOREIGN KEY (`aduana_ingreso_id`) REFERENCES `aduana_chiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: tatc_historials (Historial de cambios TATC)
-- =====================================================
CREATE TABLE `tatc_historials` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tatc_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `accion` enum('crear','actualizar','eliminar','cancelar') NOT NULL,
  `detalles` text,
  `datos_anteriores` json DEFAULT NULL,
  `datos_nuevos` json DEFAULT NULL,
  `estado_anterior` enum('activo','cancelado','finalizado') DEFAULT NULL,
  `estado_nuevo` enum('activo','cancelado','finalizado') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tatc_historials_tatc_id_foreign` (`tatc_id`),
  KEY `tatc_historials_user_id_foreign` (`user_id`),
  CONSTRAINT `tatc_historials_tatc_id_foreign` FOREIGN KEY (`tatc_id`) REFERENCES `tatcs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tatc_historials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: tstcs (Títulos de Salida Temporal de Contenedores)
-- =====================================================
CREATE TABLE `tstcs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_tstc` varchar(20) NOT NULL UNIQUE,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `operador_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_salida` enum('Por Embarque','Por Traspaso','Por Reingreso') NOT NULL,
  `salida_pais` datetime NOT NULL,
  `numero_contenedor` varchar(11) NOT NULL,
  `tstc_origen` varchar(20),
  `tipo_contenedor_id` bigint(20) UNSIGNED NOT NULL,
  `salida_deposito` datetime NOT NULL,
  `documento_salida` varchar(100) NOT NULL,
  `fecha_traspaso` datetime,
  `tara_contenedor` decimal(10,2) NOT NULL,
  `tipo_bulto` varchar(100) NOT NULL,
  `valor_fob` decimal(15,2) NOT NULL,
  `valor_cif` decimal(15,2) NOT NULL,
  `comentario` text,
  `aduana_salida_id` bigint(20) UNSIGNED NOT NULL,
  `eir` varchar(50),
  `tamano_contenedor` enum('20 pies','40 pies','45 pies') NOT NULL,
  `puerto_salida` varchar(100) NOT NULL,
  `estado_contenedor` enum('Bueno','Regular','Malo') NOT NULL,
  `ano_fabricacion` int(4) NOT NULL,
  `ubicacion_fisica` varchar(100),
  `estado` enum('activo','cancelado','finalizado') DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tstcs_user_id_foreign` (`user_id`),
  KEY `tstcs_operador_id_foreign` (`operador_id`),
  KEY `tstcs_tipo_contenedor_id_foreign` (`tipo_contenedor_id`),
  KEY `tstcs_aduana_salida_id_foreign` (`aduana_salida_id`),
  CONSTRAINT `tstcs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tstcs_operador_id_foreign` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tstcs_tipo_contenedor_id_foreign` FOREIGN KEY (`tipo_contenedor_id`) REFERENCES `tipo_contenedors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tstcs_aduana_salida_id_foreign` FOREIGN KEY (`aduana_salida_id`) REFERENCES `aduana_chiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: tstc_historials (Historial de cambios TSTC)
-- =====================================================
CREATE TABLE `tstc_historials` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tstc_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `accion` enum('crear','actualizar','eliminar','cancelar') NOT NULL,
  `detalles` text,
  `datos_anteriores` json DEFAULT NULL,
  `datos_nuevos` json DEFAULT NULL,
  `estado_anterior` enum('activo','cancelado','finalizado') DEFAULT NULL,
  `estado_nuevo` enum('activo','cancelado','finalizado') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tstc_historials_tstc_id_foreign` (`tstc_id`),
  KEY `tstc_historials_user_id_foreign` (`user_id`),
  CONSTRAINT `tstc_historials_tstc_id_foreign` FOREIGN KEY (`tstc_id`) REFERENCES `tstcs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tstc_historials_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: salidas (Salidas y cancelaciones)
-- =====================================================
CREATE TABLE `salidas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tatc_id` bigint(20) UNSIGNED NOT NULL,
  `numero_salida` varchar(20) NOT NULL UNIQUE,
  `fecha_salida` datetime NOT NULL,
  `tipo_salida` enum('Embarque','Traspaso','Cancelación','Otro') NOT NULL,
  `motivo_salida` text NOT NULL,
  `numero_contenedor` varchar(11) NOT NULL,
  `aduana_salida_id` bigint(20) UNSIGNED NOT NULL,
  `empresa_transportista_id` bigint(20) UNSIGNED,
  `rut_chofer` varchar(20),
  `patente_camion` varchar(10),
  `destino_final` varchar(255),
  `pais_destino` varchar(100),
  `observaciones` text,
  `estado` enum('pendiente','procesada','cancelada') DEFAULT 'pendiente',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `salidas_tatc_id_foreign` (`tatc_id`),
  KEY `salidas_aduana_salida_id_foreign` (`aduana_salida_id`),
  KEY `salidas_empresa_transportista_id_foreign` (`empresa_transportista_id`),
  KEY `salidas_user_id_foreign` (`user_id`),
  CONSTRAINT `salidas_tatc_id_foreign` FOREIGN KEY (`tatc_id`) REFERENCES `tatcs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `salidas_aduana_salida_id_foreign` FOREIGN KEY (`aduana_salida_id`) REFERENCES `aduana_chiles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `salidas_empresa_transportista_id_foreign` FOREIGN KEY (`empresa_transportista_id`) REFERENCES `empresa_transportistas` (`id`) ON DELETE SET NULL,
  CONSTRAINT `salidas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERTAR DATOS DE MANTENEDORES
-- =====================================================

-- Insertar operadores
INSERT INTO `operadores` (`codigo_operador`, `nombre_operador`, `rut_operador`, `direccion_operador`, `telefono_operador`, `email_operador`, `estado`, `created_at`, `updated_at`) VALUES
('S46', 'CONTENEDORES DAVI E.I.R.L.', '76666087-8', 'Av. Principal 123, Valparaíso', '+56 32 123 4567', 'info@davi.cl', 'activo', NOW(), NOW()),
('S47', 'LOGISTICA MARITIMA SPA', '76543210-9', 'Calle Comercial 456, Santiago', '+56 2 234 5678', 'contacto@logmar.cl', 'activo', NOW(), NOW()),
('S48', 'TRANSPORTE INTERNACIONAL LTDA', '76432109-8', 'Ruta 68 Km 15, Valparaíso', '+56 32 345 6789', 'info@transint.cl', 'activo', NOW(), NOW());

-- Insertar aduanas
INSERT INTO `aduana_chiles` (`codigo`, `nombre_aduana`, `region`, `estado`, `created_at`, `updated_at`) VALUES
('03', 'Arica', 'Arica y Parinacota', 'activo', NOW(), NOW()),
('05', 'Iquique', 'Tarapacá', 'activo', NOW(), NOW()),
('07', 'Antofagasta', 'Antofagasta', 'activo', NOW(), NOW()),
('11', 'Los Andes', 'Valparaíso', 'activo', NOW(), NOW()),
('13', 'Valparaíso', 'Valparaíso', 'activo', NOW(), NOW()),
('15', 'San Antonio', 'Valparaíso', 'activo', NOW(), NOW()),
('16', 'Santiago', 'Metropolitana', 'activo', NOW(), NOW()),
('17', 'Talcahuano', 'Biobío', 'activo', NOW(), NOW()),
('19', 'Puerto Montt', 'Los Lagos', 'activo', NOW(), NOW()),
('21', 'Punta Arenas', 'Magallanes', 'activo', NOW(), NOW());

-- Insertar tipos de contenedores
INSERT INTO `tipo_contenedors` (`codigo_tipo`, `descripcion`, `estado`, `created_at`, `updated_at`) VALUES
('DRY', 'Dry (Seco)', 'activo', NOW(), NOW()),
('REE', 'Reefer (Refrigerado)', 'activo', NOW(), NOW()),
('TNK', 'Tank (Estanque)', 'activo', NOW(), NOW()),
('FR', 'Flat Rack', 'activo', NOW(), NOW()),
('OT', 'Open Top', 'activo', NOW(), NOW()),
('HC', 'High Cube', 'activo', NOW(), NOW()),
('RHC', 'Reefer High Cube', 'activo', NOW(), NOW());

-- Insertar lugares de depósito
INSERT INTO `lugar_depositos` (`codigo_lugar`, `nombre_lugar`, `direccion_lugar`, `estado`, `created_at`, `updated_at`) VALUES
('DEP01', 'Depósito Central Valparaíso', 'Av. Puerto 100, Valparaíso', 'activo', NOW(), NOW()),
('DEP02', 'Depósito San Antonio', 'Ruta 78 Km 5, San Antonio', 'activo', NOW(), NOW()),
('DEP03', 'Depósito Santiago', 'Av. Americo Vespucio 1500, Santiago', 'activo', NOW(), NOW()),
('DEP04', 'Depósito Talcahuano', 'Av. Costanera 200, Talcahuano', 'activo', NOW(), NOW());

-- Insertar empresas transportistas
INSERT INTO `empresa_transportistas` (`codigo_empresa`, `nombre_empresa`, `rut_empresa`, `direccion_empresa`, `telefono_empresa`, `email_empresa`, `estado`, `created_at`, `updated_at`) VALUES
('TR001', 'TRANSPORTES DEL PACIFICO SPA', '76543210-9', 'Av. Transporte 500, Valparaíso', '+56 32 500 1000', 'info@transpac.cl', 'activo', NOW(), NOW()),
('TR002', 'LOGISTICA INTEGRAL LTDA', '76432109-8', 'Calle Logística 300, Santiago', '+56 2 600 2000', 'contacto@logint.cl', 'activo', NOW(), NOW()),
('TR003', 'CARGA EXPRESA SPA', '76321098-7', 'Ruta 68 Km 20, Valparaíso', '+56 32 700 3000', 'info@cargaexp.cl', 'activo', NOW(), NOW());

-- Insertar usuario administrador por defecto
INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('Administrador', 'admin@admin-base.test', NOW(), '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, NOW(), NOW());

-- =====================================================
-- INSERTAR DATOS DE PRUEBA
-- =====================================================

-- Insertar TATC de prueba
INSERT INTO `tatcs` (`numero_tatc`, `user_id`, `operador_id`, `tipo_ingreso`, `ingreso_pais`, `numero_contenedor`, `tatc_origen`, `tipo_contenedor_id`, `ingreso_deposito`, `documento_ingreso`, `fecha_traspaso`, `tara_contenedor`, `tipo_bulto`, `valor_fob`, `valor_cif`, `comentario`, `aduana_ingreso_id`, `eir`, `tamano_contenedor`, `puerto_ingreso`, `estado_contenedor`, `ano_fabricacion`, `ubicacion_fisica`, `estado`, `created_at`, `updated_at`) VALUES
('342020002256', 1, 1, 'Por Traspaso', '2024-08-12 10:30:00', 'ABCD1234567', '342020002255', 2, '2024-08-12 11:00:00', 'DOC-001', '2024-08-12 12:00:00', 2500.00, '80 · Pallet', 50000.00, 55000.00, 'Contenedor de prueba 1', 5, 'EIR-001', '40 pies', 'Valparaíso', 'Bueno', 2020, 'Zona A', 'activo', NOW(), NOW()),
('342020002257', 1, 1, 'Por Desembarque', '2024-08-12 14:30:00', 'EFGH9876543', NULL, 1, '2024-08-12 15:00:00', 'DOC-002', '2024-08-12 16:00:00', 2200.00, '22 · Cajas De Carton', 35000.00, 38500.00, 'Contenedor de prueba 2', 5, 'EIR-002', '20 pies', 'Valparaíso', 'Regular', 2019, 'Zona B', 'activo', NOW(), NOW());

-- Insertar TSTC de prueba
INSERT INTO `tstcs` (`numero_tstc`, `user_id`, `operador_id`, `tipo_salida`, `salida_pais`, `numero_contenedor`, `tstc_origen`, `tipo_contenedor_id`, `salida_deposito`, `documento_salida`, `fecha_traspaso`, `tara_contenedor`, `tipo_bulto`, `valor_fob`, `valor_cif`, `comentario`, `aduana_salida_id`, `eir`, `tamano_contenedor`, `puerto_salida`, `estado_contenedor`, `ano_fabricacion`, `ubicacion_fisica`, `estado`, `created_at`, `updated_at`) VALUES
('342020002258', 1, 1, 'Por Embarque', '2024-08-13 09:00:00', 'IJKL4567890', NULL, 1, '2024-08-13 08:30:00', 'DOC-SAL-001', NULL, 2300.00, '15 · Cajas De Madera', 45000.00, 49500.00, 'TSTC de prueba 1', 5, 'EIR-SAL-001', '20 pies', 'Valparaíso', 'Bueno', 2021, 'Zona C', 'activo', NOW(), NOW());

-- Insertar salida de prueba
INSERT INTO `salidas` (`tatc_id`, `numero_salida`, `fecha_salida`, `tipo_salida`, `motivo_salida`, `numero_contenedor`, `aduana_salida_id`, `empresa_transportista_id`, `rut_chofer`, `patente_camion`, `destino_final`, `pais_destino`, `observaciones`, `estado`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'SAL-2024-001', '2024-08-14 10:00:00', 'Embarque', 'Embarque para exportación', 'ABCD1234567', 5, 1, '12345678-9', 'ABCD12', 'Shanghai', 'China', 'Salida programada', 'procesada', 1, NOW(), NOW());

-- =====================================================
-- INSERTAR MIGRACIONES
-- =====================================================
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_reset_tokens_table', 1),
('2019_08_19_000000_create_failed_jobs_table', 1),
('2019_12_14_000001_create_personal_access_tokens_table', 1),
('2025_01_27_000001_create_operadores_table', 1),
('2025_01_27_000002_create_aduana_chiles_table', 1),
('2025_01_27_000003_create_tipo_contenedors_table', 1),
('2025_01_27_000004_create_lugar_depositos_table', 1),
('2025_01_27_000005_create_empresa_transportistas_table', 1),
('2025_01_27_000006_create_tatcs_table', 1),
('2025_01_27_000007_create_tatc_historials_table', 1),
('2025_01_27_000008_create_tstcs_table', 1),
('2025_01_27_000009_create_tstc_historials_table', 1),
('2025_01_27_000010_create_salidas_table', 1);

-- =====================================================
-- CREAR ÍNDICES ADICIONALES PARA OPTIMIZACIÓN
-- =====================================================

-- Índices para búsquedas frecuentes
CREATE INDEX `idx_tatcs_numero_contenedor` ON `tatcs` (`numero_contenedor`);
CREATE INDEX `idx_tatcs_fecha_ingreso` ON `tatcs` (`ingreso_pais`);
CREATE INDEX `idx_tatcs_estado` ON `tatcs` (`estado`);
CREATE INDEX `idx_tstcs_numero_contenedor` ON `tstcs` (`numero_contenedor`);
CREATE INDEX `idx_tstcs_fecha_salida` ON `tstcs` (`salida_pais`);
CREATE INDEX `idx_tstcs_estado` ON `tstcs` (`estado`);
CREATE INDEX `idx_salidas_fecha_salida` ON `salidas` (`fecha_salida`);
CREATE INDEX `idx_salidas_estado` ON `salidas` (`estado`);

-- =====================================================
-- FINALIZAR IMPORTACIÓN
-- =====================================================

-- Verificar que todas las tablas se crearon correctamente
SELECT 'Base de datos importada exitosamente' AS mensaje;

-- Mostrar resumen de datos importados
SELECT 'Resumen de datos importados:' AS titulo;
SELECT 'Usuarios:' AS tipo, COUNT(*) AS cantidad FROM users UNION ALL
SELECT 'Operadores:' AS tipo, COUNT(*) AS cantidad FROM operadores UNION ALL
SELECT 'Aduanas:' AS tipo, COUNT(*) AS cantidad FROM aduana_chiles UNION ALL
SELECT 'Tipos de Contenedor:' AS tipo, COUNT(*) AS cantidad FROM tipo_contenedors UNION ALL
SELECT 'Lugares de Depósito:' AS tipo, COUNT(*) AS cantidad FROM lugar_depositos UNION ALL
SELECT 'Empresas Transportistas:' AS tipo, COUNT(*) AS cantidad FROM empresa_transportistas UNION ALL
SELECT 'TATCs:' AS tipo, COUNT(*) AS cantidad FROM tatcs UNION ALL
SELECT 'TSTCs:' AS tipo, COUNT(*) AS cantidad FROM tstcs UNION ALL
SELECT 'Salidas:' AS tipo, COUNT(*) AS cantidad FROM salidas;

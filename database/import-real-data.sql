-- =====================================================
-- ARCHIVO DE IMPORTACIÓN CON DATOS REALES
-- Sistema de Administración de Contenedores (Admin-Base)
-- Datos exportados desde SQLite - Fecha: $(date)
-- =====================================================

-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS `admin_base` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `admin_base`;

-- =====================================================
-- ESTRUCTURA DE TABLAS (MySQL)
-- =====================================================

-- Tabla: users
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

-- Tabla: migrations
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: operadores (operadors en SQLite)
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

-- Tabla: aduana_chiles
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

-- Tabla: tipo_contenedors
CREATE TABLE `tipo_contenedors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_tipo` varchar(10) NOT NULL UNIQUE,
  `descripcion` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: lugar_depositos
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

-- Tabla: empresa_transportistas
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

-- Tabla: tatcs
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

-- Tabla: tatc_historials
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

-- Tabla: tstcs
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

-- Tabla: tstc_historials
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

-- Tabla: salidas
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
-- DATOS REALES EXPORTADOS DESDE SQLITE
-- =====================================================

-- NOTA: Los datos reales se encuentran en el archivo database/exports/real-data.sql
-- Este archivo contiene la estructura MySQL compatible
-- Para importar los datos reales, ejecutar:
-- mysql -u [usuario] -p [base_datos] < database/exports/real-data.sql

-- =====================================================
-- ÍNDICES ADICIONALES PARA OPTIMIZACIÓN
-- =====================================================

CREATE INDEX `idx_tatcs_numero_contenedor` ON `tatcs` (`numero_contenedor`);
CREATE INDEX `idx_tatcs_fecha_ingreso` ON `tatcs` (`ingreso_pais`);
CREATE INDEX `idx_tatcs_estado` ON `tatcs` (`estado`);
CREATE INDEX `idx_tstcs_numero_contenedor` ON `tstcs` (`numero_contenedor`);
CREATE INDEX `idx_tstcs_fecha_salida` ON `tstcs` (`salida_pais`);
CREATE INDEX `idx_tstcs_estado` ON `tstcs` (`estado`);
CREATE INDEX `idx_salidas_fecha_salida` ON `salidas` (`fecha_salida`);
CREATE INDEX `idx_salidas_estado` ON `salidas` (`estado`);

-- =====================================================
-- INSTRUCCIONES DE IMPORTACIÓN
-- =====================================================

-- 1. Crear la base de datos y estructura:
--    mysql -u [usuario] -p [base_datos] < database/import-real-data.sql
--
-- 2. Importar los datos reales (convertir de SQLite a MySQL):
--    mysql -u [usuario] -p [base_datos] < database/exports/real-data.sql
--
-- 3. Verificar la importación:
--    SELECT 'Usuarios:' AS tipo, COUNT(*) AS cantidad FROM users UNION ALL
--    SELECT 'Operadores:' AS tipo, COUNT(*) AS cantidad FROM operadores UNION ALL
--    SELECT 'Aduanas:' AS tipo, COUNT(*) AS cantidad FROM aduana_chiles UNION ALL
--    SELECT 'Tipos de Contenedor:' AS tipo, COUNT(*) AS cantidad FROM tipo_contenedors UNION ALL
--    SELECT 'TATCs:' AS tipo, COUNT(*) AS cantidad FROM tatcs UNION ALL
--    SELECT 'TSTCs:' AS tipo, COUNT(*) AS cantidad FROM tstcs UNION ALL
--    SELECT 'Salidas:' AS tipo, COUNT(*) AS cantidad FROM salidas;

#!/bin/bash

# =====================================================
# SCRIPT DE EXPORTACIÓN DE SQLITE A MYSQL
# Sistema de Administración de Contenedores (Admin-Base)
# =====================================================

echo "🚀 Iniciando exportación de SQLite a MySQL..."

# Verificar que existe el archivo SQLite
if [ ! -f "database/database.sqlite" ]; then
    echo "❌ Error: No se encontró database/database.sqlite"
    exit 1
fi

# Crear directorio de exportación si no existe
mkdir -p database/exports

# Nombre del archivo de salida
OUTPUT_FILE="database/exports/real-data-import.sql"

echo "📊 Exportando estructura y datos de SQLite..."

# Crear el archivo SQL con la estructura y datos
cat > "$OUTPUT_FILE" << 'EOF'
-- =====================================================
-- ARCHIVO DE IMPORTACIÓN CON DATOS REALES
-- Exportado desde SQLite - Sistema Admin-Base
-- Fecha: $(date)
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

EOF

echo "📥 Exportando datos reales de SQLite..."

# Exportar datos de usuarios
echo "-- =====================================================" >> "$OUTPUT_FILE"
echo "-- DATOS REALES EXPORTADOS DESDE SQLITE" >> "$OUTPUT_FILE"
echo "-- =====================================================" >> "$OUTPUT_FILE"

# Exportar usuarios
echo "-- Usuarios" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES (' || id || ', ''' || REPLACE(name, '''', '''''') || ''', ''' || email || ''', ' || CASE WHEN email_verified_at IS NULL THEN 'NULL' ELSE '''' || email_verified_at || '''' END || ', ''' || password || ''', ' || CASE WHEN remember_token IS NULL THEN 'NULL' ELSE '''' || remember_token || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM users;" >> "$OUTPUT_FILE"

# Exportar operadores
echo "" >> "$OUTPUT_FILE"
echo "-- Operadores" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO operadores (id, codigo_operador, nombre_operador, rut_operador, direccion_operador, telefono_operador, email_operador, estado, created_at, updated_at) VALUES (' || id || ', ''' || codigo_operador || ''', ''' || REPLACE(nombre_operador, '''', '''''') || ''', ''' || rut_operador || ''', ' || CASE WHEN direccion_operador IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion_operador, '''', '''''') || '''' END || ', ' || CASE WHEN telefono_operador IS NULL THEN 'NULL' ELSE '''' || telefono_operador || '''' END || ', ' || CASE WHEN email_operador IS NULL THEN 'NULL' ELSE '''' || email_operador || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM operadores;" >> "$OUTPUT_FILE"

# Exportar aduanas
echo "" >> "$OUTPUT_FILE"
echo "-- Aduanas" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO aduana_chiles (id, codigo, nombre_aduana, region, estado, created_at, updated_at) VALUES (' || id || ', ''' || codigo || ''', ''' || REPLACE(nombre_aduana, '''', '''''') || ''', ' || CASE WHEN region IS NULL THEN 'NULL' ELSE '''' || region || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM aduana_chiles;" >> "$OUTPUT_FILE"

# Exportar tipos de contenedores
echo "" >> "$OUTPUT_FILE"
echo "-- Tipos de Contenedores" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tipo_contenedors (id, codigo_tipo, descripcion, estado, created_at, updated_at) VALUES (' || id || ', ''' || codigo_tipo || ''', ''' || REPLACE(descripcion, '''', '''''') || ''', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tipo_contenedors;" >> "$OUTPUT_FILE"

# Exportar lugares de depósito
echo "" >> "$OUTPUT_FILE"
echo "-- Lugares de Depósito" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO lugar_depositos (id, codigo_lugar, nombre_lugar, direccion_lugar, estado, created_at, updated_at) VALUES (' || id || ', ''' || codigo_lugar || ''', ''' || REPLACE(nombre_lugar, '''', '''''') || ''', ' || CASE WHEN direccion_lugar IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion_lugar, '''', '''''') || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM lugar_depositos;" >> "$OUTPUT_FILE"

# Exportar empresas transportistas
echo "" >> "$OUTPUT_FILE"
echo "-- Empresas Transportistas" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO empresa_transportistas (id, codigo_empresa, nombre_empresa, rut_empresa, direccion_empresa, telefono_empresa, email_empresa, estado, created_at, updated_at) VALUES (' || id || ', ''' || codigo_empresa || ''', ''' || REPLACE(nombre_empresa, '''', '''''') || ''', ''' || rut_empresa || ''', ' || CASE WHEN direccion_empresa IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion_empresa, '''', '''''') || '''' END || ', ' || CASE WHEN telefono_empresa IS NULL THEN 'NULL' ELSE '''' || telefono_empresa || '''' END || ', ' || CASE WHEN email_empresa IS NULL THEN 'NULL' ELSE '''' || email_empresa || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM empresa_transportistas;" >> "$OUTPUT_FILE"

# Exportar TATCs
echo "" >> "$OUTPUT_FILE"
echo "-- TATCs" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tatcs (id, numero_tatc, user_id, operador_id, tipo_ingreso, ingreso_pais, numero_contenedor, tatc_origen, tipo_contenedor_id, ingreso_deposito, documento_ingreso, fecha_traspaso, tara_contenedor, tipo_bulto, valor_fob, valor_cif, comentario, aduana_ingreso_id, eir, tamano_contenedor, puerto_ingreso, estado_contenedor, ano_fabricacion, ubicacion_fisica, estado, created_at, updated_at) VALUES (' || id || ', ''' || numero_tatc || ''', ' || user_id || ', ' || operador_id || ', ''' || tipo_ingreso || ''', ''' || ingreso_pais || ''', ''' || numero_contenedor || ''', ' || CASE WHEN tatc_origen IS NULL THEN 'NULL' ELSE '''' || tatc_origen || '''' END || ', ' || tipo_contenedor_id || ', ''' || ingreso_deposito || ''', ''' || documento_ingreso || ''', ' || CASE WHEN fecha_traspaso IS NULL THEN 'NULL' ELSE '''' || fecha_traspaso || '''' END || ', ' || tara_contenedor || ', ''' || tipo_bulto || ''', ' || valor_fob || ', ' || valor_cif || ', ' || CASE WHEN comentario IS NULL THEN 'NULL' ELSE '''' || REPLACE(comentario, '''', '''''') || '''' END || ', ' || aduana_ingreso_id || ', ' || CASE WHEN eir IS NULL THEN 'NULL' ELSE '''' || eir || '''' END || ', ''' || tamano_contenedor || ''', ''' || puerto_ingreso || ''', ''' || estado_contenedor || ''', ' || ano_fabricacion || ', ' || CASE WHEN ubicacion_fisica IS NULL THEN 'NULL' ELSE '''' || ubicacion_fisica || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tatcs;" >> "$OUTPUT_FILE"

# Exportar TSTCs
echo "" >> "$OUTPUT_FILE"
echo "-- TSTCs" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tstcs (id, numero_tstc, user_id, operador_id, tipo_salida, salida_pais, numero_contenedor, tstc_origen, tipo_contenedor_id, salida_deposito, documento_salida, fecha_traspaso, tara_contenedor, tipo_bulto, valor_fob, valor_cif, comentario, aduana_salida_id, eir, tamano_contenedor, puerto_salida, estado_contenedor, ano_fabricacion, ubicacion_fisica, estado, created_at, updated_at) VALUES (' || id || ', ''' || numero_tstc || ''', ' || user_id || ', ' || operador_id || ', ''' || tipo_salida || ''', ''' || salida_pais || ''', ''' || numero_contenedor || ''', ' || CASE WHEN tstc_origen IS NULL THEN 'NULL' ELSE '''' || tstc_origen || '''' END || ', ' || tipo_contenedor_id || ', ''' || salida_deposito || ''', ''' || documento_salida || ''', ' || CASE WHEN fecha_traspaso IS NULL THEN 'NULL' ELSE '''' || fecha_traspaso || '''' END || ', ' || tara_contenedor || ', ''' || tipo_bulto || ''', ' || valor_fob || ', ' || valor_cif || ', ' || CASE WHEN comentario IS NULL THEN 'NULL' ELSE '''' || REPLACE(comentario, '''', '''''') || '''' END || ', ' || aduana_salida_id || ', ' || CASE WHEN eir IS NULL THEN 'NULL' ELSE '''' || eir || '''' END || ', ''' || tamano_contenedor || ''', ''' || puerto_salida || ''', ''' || estado_contenedor || ''', ' || ano_fabricacion || ', ' || CASE WHEN ubicacion_fisica IS NULL THEN 'NULL' ELSE '''' || ubicacion_fisica || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tstcs;" >> "$OUTPUT_FILE"

# Exportar salidas
echo "" >> "$OUTPUT_FILE"
echo "-- Salidas" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO salidas (id, tatc_id, numero_salida, fecha_salida, tipo_salida, motivo_salida, numero_contenedor, aduana_salida_id, empresa_transportista_id, rut_chofer, patente_camion, destino_final, pais_destino, observaciones, estado, user_id, created_at, updated_at) VALUES (' || id || ', ' || tatc_id || ', ''' || numero_salida || ''', ''' || fecha_salida || ''', ''' || tipo_salida || ''', ''' || REPLACE(motivo_salida, '''', '''''') || ''', ''' || numero_contenedor || ''', ' || aduana_salida_id || ', ' || CASE WHEN empresa_transportista_id IS NULL THEN 'NULL' ELSE empresa_transportista_id END || ', ' || CASE WHEN rut_chofer IS NULL THEN 'NULL' ELSE '''' || rut_chofer || '''' END || ', ' || CASE WHEN patente_camion IS NULL THEN 'NULL' ELSE '''' || patente_camion || '''' END || ', ' || CASE WHEN destino_final IS NULL THEN 'NULL' ELSE '''' || destino_final || '''' END || ', ' || CASE WHEN pais_destino IS NULL THEN 'NULL' ELSE '''' || pais_destino || '''' END || ', ' || CASE WHEN observaciones IS NULL THEN 'NULL' ELSE '''' || REPLACE(observaciones, '''', '''''') || '''' END || ', ''' || estado || ''', ' || user_id || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM salidas;" >> "$OUTPUT_FILE"

# Exportar historiales
echo "" >> "$OUTPUT_FILE"
echo "-- Historiales TATC" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tatc_historials (id, tatc_id, user_id, accion, detalles, datos_anteriores, datos_nuevos, estado_anterior, estado_nuevo, created_at, updated_at) VALUES (' || id || ', ' || tatc_id || ', ' || user_id || ', ''' || accion || ''', ' || CASE WHEN detalles IS NULL THEN 'NULL' ELSE '''' || REPLACE(detalles, '''', '''''') || '''' END || ', ' || CASE WHEN datos_anteriores IS NULL THEN 'NULL' ELSE '''' || datos_anteriores || '''' END || ', ' || CASE WHEN datos_nuevos IS NULL THEN 'NULL' ELSE '''' || datos_nuevos || '''' END || ', ' || CASE WHEN estado_anterior IS NULL THEN 'NULL' ELSE '''' || estado_anterior || '''' END || ', ' || CASE WHEN estado_nuevo IS NULL THEN 'NULL' ELSE '''' || estado_nuevo || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tatc_historials;" >> "$OUTPUT_FILE"

echo "" >> "$OUTPUT_FILE"
echo "-- Historiales TSTC" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tstc_historials (id, tstc_id, user_id, accion, detalles, datos_anteriores, datos_nuevos, estado_anterior, estado_nuevo, created_at, updated_at) VALUES (' || id || ', ' || tstc_id || ', ' || user_id || ', ''' || accion || ''', ' || CASE WHEN detalles IS NULL THEN 'NULL' ELSE '''' || REPLACE(detalles, '''', '''''') || '''' END || ', ' || CASE WHEN datos_anteriores IS NULL THEN 'NULL' ELSE '''' || datos_anteriores || '''' END || ', ' || CASE WHEN datos_nuevos IS NULL THEN 'NULL' ELSE '''' || datos_nuevos || '''' END || ', ' || CASE WHEN estado_anterior IS NULL THEN 'NULL' ELSE '''' || estado_anterior || '''' END || ', ' || CASE WHEN estado_nuevo IS NULL THEN 'NULL' ELSE '''' || estado_nuevo || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tstc_historials;" >> "$OUTPUT_FILE"

# Exportar migraciones
echo "" >> "$OUTPUT_FILE"
echo "-- Migraciones" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO migrations (id, migration, batch) VALUES (' || id || ', ''' || migration || ''', ' || batch || ');' FROM migrations;" >> "$OUTPUT_FILE"

# Agregar índices y finalización
cat >> "$OUTPUT_FILE" << 'EOF'

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
SELECT 'Base de datos importada exitosamente con datos reales' AS mensaje;

-- Mostrar resumen de datos importados
SELECT 'Resumen de datos reales importados:' AS titulo;
SELECT 'Usuarios:' AS tipo, COUNT(*) AS cantidad FROM users UNION ALL
SELECT 'Operadores:' AS tipo, COUNT(*) AS cantidad FROM operadores UNION ALL
SELECT 'Aduanas:' AS tipo, COUNT(*) AS cantidad FROM aduana_chiles UNION ALL
SELECT 'Tipos de Contenedor:' AS tipo, COUNT(*) AS cantidad FROM tipo_contenedors UNION ALL
SELECT 'Lugares de Depósito:' AS tipo, COUNT(*) AS cantidad FROM lugar_depositos UNION ALL
SELECT 'Empresas Transportistas:' AS tipo, COUNT(*) AS cantidad FROM empresa_transportistas UNION ALL
SELECT 'TATCs:' AS tipo, COUNT(*) AS cantidad FROM tatcs UNION ALL
SELECT 'TSTCs:' AS tipo, COUNT(*) AS cantidad FROM tstcs UNION ALL
SELECT 'Salidas:' AS tipo, COUNT(*) AS cantidad FROM salidas UNION ALL
SELECT 'Historiales TATC:' AS tipo, COUNT(*) AS cantidad FROM tatc_historials UNION ALL
SELECT 'Historiales TSTC:' AS tipo, COUNT(*) AS cantidad FROM tstc_historials;
EOF

echo "✅ Exportación completada exitosamente!"
echo "📁 Archivo generado: $OUTPUT_FILE"
echo ""
echo "📋 Para importar en MySQL:"
echo "   mysql -u [usuario] -p [base_datos] < $OUTPUT_FILE"
echo ""
echo "📊 Resumen de datos exportados:"

# Mostrar resumen de datos exportados
echo "   - Usuarios: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM users;")"
echo "   - Operadores: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM operadores;")"
echo "   - Aduanas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM aduana_chiles;")"
echo "   - Tipos de Contenedor: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tipo_contenedors;")"
echo "   - Lugares de Depósito: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM lugar_depositos;")"
echo "   - Empresas Transportistas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM empresa_transportistas;")"
echo "   - TATCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tatcs;")"
echo "   - TSTCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tstcs;")"
echo "   - Salidas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM salidas;")"
echo "   - Historiales TATC: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tatc_historials;")"
echo "   - Historiales TSTC: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tstc_historials;")"

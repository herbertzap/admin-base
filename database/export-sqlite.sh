#!/bin/bash

echo "🚀 Exportando datos reales de SQLite a MySQL..."

# Verificar que existe el archivo SQLite
if [ ! -f "database/database.sqlite" ]; then
    echo "❌ Error: No se encontró database/database.sqlite"
    exit 1
fi

# Crear directorio de exportación
mkdir -p database/exports

# Nombre del archivo de salida
OUTPUT_FILE="database/exports/real-data-import.sql"

echo "📊 Exportando datos reales..."

# Crear el archivo SQL con estructura y datos reales
cat > "$OUTPUT_FILE" << 'EOF'
-- =====================================================
-- ARCHIVO DE IMPORTACIÓN CON DATOS REALES
-- Exportado desde SQLite - Sistema Admin-Base
-- =====================================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS `admin_base` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `admin_base`;

-- Estructura de tablas (incluir aquí la estructura completa)
-- ... (estructura de tablas)

-- Datos reales exportados desde SQLite:
EOF

# Exportar datos reales usando sqlite3
echo "-- Datos reales de usuarios:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO users VALUES (' || id || ', ''' || REPLACE(name, '''', '''''') || ''', ''' || email || ''', ' || CASE WHEN email_verified_at IS NULL THEN 'NULL' ELSE '''' || email_verified_at || '''' END || ', ''' || password || ''', ' || CASE WHEN remember_token IS NULL THEN 'NULL' ELSE '''' || remember_token || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM users;" >> "$OUTPUT_FILE"

echo "-- Datos reales de operadores:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO operadores VALUES (' || id || ', ''' || codigo_operador || ''', ''' || REPLACE(nombre_operador, '''', '''''') || ''', ''' || rut_operador || ''', ' || CASE WHEN direccion_operador IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion_operador, '''', '''''') || '''' END || ', ' || CASE WHEN telefono_operador IS NULL THEN 'NULL' ELSE '''' || telefono_operador || '''' END || ', ' || CASE WHEN email_operador IS NULL THEN 'NULL' ELSE '''' || email_operador || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM operadores;" >> "$OUTPUT_FILE"

echo "-- Datos reales de aduanas:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO aduana_chiles VALUES (' || id || ', ''' || codigo || ''', ''' || REPLACE(nombre_aduana, '''', '''''') || ''', ' || CASE WHEN region IS NULL THEN 'NULL' ELSE '''' || region || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM aduana_chiles;" >> "$OUTPUT_FILE"

echo "-- Datos reales de tipos de contenedores:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tipo_contenedors VALUES (' || id || ', ''' || codigo_tipo || ''', ''' || REPLACE(descripcion, '''', '''''') || ''', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tipo_contenedors;" >> "$OUTPUT_FILE"

echo "-- Datos reales de TATCs:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tatcs VALUES (' || id || ', ''' || numero_tatc || ''', ' || user_id || ', ' || operador_id || ', ''' || tipo_ingreso || ''', ''' || ingreso_pais || ''', ''' || numero_contenedor || ''', ' || CASE WHEN tatc_origen IS NULL THEN 'NULL' ELSE '''' || tatc_origen || '''' END || ', ' || tipo_contenedor_id || ', ''' || ingreso_deposito || ''', ''' || documento_ingreso || ''', ' || CASE WHEN fecha_traspaso IS NULL THEN 'NULL' ELSE '''' || fecha_traspaso || '''' END || ', ' || tara_contenedor || ', ''' || tipo_bulto || ''', ' || valor_fob || ', ' || valor_cif || ', ' || CASE WHEN comentario IS NULL THEN 'NULL' ELSE '''' || REPLACE(comentario, '''', '''''') || '''' END || ', ' || aduana_ingreso_id || ', ' || CASE WHEN eir IS NULL THEN 'NULL' ELSE '''' || eir || '''' END || ', ''' || tamano_contenedor || ''', ''' || puerto_ingreso || ''', ''' || estado_contenedor || ''', ' || ano_fabricacion || ', ' || CASE WHEN ubicacion_fisica IS NULL THEN 'NULL' ELSE '''' || ubicacion_fisica || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tatcs;" >> "$OUTPUT_FILE"

echo "-- Datos reales de TSTCs:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tstcs VALUES (' || id || ', ''' || numero_tstc || ''', ' || user_id || ', ' || operador_id || ', ''' || tipo_salida || ''', ''' || salida_pais || ''', ''' || numero_contenedor || ''', ' || CASE WHEN tstc_origen IS NULL THEN 'NULL' ELSE '''' || tstc_origen || '''' END || ', ' || tipo_contenedor_id || ', ''' || salida_deposito || ''', ''' || documento_salida || ''', ' || CASE WHEN fecha_traspaso IS NULL THEN 'NULL' ELSE '''' || fecha_traspaso || '''' END || ', ' || tara_contenedor || ', ''' || tipo_bulto || ''', ' || valor_fob || ', ' || valor_cif || ', ' || CASE WHEN comentario IS NULL THEN 'NULL' ELSE '''' || REPLACE(comentario, '''', '''''') || '''' END || ', ' || aduana_salida_id || ', ' || CASE WHEN eir IS NULL THEN 'NULL' ELSE '''' || eir || '''' END || ', ''' || tamano_contenedor || ''', ''' || puerto_salida || ''', ''' || estado_contenedor || ''', ' || ano_fabricacion || ', ' || CASE WHEN ubicacion_fisica IS NULL THEN 'NULL' ELSE '''' || ubicacion_fisica || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tstcs;" >> "$OUTPUT_FILE"

echo "✅ Exportación completada!"
echo "📁 Archivo: $OUTPUT_FILE"
echo ""
echo "📊 Resumen de datos exportados:"
echo "   - Usuarios: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM users;")"
echo "   - Operadores: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM operadores;")"
echo "   - Aduanas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM aduana_chiles;")"
echo "   - Tipos de Contenedor: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tipo_contenedors;")"
echo "   - TATCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tatcs;")"
echo "   - TSTCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tstcs;")"

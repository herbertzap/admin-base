#!/bin/bash

# Script simplificado para exportar datos básicos de SQLite a MySQL
# Sistema de Gestión de Contenedores - Admin Base

set -e

# Colores para output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

print_message() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_header() {
    echo -e "${BLUE}================================${NC}"
    echo -e "${BLUE} $1${NC}"
    echo -e "${BLUE}================================${NC}"
}

# Verificar que existe la base de datos SQLite
if [ ! -f "database/database.sqlite" ]; then
    echo "❌ Error: No se encontró database/database.sqlite"
    echo "Ejecuta primero: ./database/setup-and-export.sh setup-sqlite"
    exit 1
fi

# Crear directorio de exportación
mkdir -p database/exports

# Nombre del archivo de salida
OUTPUT_FILE="database/exports/simple-export-$(date +%Y%m%d_%H%M%S).sql"

print_header "Exportación Simplificada SQLite a MySQL"

print_message "Creando archivo de exportación: $OUTPUT_FILE"

# Crear el archivo SQL con estructura y datos
cat > "$OUTPUT_FILE" << 'EOF'
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
EOF

# Exportar datos de usuarios
print_message "Exportando usuarios..."
echo "-- Datos de usuarios:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO users VALUES (' || id || ', ''' || REPLACE(name, '''', '''''') || ''', ''' || email || ''', ' || CASE WHEN email_verified_at IS NULL THEN 'NULL' ELSE '''' || email_verified_at || '''' END || ', ' || CASE WHEN phone IS NULL THEN 'NULL' ELSE '''' || phone || '''' END || ', ' || CASE WHEN location IS NULL THEN 'NULL' ELSE '''' || location || '''' END || ', ' || CASE WHEN about IS NULL THEN 'NULL' ELSE '''' || REPLACE(about, '''', '''''') || '''' END || ', ''' || password || ''', ' || CASE WHEN remember_token IS NULL THEN 'NULL' ELSE '''' || remember_token || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ', ' || CASE WHEN operador_id IS NULL THEN 'NULL' ELSE operador_id END || ', ' || CASE WHEN fotografia IS NULL THEN 'NULL' ELSE '''' || fotografia || '''' END || ', ' || CASE WHEN rut_usuario IS NULL THEN 'NULL' ELSE '''' || rut_usuario || '''' END || ', ''' || estado || ''', ' || CASE WHEN ultimo_movimiento IS NULL THEN 'NULL' ELSE '''' || ultimo_movimiento || '''' END || ', ' || CASE WHEN fecha_renovacion_password IS NULL THEN 'NULL' ELSE '''' || fecha_renovacion_password || '''' END || ', ' || cambio_password_requerido || ');' FROM users;" >> "$OUTPUT_FILE"

# Exportar datos de operadores
print_message "Exportando operadores..."
echo "-- Datos de operadores:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO operadors VALUES (' || id || ', ''' || codigo || ''', ''' || rut_operador || ''', ''' || REPLACE(nombre_operador, '''', '''''') || ''', ' || CASE WHEN nombre_fantasia IS NULL THEN 'NULL' ELSE '''' || nombre_fantasia || '''' END || ', ' || CASE WHEN direccion_operador IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion_operador, '''', '''''') || '''' END || ', ' || CASE WHEN resolucion_operador IS NULL THEN 'NULL' ELSE '''' || resolucion_operador || '''' END || ', ' || CASE WHEN logo_operador IS NULL THEN 'NULL' ELSE '''' || logo_operador || '''' END || ', ' || CASE WHEN firma_operador IS NULL THEN 'NULL' ELSE '''' || firma_operador || '''' END || ', ' || CASE WHEN rut_representante IS NULL THEN 'NULL' ELSE '''' || rut_representante || '''' END || ', ' || CASE WHEN nombre_representante IS NULL THEN 'NULL' ELSE '''' || nombre_representante || '''' END || ', ' || CASE WHEN cargo_representante IS NULL THEN 'NULL' ELSE '''' || cargo_representante || '''' END || ', ''' || estado || ''', ' || CASE WHEN fecha_creacion IS NULL THEN 'NULL' ELSE '''' || fecha_creacion || '''' END || ', ' || CASE WHEN fecha_actualizacion IS NULL THEN 'NULL' ELSE '''' || fecha_actualizacion || '''' END || ', ' || CASE WHEN usuario_id IS NULL THEN 'NULL' ELSE usuario_id END || ', ' || CASE WHEN nombre_remitente IS NULL THEN 'NULL' ELSE '''' || nombre_remitente || '''' END || ', ' || CASE WHEN email_remitente IS NULL THEN 'NULL' ELSE '''' || email_remitente || '''' END || ', ' || CASE WHEN email_copia IS NULL THEN 'NULL' ELSE '''' || email_copia || '''' END || ', ' || valida_ingreso_aduana || ', ' || CASE WHEN email_notificaciones IS NULL THEN 'NULL' ELSE '''' || email_notificaciones || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM operadors;" >> "$OUTPUT_FILE"

# Exportar datos de aduanas
print_message "Exportando aduanas..."
echo "-- Datos de aduanas:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO aduana_chiles VALUES (' || id || ', ''' || codigo || ''', ''' || REPLACE(nombre_aduana, '''', '''''') || ''', ' || CASE WHEN ubicacion IS NULL THEN 'NULL' ELSE '''' || ubicacion || '''' END || ', ' || CASE WHEN region IS NULL THEN 'NULL' ELSE '''' || region || '''' END || ', ' || CASE WHEN direccion IS NULL THEN 'NULL' ELSE '''' || direccion || '''' END || ', ' || CASE WHEN telefono IS NULL THEN 'NULL' ELSE '''' || telefono || '''' END || ', ' || CASE WHEN email IS NULL THEN 'NULL' ELSE '''' || email || '''' END || ', ''' || estado || ''', ' || CASE WHEN observaciones IS NULL THEN 'NULL' ELSE '''' || REPLACE(observaciones, '''', '''''') || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM aduana_chiles;" >> "$OUTPUT_FILE"

# Exportar datos de tipos de contenedores
print_message "Exportando tipos de contenedores..."
echo "-- Datos de tipos de contenedores:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tipo_contenedors VALUES (' || id || ', ''' || codigo || ''', ''' || REPLACE(descripcion, '''', '''''') || ''', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ', ' || CASE WHEN operador_id IS NULL THEN 'NULL' ELSE operador_id END || ');' FROM tipo_contenedors;" >> "$OUTPUT_FILE"

# Exportar datos de empresas transportistas
print_message "Exportando empresas transportistas..."
echo "-- Datos de empresas transportistas:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO empresa_transportistas VALUES (' || id || ', ''' || REPLACE(nombre_empresa, '''', '''''') || ''', ''' || rut_empresa || ''', ' || CASE WHEN direccion IS NULL THEN 'NULL' ELSE '''' || direccion || '''' END || ', ' || CASE WHEN ciudad IS NULL THEN 'NULL' ELSE '''' || ciudad || '''' END || ', ' || CASE WHEN telefono IS NULL THEN 'NULL' ELSE '''' || telefono || '''' END || ', ' || CASE WHEN email IS NULL THEN 'NULL' ELSE '''' || email || '''' END || ', ' || CASE WHEN contacto_persona IS NULL THEN 'NULL' ELSE '''' || contacto_persona || '''' END || ', ' || CASE WHEN contacto_telefono IS NULL THEN 'NULL' ELSE '''' || contacto_telefono || '''' END || ', ' || CASE WHEN contacto_email IS NULL THEN 'NULL' ELSE '''' || contacto_email || '''' END || ', ''' || estado || ''', ' || CASE WHEN observaciones IS NULL THEN 'NULL' ELSE '''' || REPLACE(observaciones, '''', '''''') || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM empresa_transportistas;" >> "$OUTPUT_FILE"

# Exportar datos de lugares de depósito
print_message "Exportando lugares de depósito..."
echo "-- Datos de lugares de depósito:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO lugar_depositos VALUES (' || id || ', ''' || codigo || ''', ''' || REPLACE(nombre_deposito, '''', '''''') || ''', ' || CASE WHEN direccion IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion, '''', '''''') || '''' END || ', ' || CASE WHEN ciudad IS NULL THEN 'NULL' ELSE '''' || ciudad || '''' END || ', ' || CASE WHEN region IS NULL THEN 'NULL' ELSE '''' || region || '''' END || ', ' || CASE WHEN capacidad IS NULL THEN 'NULL' ELSE '''' || capacidad || '''' END || ', ' || CASE WHEN telefono IS NULL THEN 'NULL' ELSE '''' || telefono || '''' END || ', ' || CASE WHEN email IS NULL THEN 'NULL' ELSE '''' || email || '''' END || ', ' || CASE WHEN operador_id IS NULL THEN 'NULL' ELSE operador_id END || ', ''' || estado || ''', ' || CASE WHEN observaciones IS NULL THEN 'NULL' ELSE '''' || REPLACE(observaciones, '''', '''''') || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM lugar_depositos;" >> "$OUTPUT_FILE"

# Exportar datos de tickets
print_message "Exportando tickets..."
echo "-- Datos de tickets:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO tickets VALUES (' || id || ', ''' || REPLACE(titulo, '''', '''''') || ''', ''' || REPLACE(descripcion, '''', '''''') || ''', ''' || estado || ''', ' || user_id || ', ' || CASE WHEN asignado_a IS NULL THEN 'NULL' ELSE asignado_a END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tickets;" >> "$OUTPUT_FILE"

# Exportar datos de companies
print_message "Exportando companies..."
echo "-- Datos de companies:" >> "$OUTPUT_FILE"
sqlite3 database/database.sqlite "SELECT 'INSERT INTO companies VALUES (' || id || ', ''' || REPLACE(name, '''', '''''') || ''', ''' || rut || ''', ''' || REPLACE(address, '''', '''''') || ''', ''' || city || ''', ''' || phone || ''', ''' || email || ''', ''' || REPLACE(contact_person, '''', '''''') || ''', ''' || contact_phone || ''', ''' || contact_email || ''', ' || is_active || ', ' || CASE WHEN notes IS NULL THEN 'NULL' ELSE '''' || REPLACE(notes, '''', '''''') || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM companies;" >> "$OUTPUT_FILE"

# Habilitar foreign keys
echo "SET FOREIGN_KEY_CHECKS = 1;" >> "$OUTPUT_FILE"

print_message "✅ Exportación simplificada completada!"
print_message "📁 Archivo: $OUTPUT_FILE"

# Mostrar resumen de datos exportados
print_header "Resumen de datos exportados"
echo "   - Usuarios: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM users;")"
echo "   - Operadores: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM operadors;")"
echo "   - Aduanas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM aduana_chiles;")"
echo "   - Tipos de Contenedor: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tipo_contenedors;")"
echo "   - Empresas Transportistas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM empresa_transportistas;")"
echo "   - Lugares de Depósito: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM lugar_depositos;")"
echo "   - Tickets: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tickets;")"
echo "   - Companies: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM companies;")"

print_message "🎉 ¡Archivo de exportación listo para importar en MySQL!"

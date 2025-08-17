#!/bin/bash

# Script para configurar SQLite desde real-data.sql y exportar a MySQL
# Sistema de Gestión de Contenedores - Admin Base

set -e

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_message() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_header() {
    echo -e "${BLUE}================================${NC}"
    echo -e "${BLUE} $1${NC}"
    echo -e "${BLUE}================================${NC}"
}

# Función para mostrar ayuda
show_help() {
    echo "Uso: $0 [OPCIÓN]"
    echo ""
    echo "Opciones:"
    echo "  setup-sqlite     Configurar SQLite desde real-data.sql"
    echo "  export-mysql     Exportar datos de SQLite a MySQL"
    echo "  full-setup       Configurar SQLite y exportar a MySQL"
    echo "  backup-sqlite    Crear backup de SQLite"
    echo "  help             Mostrar esta ayuda"
    echo ""
    echo "Ejemplos:"
    echo "  $0 setup-sqlite"
    echo "  $0 export-mysql"
    echo "  $0 full-setup"
}

# Función para configurar SQLite desde real-data.sql
setup_sqlite() {
    print_header "Configurando SQLite desde real-data.sql"
    
    # Verificar que existe el archivo real-data.sql
    if [ ! -f "database/real-data.sql" ]; then
        print_error "No se encontró database/real-data.sql"
        exit 1
    fi

    # Crear directorio de base de datos si no existe
    mkdir -p database

    # Crear base de datos SQLite desde el archivo
    print_message "Creando base de datos SQLite..."
    sqlite3 database/database.sqlite < database/real-data.sql
    
    if [ $? -eq 0 ]; then
        print_message "✅ Base de datos SQLite creada exitosamente"
    else
        print_error "❌ Error al crear la base de datos SQLite"
        exit 1
    fi

    # Verificar que la base de datos se creó correctamente
    print_message "Verificando base de datos..."
    RECORD_COUNT=$(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM users;")
    print_message "Usuarios en la base de datos: $RECORD_COUNT"

    # Mostrar resumen de tablas y registros
    print_header "Resumen de la base de datos SQLite"
    echo "   - Usuarios: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM users;")"
    echo "   - Operadores: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM operadors;")"
    echo "   - Aduanas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM aduana_chiles;")"
    echo "   - Tipos de Contenedor: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tipo_contenedors;")"
    echo "   - Empresas Transportistas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM empresa_transportistas;")"
    echo "   - Lugares de Depósito: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM lugar_depositos;")"
    echo "   - TATCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tatcs;")"
    echo "   - TSTCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tstcs;")"
    echo "   - Salidas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM salidas;")"
    echo "   - Tickets: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tickets;")"
    echo "   - Companies: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM companies;")"
}

# Función para exportar datos de SQLite a MySQL
export_to_mysql() {
    print_header "Exportando datos de SQLite a MySQL"
    
    # Verificar que existe la base de datos SQLite
    if [ ! -f "database/database.sqlite" ]; then
        print_error "No se encontró database/database.sqlite"
        print_message "Ejecuta primero: $0 setup-sqlite"
        exit 1
    fi

    # Crear directorio de exportación
    mkdir -p database/exports

    # Nombre del archivo de salida
    OUTPUT_FILE="database/exports/sqlite-to-mysql-$(date +%Y%m%d_%H%M%S).sql"

    print_message "Creando archivo de exportación: $OUTPUT_FILE"

    # Crear el archivo SQL con estructura y datos
    cat > "$OUTPUT_FILE" << 'EOF'
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

    # Exportar datos de TATCs
    print_message "Exportando TATCs..."
    echo "-- Datos de TATCs:" >> "$OUTPUT_FILE"
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO tatcs VALUES (' || id || ', ''' || numero_tatc || ''', ' || user_id || ', ' || operador_id || ', ''' || tipo_ingreso || ''', ''' || ingreso_pais || ''', ''' || numero_contenedor || ''', ' || CASE WHEN tatc_origen IS NULL THEN 'NULL' ELSE '''' || tatc_origen || '''' END || ', ' || tipo_contenedor_id || ', ''' || ingreso_deposito || ''', ''' || documento_ingreso || ''', ' || CASE WHEN fecha_traspaso IS NULL THEN 'NULL' ELSE '''' || fecha_traspaso || '''' END || ', ' || tara_contenedor || ', ''' || tipo_bulto || ''', ' || valor_fob || ', ' || valor_cif || ', ' || CASE WHEN comentario IS NULL THEN 'NULL' ELSE '''' || REPLACE(comentario, '''', '''''') || '''' END || ', ' || aduana_ingreso_id || ', ' || CASE WHEN eir IS NULL THEN 'NULL' ELSE '''' || eir || '''' END || ', ''' || tamano_contenedor || ''', ''' || puerto_ingreso || ''', ''' || estado_contenedor || ''', ' || ano_fabricacion || ', ' || CASE WHEN ubicacion_fisica IS NULL THEN 'NULL' ELSE '''' || ubicacion_fisica || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tatcs;" >> "$OUTPUT_FILE"

    # Exportar datos de TSTCs
    print_message "Exportando TSTCs..."
    echo "-- Datos de TSTCs:" >> "$OUTPUT_FILE"
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO tstcs VALUES (' || id || ', ''' || numero_tstc || ''', ' || user_id || ', ' || operador_id || ', ''' || tipo_salida || ''', ''' || salida_pais || ''', ''' || numero_contenedor || ''', ' || CASE WHEN tstc_origen IS NULL THEN 'NULL' ELSE '''' || tstc_origen || '''' END || ', ' || tipo_contenedor_id || ', ''' || salida_deposito || ''', ''' || documento_salida || ''', ' || CASE WHEN fecha_traspaso IS NULL THEN 'NULL' ELSE '''' || fecha_traspaso || '''' END || ', ' || tara_contenedor || ', ''' || tipo_bulto || ''', ' || valor_fob || ', ' || valor_cif || ', ' || CASE WHEN comentario IS NULL THEN 'NULL' ELSE '''' || REPLACE(comentario, '''', '''''') || '''' END || ', ' || aduana_salida_id || ', ' || CASE WHEN eir IS NULL THEN 'NULL' ELSE '''' || eir || '''' END || ', ''' || tamano_contenedor || ''', ''' || puerto_salida || ''', ''' || estado_contenedor || ''', ' || ano_fabricacion || ', ' || CASE WHEN ubicacion_fisica IS NULL THEN 'NULL' ELSE '''' || ubicacion_fisica || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tstcs;" >> "$OUTPUT_FILE"

    # Exportar datos de salidas
    print_message "Exportando salidas..."
    echo "-- Datos de salidas:" >> "$OUTPUT_FILE"
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO salidas VALUES (' || id || ', ''' || numero_salida || ''', ' || user_id || ', ' || operador_id || ', ' || tatc_id || ', ''' || tipo_salida || ''', ''' || salida_pais || ''', ''' || numero_contenedor || ''', ' || tipo_contenedor_id || ', ''' || salida_deposito || ''', ''' || documento_salida || ''', ' || CASE WHEN fecha_salida IS NULL THEN 'NULL' ELSE '''' || fecha_salida || '''' END || ', ' || tara_contenedor || ', ''' || tipo_bulto || ''', ' || valor_fob || ', ' || valor_cif || ', ' || CASE WHEN comentario IS NULL THEN 'NULL' ELSE '''' || REPLACE(comentario, '''', '''''') || '''' END || ', ' || aduana_salida_id || ', ' || CASE WHEN eir IS NULL THEN 'NULL' ELSE '''' || eir || '''' END || ', ''' || tamano_contenedor || ''', ''' || puerto_salida || ''', ''' || estado_contenedor || ''', ' || ano_fabricacion || ', ' || CASE WHEN ubicacion_fisica IS NULL THEN 'NULL' ELSE '''' || ubicacion_fisica || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM salidas;" >> "$OUTPUT_FILE"

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

    print_message "✅ Exportación completada!"
    print_message "📁 Archivo: $OUTPUT_FILE"
    
    # Mostrar resumen de datos exportados
    print_header "Resumen de datos exportados"
    echo "   - Usuarios: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM users;")"
    echo "   - Operadores: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM operadors;")"
    echo "   - Aduanas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM aduana_chiles;")"
    echo "   - Tipos de Contenedor: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tipo_contenedors;")"
    echo "   - Empresas Transportistas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM empresa_transportistas;")"
    echo "   - Lugares de Depósito: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM lugar_depositos;")"
    echo "   - TATCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tatcs;")"
    echo "   - TSTCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tstcs;")"
    echo "   - Salidas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM salidas;")"
    echo "   - Tickets: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tickets;")"
    echo "   - Companies: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM companies;")"
}

# Función para configuración completa
full_setup() {
    print_header "Configuración completa: SQLite + Exportación a MySQL"
    
    print_message "1. Configurando SQLite..."
    setup_sqlite
    
    print_message "2. Exportando datos a MySQL..."
    export_to_mysql
    
    print_message "✅ Configuración completa finalizada!"
    print_message "📁 Archivo de exportación creado en database/exports/"
}

# Función para crear backup de SQLite
backup_sqlite() {
    print_header "Creando backup de SQLite"
    
    if [ ! -f "database/database.sqlite" ]; then
        print_error "No se encontró database/database.sqlite"
        exit 1
    fi
    
    BACKUP_FILE="database/backups/sqlite-backup-$(date +%Y%m%d_%H%M%S).sqlite"
    mkdir -p database/backups
    
    cp database/database.sqlite "$BACKUP_FILE"
    
    print_message "✅ Backup creado: $BACKUP_FILE"
}

# Procesar argumentos
case "${1:-help}" in
    "setup-sqlite")
        setup_sqlite
        ;;
    "export-mysql")
        export_to_mysql
        ;;
    "full-setup")
        full_setup
        ;;
    "backup-sqlite")
        backup_sqlite
        ;;
    "help"|*)
        show_help
        ;;
esac

#!/bin/bash

# Script para exportar datos de SQLite a MySQL y viceversa
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
    echo "  export-sqlite    Exportar datos de SQLite a MySQL"
    echo "  import-mysql     Importar datos de MySQL a SQLite"
    echo "  backup-sqlite    Crear backup de SQLite"
    echo "  backup-mysql     Crear backup de MySQL"
    echo "  sync-data        Sincronizar datos entre ambas bases"
    echo "  help             Mostrar esta ayuda"
    echo ""
    echo "Ejemplos:"
    echo "  $0 export-sqlite"
    echo "  $0 import-mysql"
    echo "  $0 sync-data"
}

# Función para exportar datos de SQLite a MySQL
export_sqlite_to_mysql() {
    print_header "Exportando datos de SQLite a MySQL"
    
    # Verificar que existe el archivo SQLite
    if [ ! -f "database/database.sqlite" ]; then
        print_error "No se encontró database/database.sqlite"
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
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO users VALUES (' || id || ', ''' || REPLACE(name, '''', '''''') || ''', ''' || email || ''', ' || CASE WHEN email_verified_at IS NULL THEN 'NULL' ELSE '''' || email_verified_at || '''' END || ', ''' || password || ''', ' || CASE WHEN remember_token IS NULL THEN 'NULL' ELSE '''' || remember_token || '''' END || ', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM users;" >> "$OUTPUT_FILE"

    # Exportar datos de operadores
    print_message "Exportando operadores..."
    echo "-- Datos de operadores:" >> "$OUTPUT_FILE"
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO operadores VALUES (' || id || ', ''' || codigo_operador || ''', ''' || REPLACE(nombre_operador, '''', '''''') || ''', ''' || rut_operador || ''', ' || CASE WHEN direccion_operador IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion_operador, '''', '''''') || '''' END || ', ' || CASE WHEN telefono_operador IS NULL THEN 'NULL' ELSE '''' || telefono_operador || '''' END || ', ' || CASE WHEN email_operador IS NULL THEN 'NULL' ELSE '''' || email_operador || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM operadores;" >> "$OUTPUT_FILE"

    # Exportar datos de aduanas
    print_message "Exportando aduanas..."
    echo "-- Datos de aduanas:" >> "$OUTPUT_FILE"
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO aduana_chiles VALUES (' || id || ', ''' || codigo || ''', ''' || REPLACE(nombre_aduana, '''', '''''') || ''', ' || CASE WHEN region IS NULL THEN 'NULL' ELSE '''' || region || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM aduana_chiles;" >> "$OUTPUT_FILE"

    # Exportar datos de tipos de contenedores
    print_message "Exportando tipos de contenedores..."
    echo "-- Datos de tipos de contenedores:" >> "$OUTPUT_FILE"
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO tipo_contenedors VALUES (' || id || ', ''' || codigo_tipo || ''', ''' || REPLACE(descripcion, '''', '''''') || ''', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM tipo_contenedors;" >> "$OUTPUT_FILE"

    # Exportar datos de empresas transportistas
    print_message "Exportando empresas transportistas..."
    echo "-- Datos de empresas transportistas:" >> "$OUTPUT_FILE"
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO empresa_transportistas VALUES (' || id || ', ''' || codigo_empresa || ''', ''' || REPLACE(nombre_empresa, '''', '''''') || ''', ''' || rut_empresa || ''', ' || CASE WHEN direccion_empresa IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion_empresa, '''', '''''') || '''' END || ', ' || CASE WHEN telefono_empresa IS NULL THEN 'NULL' ELSE '''' || telefono_empresa || '''' END || ', ' || CASE WHEN email_empresa IS NULL THEN 'NULL' ELSE '''' || email_empresa || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM empresa_transportistas;" >> "$OUTPUT_FILE"

    # Exportar datos de lugares de depósito
    print_message "Exportando lugares de depósito..."
    echo "-- Datos de lugares de depósito:" >> "$OUTPUT_FILE"
    sqlite3 database/database.sqlite "SELECT 'INSERT INTO lugar_depositos VALUES (' || id || ', ''' || codigo_deposito || ''', ''' || REPLACE(nombre_deposito, '''', '''''') || ''', ' || CASE WHEN direccion_deposito IS NULL THEN 'NULL' ELSE '''' || REPLACE(direccion_deposito, '''', '''''') || '''' END || ', ' || CASE WHEN region IS NULL THEN 'NULL' ELSE '''' || region || '''' END || ', ''' || estado || ''', ' || CASE WHEN created_at IS NULL THEN 'NULL' ELSE '''' || created_at || '''' END || ', ' || CASE WHEN updated_at IS NULL THEN 'NULL' ELSE '''' || updated_at || '''' END || ');' FROM lugar_depositos;" >> "$OUTPUT_FILE"

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

    # Habilitar foreign keys
    echo "SET FOREIGN_KEY_CHECKS = 1;" >> "$OUTPUT_FILE"

    print_message "✅ Exportación completada!"
    print_message "📁 Archivo: $OUTPUT_FILE"
    
    # Mostrar resumen de datos exportados
    print_header "Resumen de datos exportados"
    echo "   - Usuarios: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM users;")"
    echo "   - Operadores: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM operadores;")"
    echo "   - Aduanas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM aduana_chiles;")"
    echo "   - Tipos de Contenedor: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tipo_contenedors;")"
    echo "   - Empresas Transportistas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM empresa_transportistas;")"
    echo "   - Lugares de Depósito: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM lugar_depositos;")"
    echo "   - TATCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tatcs;")"
    echo "   - TSTCs: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM tstcs;")"
    echo "   - Salidas: $(sqlite3 database/database.sqlite "SELECT COUNT(*) FROM salidas;")"
}

# Función para importar datos a MySQL
import_to_mysql() {
    print_header "Importando datos a MySQL"
    
    # Buscar el archivo más reciente de exportación
    LATEST_FILE=$(ls -t database/exports/sqlite-to-mysql-*.sql 2>/dev/null | head -1)
    
    if [ -z "$LATEST_FILE" ]; then
        print_error "No se encontró archivo de exportación. Ejecuta primero: $0 export-sqlite"
        exit 1
    fi
    
    print_message "Importando desde: $LATEST_FILE"
    
    # Verificar si MySQL está disponible
    if ! command -v mysql &> /dev/null; then
        print_error "MySQL no está instalado o no está en el PATH"
        exit 1
    fi
    
    # Solicitar credenciales de MySQL
    read -p "Usuario MySQL (default: root): " MYSQL_USER
    MYSQL_USER=${MYSQL_USER:-root}
    
    read -s -p "Contraseña MySQL: " MYSQL_PASS
    echo ""
    
    # Importar datos
    print_message "Importando datos a MySQL..."
    mysql -u "$MYSQL_USER" -p"$MYSQL_PASS" < "$LATEST_FILE"
    
    print_message "✅ Importación completada!"
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

# Función para crear backup de MySQL
backup_mysql() {
    print_header "Creando backup de MySQL"
    
    # Solicitar credenciales de MySQL
    read -p "Usuario MySQL (default: root): " MYSQL_USER
    MYSQL_USER=${MYSQL_USER:-root}
    
    read -s -p "Contraseña MySQL: " MYSQL_PASS
    echo ""
    
    BACKUP_FILE="database/backups/mysql-backup-$(date +%Y%m%d_%H%M%S).sql"
    mkdir -p database/backups
    
    mysqldump -u "$MYSQL_USER" -p"$MYSQL_PASS" admin_base > "$BACKUP_FILE"
    
    print_message "✅ Backup creado: $BACKUP_FILE"
}

# Función para sincronizar datos
sync_data() {
    print_header "Sincronizando datos entre SQLite y MySQL"
    
    print_message "1. Creando backup de SQLite..."
    backup_sqlite
    
    print_message "2. Exportando datos de SQLite..."
    export_sqlite_to_mysql
    
    print_message "3. Importando datos a MySQL..."
    import_to_mysql
    
    print_message "✅ Sincronización completada!"
}

# Procesar argumentos
case "${1:-help}" in
    "export-sqlite")
        export_sqlite_to_mysql
        ;;
    "import-mysql")
        import_to_mysql
        ;;
    "backup-sqlite")
        backup_sqlite
        ;;
    "backup-mysql")
        backup_mysql
        ;;
    "sync-data")
        sync_data
        ;;
    "help"|*)
        show_help
        ;;
esac

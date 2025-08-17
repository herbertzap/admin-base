#!/bin/bash

# Script para resetear contraseñas de usuarios en SQLite
# Sistema de Gestión de Contenedores - Admin Base

set -e

# Colores para output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m'

print_message() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_header() {
    echo -e "${BLUE}================================${NC}"
    echo -e "${BLUE} $1${NC}"
    echo -e "${BLUE}================================${NC}"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Verificar que existe la base de datos SQLite
if [ ! -f "database/database.sqlite" ]; then
    echo "❌ Error: No se encontró database/database.sqlite"
    echo "Ejecuta primero: ./database/setup-and-export.sh setup-sqlite"
    exit 1
fi

print_header "Reseteo de Contraseñas de Usuarios"

# Mostrar usuarios existentes
print_message "Usuarios existentes en la base de datos:"
echo ""
sqlite3 database/database.sqlite "SELECT id, name, email, estado FROM users;"
echo ""

# Generar contraseñas nuevas
ADMIN_PASSWORD="admin123"
HERBERT_PASSWORD="herbert123"

print_message "Generando nuevas contraseñas..."

# Generar hash de contraseñas usando PHP
ADMIN_HASH=$(php -r "echo password_hash('$ADMIN_PASSWORD', PASSWORD_BCRYPT);")
HERBERT_HASH=$(php -r "echo password_hash('$HERBERT_PASSWORD', PASSWORD_BCRYPT);")

# Actualizar contraseñas en la base de datos
print_message "Actualizando contraseñas en la base de datos..."

sqlite3 database/database.sqlite "UPDATE users SET password = '$ADMIN_HASH' WHERE id = 1;"
sqlite3 database/database.sqlite "UPDATE users SET password = '$HERBERT_HASH' WHERE id = 2;"

print_message "✅ Contraseñas actualizadas exitosamente!"

print_header "Credenciales de Acceso"

echo "📧 Usuario 1:"
echo "   Email: admin@material.com"
echo "   Contraseña: $ADMIN_PASSWORD"
echo "   Rol: Admin"
echo ""

echo "📧 Usuario 2:"
echo "   Email: herbert.zapata19@gmail.com"
echo "   Contraseña: $HERBERT_PASSWORD"
echo "   Rol: Usuario"
echo ""

print_warning "⚠️  IMPORTANTE: Cambia estas contraseñas después del primer acceso por seguridad."

print_message "🎉 ¡Usuarios listos para acceder al sistema!"

# Crear archivo con las credenciales
CREDENTIALS_FILE="database/user-credentials.txt"
cat > "$CREDENTIALS_FILE" << EOF
===========================================
CREDENCIALES DE ACCESO - SISTEMA ADMIN BASE
===========================================
Fecha: $(date)

USUARIO 1:
Email: admin@material.com
Contraseña: $ADMIN_PASSWORD
Rol: Admin
Estado: Activo

USUARIO 2:
Email: herbert.zapata19@gmail.com
Contraseña: $HERBERT_PASSWORD
Rol: Usuario
Estado: Activo

===========================================
IMPORTANTE: Cambiar contraseñas después del primer acceso
===========================================
EOF

print_message "📁 Credenciales guardadas en: $CREDENTIALS_FILE"

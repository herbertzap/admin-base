#!/bin/bash

# Script de Despliegue para Admin-Base
# Uso: ./deploy.sh [produccion|staging]

set -e

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Función para imprimir mensajes
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

# Verificar argumentos
if [ $# -eq 0 ]; then
    print_error "Debe especificar el ambiente: produccion o staging"
    echo "Uso: ./deploy.sh [produccion|staging]"
    exit 1
fi

ENVIRONMENT=$1
PROJECT_DIR="/var/www/html/contenedores-pricer-cl"
BACKUP_DIR="/var/backups/contenedores-pricer-cl"
DATE=$(date +%Y%m%d_%H%M%S)

print_header "Iniciando Despliegue - Ambiente: $ENVIRONMENT"

# Verificar que el directorio del proyecto existe
if [ ! -d "$PROJECT_DIR" ]; then
    print_error "El directorio del proyecto no existe: $PROJECT_DIR"
    exit 1
fi

cd "$PROJECT_DIR"

# 1. Crear backup de la base de datos
print_message "Creando backup de la base de datos..."
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p "$BACKUP_DIR"
fi

php artisan backup:run --only-db
print_message "Backup creado exitosamente"

# 2. Crear backup del código actual
print_message "Creando backup del código actual..."
tar -czf "$BACKUP_DIR/code_backup_$DATE.tar.gz" --exclude='.git' --exclude='node_modules' --exclude='vendor' .

# 3. Activar modo mantenimiento
print_message "Activando modo mantenimiento..."
php artisan down --message="Actualización en progreso. Volveremos pronto." --retry=60

# 4. Actualizar código desde Git
print_message "Actualizando código desde Git..."
git fetch origin
git reset --hard origin/main

# 5. Instalar dependencias de PHP
print_message "Instalando dependencias de PHP..."
composer install --optimize-autoloader --no-dev --no-interaction

# 6. Instalar dependencias de Node.js
print_message "Instalando dependencias de Node.js..."
npm ci --production

# 7. Compilar assets
print_message "Compilando assets..."
npm run build

# 8. Ejecutar migraciones
print_message "Ejecutando migraciones..."
php artisan migrate --force

# 9. Limpiar cachés
print_message "Limpiando cachés..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 10. Optimizar para producción
print_message "Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 11. Actualizar permisos
print_message "Actualizando permisos..."
chown -R www-data:www-data "$PROJECT_DIR"
chmod -R 755 "$PROJECT_DIR"
chmod -R 775 storage bootstrap/cache

# 12. Desactivar modo mantenimiento
print_message "Desactivando modo mantenimiento..."
php artisan up

# 13. Verificar estado
print_message "Verificando estado de la aplicación..."
if curl -f -s http://localhost > /dev/null; then
    print_message "✅ Aplicación funcionando correctamente"
else
    print_error "❌ Error al verificar la aplicación"
    exit 1
fi

# 14. Limpiar backups antiguos (mantener solo los últimos 7 días)
print_message "Limpiando backups antiguos..."
find "$BACKUP_DIR" -name "*.tar.gz" -mtime +7 -delete

print_header "Despliegue Completado Exitosamente"
print_message "Ambiente: $ENVIRONMENT"
print_message "Fecha: $(date)"
print_message "Backup creado: code_backup_$DATE.tar.gz"

# Mostrar información útil
echo ""
print_message "Comandos útiles:"
echo "  - Ver logs: tail -f storage/logs/laravel.log"
echo "  - Verificar estado: php artisan about"
echo "  - Limpiar caché: php artisan cache:clear"
echo "  - Backup manual: php artisan backup:run"
echo ""

print_message "🎉 ¡Despliegue completado!"

#!/bin/bash

# Script de Despliegue Simplificado para Contenedores Pricer
# Este script se ejecuta automáticamente cuando hay cambios en GitHub

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

PROJECT_DIR="/var/www/html/contenedores-pricer-cl"
DATE=$(date +%Y%m%d_%H%M%S)

print_header "Iniciando Despliegue Automático - $(date)"

# Verificar que el directorio del proyecto existe
if [ ! -d "$PROJECT_DIR" ]; then
    print_error "El directorio del proyecto no existe: $PROJECT_DIR"
    exit 1
fi

cd "$PROJECT_DIR"

# 1. Activar modo mantenimiento
print_message "Activando modo mantenimiento..."
php artisan down --message="Actualización en progreso. Volveremos pronto." --retry=60 || print_warning "No se pudo activar modo mantenimiento"

# 2. Actualizar código desde Git
print_message "Actualizando código desde Git..."
git fetch origin
git reset --hard origin/main

# 3. Instalar dependencias de PHP
print_message "Instalando dependencias de PHP..."
composer install --optimize-autoloader --no-dev --no-interaction

# 4. Instalar dependencias de Node.js
print_message "Instalando dependencias de Node.js..."
npm ci --production

# 5. Compilar assets
print_message "Compilando assets..."
npm run build

# 6. Ejecutar migraciones
print_message "Ejecutando migraciones..."
php artisan migrate --force

# 7. Limpiar cachés
print_message "Limpiando cachés..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 8. Optimizar para producción
print_message "Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Actualizar permisos
print_message "Actualizando permisos..."
sudo chown -R ec2-user:apache "$PROJECT_DIR"
sudo chmod -R 755 "$PROJECT_DIR"
sudo chown -R apache:apache storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 10. Desactivar modo mantenimiento
print_message "Desactivando modo mantenimiento..."
php artisan up

# 11. Recargar Apache
print_message "Recargando Apache..."
sudo systemctl reload httpd

print_header "Despliegue Completado Exitosamente"
print_message "Fecha: $(date)"
print_message "✅ Sistema actualizado y funcionando"

# Mostrar información útil
echo ""
print_message "Comandos útiles:"
echo "  - Ver logs: tail -f storage/logs/laravel.log"
echo "  - Verificar estado: php artisan about"
echo "  - Limpiar caché: php artisan cache:clear"
echo ""

print_message "🎉 ¡Despliegue automático completado!"

#!/bin/bash

# Script de Despliegue Final para Webhook
# Este script se ejecuta automáticamente cuando hay cambios en GitHub

set -e

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
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

PROJECT_DIR="/var/www/html/contenedores-pricer-cl"

print_header "Iniciando Despliegue Final - $(date)"

cd "$PROJECT_DIR"

# 1. Configurar Git para evitar problemas de permisos
print_message "Configurando Git..."
export GIT_TERMINAL_PROMPT=0
export GIT_CONFIG_GLOBAL=/dev/null
export GIT_CONFIG_SYSTEM=/dev/null

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

# 10. Recargar Apache
print_message "Recargando Apache..."
sudo systemctl reload httpd

print_header "Despliegue Final Completado"
print_message "✅ Sistema actualizado y funcionando"
print_message "Fecha: $(date)"
print_message "🎉 ¡Webhook funcionando correctamente!"

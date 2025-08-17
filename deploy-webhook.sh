#!/bin/bash

# Script de Despliegue Simple para Webhook
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

print_header "Iniciando Despliegue Webhook - $(date)"

cd "$PROJECT_DIR"

# 1. Configurar Git y actualizar código
print_message "Configurando Git..."
git config --local --add safe.directory /var/www/html/contenedores-pricer-cl || true
print_message "Actualizando código desde Git..."
GIT_TERMINAL_PROMPT=0 git fetch origin
GIT_TERMINAL_PROMPT=0 git reset --hard origin/main

# 2. Instalar dependencias de PHP
print_message "Instalando dependencias de PHP..."
composer install --optimize-autoloader --no-dev --no-interaction

# 3. Instalar dependencias de Node.js
print_message "Instalando dependencias de Node.js..."
npm ci --production

# 4. Compilar assets
print_message "Compilando assets..."
npm run build

# 5. Ejecutar migraciones
print_message "Ejecutando migraciones..."
php artisan migrate --force

# 6. Limpiar cachés
print_message "Limpiando cachés..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 7. Optimizar para producción
print_message "Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Actualizar permisos
print_message "Actualizando permisos..."
sudo chown -R ec2-user:apache "$PROJECT_DIR"
sudo chmod -R 755 "$PROJECT_DIR"
sudo chown -R apache:apache storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 9. Recargar Apache
print_message "Recargando Apache..."
sudo systemctl reload httpd

print_header "Despliegue Webhook Completado"
print_message "✅ Sistema actualizado y funcionando"
print_message "Fecha: $(date)"

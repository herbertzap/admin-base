# 🚢 Sistema de Administración de Contenedores - Admin Base

Sistema web desarrollado en Laravel para la gestión integral de contenedores, TATC (Títulos de Admisión Temporal de Contenedores) y TSTC (Títulos de Salida Temporal de Contenedores) para la Aduana de Chile.

## 📋 Tabla de Contenidos

- [Características](#-características)
- [Requisitos del Sistema](#-requisitos-del-sistema)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Estructura del Proyecto](#-estructura-del-proyecto)
- [Módulos del Sistema](#-módulos-del-sistema)
- [Despliegue en Producción](#-despliegue-en-producción)
- [Mantenimiento](#-mantenimiento)
- [Soporte](#-soporte)

## ✨ Características

### 🔐 Autenticación y Autorización
- Sistema de login con validación de credenciales
- Gestión de usuarios con roles y permisos (Spatie Laravel Permission)
- Perfiles de usuario con cambio de contraseña
- Sesiones seguras con middleware de autenticación

### 🏢 Gestión de Operadores
- CRUD completo de operadores aduaneros
- Carga de logos y firmas digitales
- Datos de contacto y representantes legales
- Estados activo/inactivo

### 📦 Mantenedores del Sistema
- **Empresas Transportistas**: Gestión de empresas de transporte
- **Tipos de Contenedores**: Catálogo de tipos (DRY, REEFER, TANK, etc.)
- **Aduanas de Chile**: Catálogo oficial de aduanas chilenas
- **Lugares de Depósito**: Ubicaciones de almacenamiento

### 🚢 Logística y Contenedores
- **Ingreso de Contenedores**: Registro de llegada de contenedores
- **Actualización de Datos**: Modificación de información de contenedores
- **Inventario de Stock**: Control de ubicación y estado
- **Consulta General**: Búsqueda y filtros avanzados

### 📄 TATC (Títulos de Admisión Temporal de Contenedores)
- **Registro de TATC**: Formulario completo con validaciones
- **Generación Automática**: Números TATC según estándar aduanero
- **Consulta y Filtros**: Búsqueda por múltiples criterios
- **Exportación**: Excel, CSV y PDF
- **Impresión Oficial**: Formato oficial de la Aduana de Chile
- **Historial de Cambios**: Auditoría completa de modificaciones
- **Validaciones en Tiempo Real**: JavaScript para validación inmediata

### 🚪 TSTC (Títulos de Salida Temporal de Contenedores)
- **Registro de TSTC**: Formulario para salidas de contenedores
- **Generación Automática**: Números TSTC secuenciales
- **Consulta y Filtros**: Búsqueda avanzada
- **Exportación**: Múltiples formatos
- **Impresión Oficial**: Documento oficial de salida
- **Historial de Cambios**: Tracking de modificaciones

### 🎨 Interfaz de Usuario
- **Material Dashboard**: Diseño moderno y responsivo
- **Bootstrap 5**: Framework CSS actualizado
- **FontAwesome**: Iconografía completa
- **Tabs y Navegación**: Interfaz intuitiva
- **Validaciones Visuales**: Feedback inmediato al usuario

## 🖥️ Requisitos del Sistema

### Servidor Web
- **PHP**: 8.1 o superior
- **Composer**: 2.0 o superior
- **MySQL**: 8.0 o superior / MariaDB 10.5 o superior
- **Web Server**: Apache 2.4+ / Nginx 1.18+
- **SSL**: Certificado válido (recomendado)

### Extensiones PHP Requeridas
```bash
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension (para imágenes)
- ZIP PHP Extension (para exportaciones)
```

### Recursos del Servidor
- **RAM**: Mínimo 2GB, recomendado 4GB+
- **CPU**: 2 cores mínimo, 4 cores recomendado
- **Almacenamiento**: 20GB mínimo para aplicación + base de datos
- **Ancho de Banda**: 10Mbps mínimo

## 🚀 Instalación

### 1. Clonar el Repositorio
```bash
git clone https://github.com/tu-usuario/admin-base.git
cd admin-base
```

### 2. Instalar Dependencias
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 3. Configurar Variables de Entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar Base de Datos
Editar `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin_base
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 5. Ejecutar Migraciones
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 6. Configurar Almacenamiento
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### 7. Optimizar para Producción
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ⚙️ Configuración

### Variables de Entorno Importantes

```env
# Configuración de la Aplicación
APP_NAME="Sistema de Administración de Contenedores"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Base de Datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin_base
DB_USERNAME=usuario_db
DB_PASSWORD=password_seguro

# Configuración de Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-password-app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Configuración de Sesiones
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Configuración de Archivos
FILESYSTEM_DISK=local
```

### Configuración del Web Server

#### Apache (.htaccess)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/admin-base/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 📁 Estructura del Proyecto

```
admin-base/
├── app/
│   ├── Http/Controllers/          # Controladores principales
│   │   ├── TatcController.php     # Gestión de TATC
│   │   ├── TstcController.php     # Gestión de TSTC
│   │   ├── LogisticaController.php # Gestión logística
│   │   └── ...
│   ├── Models/                    # Modelos Eloquent
│   │   ├── Tatc.php              # Modelo TATC
│   │   ├── Tstc.php              # Modelo TSTC
│   │   ├── Operador.php          # Modelo Operador
│   │   └── ...
│   └── Console/Commands/          # Comandos Artisan
├── database/
│   ├── migrations/               # Migraciones de BD
│   └── seeders/                  # Datos iniciales
├── resources/
│   ├── views/                    # Vistas Blade
│   │   ├── tatc/                 # Vistas TATC
│   │   ├── tstc/                 # Vistas TSTC
│   │   └── ...
│   ├── js/                       # JavaScript
│   └── css/                      # Estilos
├── routes/
│   └── web.php                   # Rutas web
├── storage/                      # Archivos subidos
├── public/                       # Archivos públicos
└── docs/                         # Documentación
```

## 🏗️ Módulos del Sistema

### 1. Gestión de Usuarios
- **Ruta**: `/user-management`
- **Funcionalidades**: CRUD de usuarios, roles y permisos
- **Acceso**: Solo administradores

### 2. Operadores
- **Ruta**: `/operadores`
- **Funcionalidades**: Gestión de operadores aduaneros
- **Características**: Logos, firmas, datos de contacto

### 3. Mantenedores
- **Empresas Transportistas**: `/empresa-transportistas`
- **Tipos de Contenedores**: `/tipo-contenedors`
- **Aduanas de Chile**: `/aduana-chiles`
- **Lugares de Depósito**: `/lugar-depositos`

### 4. Logística
- **Ruta**: `/logistica`
- **Funcionalidades**: 
  - Ingreso de contenedores
  - Actualización de datos
  - Inventario de stock
  - Consulta general

### 5. TATC (Títulos de Admisión Temporal)
- **Ruta**: `/tatc`
- **Funcionalidades**:
  - Registro de TATC
  - Consulta general
  - Exportación (Excel, CSV, PDF)
  - Impresión oficial
  - Historial de cambios

### 6. TSTC (Títulos de Salida Temporal)
- **Ruta**: `/tstc`
- **Funcionalidades**:
  - Registro de TSTC
  - Consulta general
  - Exportación
  - Impresión oficial
  - Historial de cambios

## 🌐 Despliegue en Producción

### 1. Preparación del Servidor

```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar dependencias
sudo apt install nginx mysql-server php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-gd php8.1-zip php8.1-bcmath php8.1-json composer git unzip -y

# Instalar Node.js (para compilar assets)
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### 2. Configurar Base de Datos

```sql
CREATE DATABASE admin_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'admin_base_user'@'localhost' IDENTIFIED BY 'password_seguro';
GRANT ALL PRIVILEGES ON admin_base.* TO 'admin_base_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Desplegar Aplicación

```bash
# Crear directorio
sudo mkdir -p /var/www/admin-base
sudo chown -R $USER:$USER /var/www/admin-base

# Clonar repositorio
cd /var/www/admin-base
git clone https://github.com/tu-usuario/admin-base.git .

# Instalar dependencias
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Configurar permisos
sudo chown -R www-data:www-data /var/www/admin-base
sudo chmod -R 755 /var/www/admin-base
sudo chmod -R 775 storage bootstrap/cache
```

### 4. Configurar Nginx

```bash
sudo nano /etc/nginx/sites-available/admin-base
```

Contenido:
```nginx
server {
    listen 80;
    server_name admin-base.tu-dominio.com;
    root /var/www/admin-base/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Habilitar sitio
sudo ln -s /etc/nginx/sites-available/admin-base /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 5. Configurar SSL (Let's Encrypt)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d admin-base.tu-dominio.com
```

### 6. Configurar Cron para Tareas Programadas

```bash
crontab -e
```

Agregar:
```bash
* * * * * cd /var/www/admin-base && php artisan schedule:run >> /dev/null 2>&1
```

### 7. Configurar Supervisor (Opcional)

Para procesos en segundo plano:
```bash
sudo apt install supervisor -y
sudo nano /etc/supervisor/conf.d/admin-base.conf
```

## 🔧 Mantenimiento

### Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Verificar estado
php artisan about

# Backup de base de datos
php artisan backup:run

# Actualizar dependencias
composer update --no-dev
npm update
npm run build
```

### Logs del Sistema

```bash
# Ver logs de Laravel
tail -f storage/logs/laravel.log

# Ver logs de Nginx
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log

# Ver logs de PHP-FPM
sudo tail -f /var/log/php8.1-fpm.log
```

### Monitoreo

- **Uptime**: Monitorear disponibilidad del sitio
- **Base de Datos**: Verificar conexiones y rendimiento
- **Almacenamiento**: Controlar espacio en disco
- **Logs**: Revisar errores regularmente

## 📞 Soporte

### Información de Contacto
- **Desarrollador**: Herbert Zapata
- **Email**: herbert.zapata19@gmail.com
- **Versión**: 1.0.0
- **Laravel**: 11.x
- **PHP**: 8.1+

### Problemas Comunes

1. **Error 500**: Verificar logs en `storage/logs/laravel.log`
2. **Permisos**: Ejecutar `chmod -R 775 storage bootstrap/cache`
3. **Base de Datos**: Verificar conexión en `.env`
4. **SSL**: Renovar certificado Let's Encrypt cada 90 días

### Actualizaciones

```bash
# Crear backup antes de actualizar
php artisan backup:run

# Actualizar código
git pull origin main

# Actualizar dependencias
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Ejecutar migraciones
php artisan migrate --force

# Limpiar caché
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📄 Licencia

Este proyecto es propiedad de [Tu Empresa] y está desarrollado para uso interno de la Aduana de Chile.

**© 2024 - Todos los derechos reservados**

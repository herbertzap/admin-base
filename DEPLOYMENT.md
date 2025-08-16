# 🚀 Despliegue Automático - Sistema de Gestión de Contenedores

Este documento explica cómo configurar el despliegue automático para el sistema de gestión de contenedores.

## 📋 Configuración Actual

- **URL**: https://contenedores.pricer.cl
- **Repositorio**: https://github.com/herbertzap/admin-base.git
- **Servidor**: AWS EC2
- **Directorio**: `/var/www/html/contenedores-pricer-cl/`

## 🔧 Configuración del Despliegue Automático

### Opción 1: GitHub Actions (Recomendado)

1. **Configurar Secrets en GitHub**:
   - Ve a tu repositorio en GitHub
   - Settings → Secrets and variables → Actions
   - Agrega los siguientes secrets:
     - `HOST`: IP del servidor (ej: 172.31.4.144)
     - `USERNAME`: ec2-user
     - `SSH_KEY`: Tu clave SSH privada
     - `PORT`: 22

2. **Configurar el Webhook**:
   - Ve a Settings → Webhooks
   - Add webhook
   - Payload URL: `https://contenedores.pricer.cl/webhook.php`
   - Content type: `application/json`
   - Secret: `tu_secret_webhook_aqui` (cambiar en webhook.php)
   - Events: Solo `Push events`
   - Branch: `main`

### Opción 2: Webhook Directo

1. **Configurar el webhook en el servidor**:
   ```bash
   # El archivo webhook.php ya está creado
   # Solo necesitas configurar el secret
   ```

2. **Configurar en GitHub**:
   - Settings → Webhooks
   - Payload URL: `https://contenedores.pricer.cl/webhook.php`
   - Secret: El mismo que configuraste en webhook.php

## 🔄 Flujo de Despliegue

### Con GitHub Actions:
1. Haces push a `main`
2. GitHub Actions ejecuta tests
3. Si los tests pasan, se conecta al servidor
4. Actualiza el código, instala dependencias, compila assets
5. Ejecuta migraciones y optimiza la aplicación

### Con Webhook Directo:
1. Haces push a `main`
2. GitHub envía webhook al servidor
3. El servidor ejecuta `deploy.sh` automáticamente
4. Se actualiza todo el código y configuración

## 📝 Comandos Manuales

### Despliegue Manual:
```bash
cd /var/www/html/contenedores-pricer-cl
./deploy.sh
```

### Verificar Estado:
```bash
# Ver logs del webhook
tail -f /var/www/html/contenedores-pricer-cl/webhook.log

# Ver logs del despliegue
tail -f /var/www/html/contenedores-pricer-cl/deploy.log

# Ver logs de Laravel
tail -f /var/www/html/contenedores-pricer-cl/storage/logs/laravel.log
```

### Rollback Manual:
```bash
cd /var/www/html/contenedores-pricer-cl
git log --oneline -10  # Ver commits recientes
git reset --hard <commit-hash>  # Volver a un commit anterior
./deploy.sh  # Re-desplegar
```

## 🔐 Seguridad

### Webhook Secret:
Cambia el secret en `webhook.php`:
```php
$secret = 'tu_secret_webhook_aqui'; // Cambiar por algo seguro
```

### Permisos:
```bash
# Asegurar que solo el usuario web puede ejecutar el webhook
chmod 644 public/webhook.php
chown apache:apache public/webhook.php
```

## 📊 Monitoreo

### Verificar que el webhook funciona:
```bash
# Test del webhook
curl -X POST https://contenedores.pricer.cl/webhook.php \
  -H "Content-Type: application/json" \
  -H "X-GitHub-Event: push" \
  -d '{"ref":"refs/heads/main"}'
```

### Logs importantes:
- `/var/www/html/contenedores-pricer-cl/webhook.log` - Logs del webhook
- `/var/www/html/contenedores-pricer-cl/deploy.log` - Logs del despliegue
- `/var/log/httpd/contenedores.pricer.cl-error.log` - Errores de Apache

## 🚨 Troubleshooting

### Si el webhook no funciona:
1. Verificar que el secret coincida
2. Verificar logs en `webhook.log`
3. Verificar que Apache puede ejecutar PHP
4. Verificar permisos del archivo webhook.php

### Si el despliegue falla:
1. Verificar logs en `deploy.log`
2. Verificar permisos del directorio
3. Verificar que Git está configurado correctamente
4. Verificar que Composer y NPM están instalados

### Si la aplicación no carga:
1. Verificar logs de Laravel
2. Verificar configuración de Apache
3. Verificar que la base de datos está funcionando
4. Verificar permisos de storage y bootstrap/cache

## 📞 Soporte

Para problemas con el despliegue automático:
1. Revisar los logs mencionados arriba
2. Verificar la configuración de GitHub
3. Probar el despliegue manualmente
4. Contactar al administrador del sistema

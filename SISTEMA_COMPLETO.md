# 🚢 Sistema MITATC - Documentación Completa

## 📋 Índice
1. [Descripción General](#descripción-general)
2. [Arquitectura del Sistema](#arquitectura-del-sistema)
3. [Funcionalidades Implementadas](#funcionalidades-implementadas)
4. [Integración HERMES](#integración-hermes)
5. [Base de Datos](#base-de-datos)
6. [Formularios y UX](#formularios-y-ux)
7. [Manual del Sistema](#manual-del-sistema)
8. [Migración SQLite a MySQL](#migración-sqlite-a-mysql)
9. [Comandos Artisan](#comandos-artisan)
10. [Estructura de Archivos](#estructura-de-archivos)

---

## 🎯 Descripción General

**MITATC** (Sistema de Administración de Contenedores) es una plataforma web desarrollada en Laravel para la gestión integral de contenedores, TATC (Títulos de Admisión Temporal de Contenedores) y TSTC (Títulos de Salida Temporal de Contenedores) para la Aduana de Chile.

### Características Principales:
- ✅ Sistema web responsive compatible con móviles
- ✅ Integración completa con API HERMES de la Aduana
- ✅ Gestión de usuarios con roles y permisos
- ✅ Formularios con date pickers HTML5
- ✅ Generación automática de PDFs
- ✅ Sistema de tickets de soporte
- ✅ Monitoreo de comunicaciones HERMES

---

## 🏗️ Arquitectura del Sistema

### Tecnologías Utilizadas:
- **Backend:** Laravel 11 (PHP 8.2+)
- **Base de Datos:** MySQL 8.0
- **Frontend:** Blade Templates + Bootstrap 5
- **JavaScript:** jQuery + Date Pickers HTML5
- **PDF:** Dompdf
- **Autenticación:** Laravel Auth + Spatie Permissions
- **API Externa:** HERMES (Aduana de Chile)

### Estructura MVC:
```
app/
├── Http/Controllers/     # Controladores principales
├── Models/              # Modelos Eloquent
├── Services/            # Servicios (HERMES)
├── Jobs/                # Colas de trabajo
├── Console/Commands/    # Comandos Artisan
└── Mail/               # Notificaciones por email
```

---

## ⚙️ Funcionalidades Implementadas

### 1. 🔐 Sistema de Autenticación
- **Login:** Email + Contraseña (no RUT)
- **Recuperación de contraseña:** Por email
- **Roles:** Super Admin, Admin, Usuario
- **Sesiones:** Seguras con middleware

### 2. 📦 Gestión de TATCs
- **Creación:** Formulario completo con validaciones
- **Edición:** Solo si estado permite modificación
- **Consulta:** Búsqueda avanzada con filtros
- **Estados:** Pendiente, Aprobado, Finalizado
- **Campos de fecha:** Date pickers HTML5
- **Generación automática:** Números TATC según estándar

### 3. 📤 Gestión de TSTCs
- **Creación:** Formulario específico para TSTCs
- **Edición:** Modificación de información existente
- **Consulta:** Búsqueda y filtrado avanzado
- **PDF:** Generación automática de documentos
- **Estados:** Control de estados del TSTC

### 4. 🚪 Registro de Salidas
- **Tipos:** Declaración de Internación, Cancelación, Traspaso
- **Masiva:** Selección múltiple de TATCs/TSTCs
- **Individual:** Salida uno por uno
- **Estados:** Pendiente, Aprobado (no editable)

### 5. ⏰ Control de Plazos
- **Vigencia:** Cálculo automático de días restantes
- **Indicadores:** Verde (vigente), Rojo (vencido)
- **Historial:** Registro de importaciones y cambios
- **Filtros:** Por tipo de salida y fechas

### 6. 🎫 Sistema de Tickets
- **Creación:** Nuevos tickets con adjuntos
- **Seguimiento:** Estados (Pendiente, En Progreso, Terminado)
- **Historial:** Conversación completa
- **Adjuntos:** Fotos, archivos, videos

---

## 🔗 Integración HERMES

### Servicio HERMES (`app/Services/Hermes/HermesService.php`)
- **Endpoint:** `https://api-hermes.aduana.cl/mensajeria/tatc`
- **Autenticación:** API Key de producción
- **Operaciones:**
  - TATC: Creación, Modificación, Cancelación, Traspaso, Cumplido
  - TSTC: Creación, Modificación
  - Salida: Registro de salidas

### Monitoreo HERMES
- **Dashboard:** Estadísticas en tiempo real
- **Historial:** Log completo de comunicaciones
- **Reintentos:** Sistema automático de reintentos
- **Logs:** Tabla `hermes_logs` con detalles completos

### Jobs Asincrónicos
- **EnviarHermesJob:** Procesamiento en cola
- **Dispatch automático:** Al crear/modificar TATCs/TSTCs/Salidas

---

## 🗄️ Base de Datos

### Tablas Principales:
- **`users`:** Usuarios del sistema
- **`tatcs`:** Títulos de Admisión Temporal
- **`tstcs`:** Títulos de Salida Temporal
- **`salidas`:** Registro de salidas
- **`hermes_logs`:** Logs de comunicaciones HERMES
- **`operadores`:** Operadores aduaneros
- **`aduanas`:** Catálogo de aduanas
- **`empresa_transportistas`:** Empresas de transporte

### Migración SQLite → MySQL:
- ✅ Migración completa de datos
- ✅ Preservación de relaciones
- ✅ Validación de integridad
- ✅ Comando Artisan personalizado

---

## 📝 Formularios y UX

### Date Pickers HTML5 Implementados:

#### Formulario TATC:
- **Ingreso al País:** `datetime-local` (fecha y hora)
- **Fecha Traspaso:** `date` (solo fecha)
- **Ingreso al Depósito:** `datetime-local` (fecha y hora)
- **Año de Fabricación:** `number` con icono calendario

#### Formulario TSTC:
- **Fecha emisión del TSTC:** Campo readonly con fecha actual
- **Ingreso al Depósito:** `date` (solo fecha)
- **Fecha Salida del País:** `datetime-local` (fecha y hora)
- **Año de Fabricación:** `number` con icono calendario

### Características UX:
- ✅ Sincronización automática de fechas
- ✅ Validación en tiempo real
- ✅ Iconos descriptivos
- ✅ Textos de ayuda
- ✅ Manejo de datos históricos

---

## 📚 Manual del Sistema

### Ubicación:
- **Web:** `/manual` - Vista interactiva
- **PDF:** `/manual/pdf` - Descarga directa

### Contenido:
1. **Presentación del Sistema**
2. **Control de Acceso** (Email + Contraseña)
3. **Recuperación de Contraseña**
4. **Pantalla Principal y Navegación**
5. **Gestión de TATCs**
6. **Gestión de TSTCs**
7. **Registro de Salidas**
8. **Control de Plazos**
9. **Sistema de Tickets**
10. **Integración HERMES**
11. **Procedimientos de Respaldo**
12. **Información Técnica**

---

## 🔄 Migración SQLite a MySQL

### Proceso Implementado:
1. **Comando Artisan:** `php artisan migrate:to-mysql`
2. **Conexión dual:** SQLite (origen) + MySQL (destino)
3. **Migración de esquemas:** Ejecución de migraciones
4. **Migración de datos:** Tabla por tabla
5. **Validación:** Verificación de integridad

### Archivos de Migración:
- `app/Console/Commands/MigrateToMysql.php`
- `database/migrations/` (todas las migraciones)
- Scripts de respaldo y validación

---

## 🛠️ Comandos Artisan

### Comandos Implementados:
- `tatc:importar-historico` - Importar datos históricos desde Excel
- `hermes:test` - Probar integración HERMES
- `hermes:test-integration` - Probar integración completa
- `hermes:test-2024-codification` - Probar codificación HERMES 2024
- `aduana:read-checklist` - Leer checklist de acreditación
- `migrate:to-mysql` - Migrar de SQLite a MySQL

### Uso:
```bash
php artisan tatc:importar-historico --archivo=datos.xlsx
php artisan hermes:test --tipo=tatc --id=1
php artisan migrate:to-mysql
```

---

## 📁 Estructura de Archivos

### Controladores Principales:
```
app/Http/Controllers/
├── TatcController.php          # Gestión TATCs
├── TstcController.php          # Gestión TSTCs
├── SalidaController.php        # Registro de salidas
├── ControlPlazosController.php # Control de plazos
├── HermesMonitorController.php # Monitoreo HERMES
├── ManualController.php        # Manual del sistema
└── SessionsController.php      # Autenticación
```

### Modelos:
```
app/Models/
├── Tatc.php                    # Modelo TATC
├── Tstc.php                    # Modelo TSTC
├── Salida.php                  # Modelo Salida
├── HermesLog.php               # Logs HERMES
├── User.php                    # Usuarios
└── Operador.php                # Operadores
```

### Servicios:
```
app/Services/
└── Hermes/
    └── HermesService.php       # Servicio HERMES
```

### Vistas:
```
resources/views/
├── tatc/
│   ├── create.blade.php        # Formulario creación TATC
│   ├── edit.blade.php          # Formulario edición TATC
│   └── index.blade.php         # Lista TATCs
├── tstc/
│   ├── create.blade.php        # Formulario creación TSTC
│   └── index.blade.php         # Lista TSTCs
├── salidas/
│   ├── create.blade.php        # Formulario salidas
│   ├── edit.blade.php          # Edición salidas
│   └── show.blade.php          # Vista salida
├── hermes/
│   ├── monitor.blade.php       # Dashboard HERMES
│   └── historial.blade.php     # Historial HERMES
└── manual/
    ├── index.blade.php         # Manual web
    └── pdf.blade.php           # Manual PDF
```

---

## 🔧 Configuración

### Variables de Entorno (.env):
```env
DB_CONNECTION=mysql
DB_DATABASE=admin_base_hermes
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=

SESSION_CONNECTION=mysql

HERMES_API_KEY=WW2Psa5F201ONZHSxuDif8M7smW12pE29tvups3l
HERMES_BASE_URL=https://api-hermes.aduana.cl
```

### Configuración HERMES (`config/hermes.php`):
- Base URL de la API
- API Key de producción
- Timeouts y reintentos
- Configuración de logging

---

## 🚀 Despliegue

### Requisitos:
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js (para assets)

### Pasos:
1. `composer install`
2. `npm install && npm run build`
3. `cp .env.example .env`
4. Configurar base de datos en `.env`
5. `php artisan migrate`
6. `php artisan db:seed`
7. `php artisan serve`

---

## 📊 Estado Actual del Proyecto

### ✅ Completado:
- Sistema de autenticación completo
- Gestión completa de TATCs y TSTCs
- Integración HERMES funcional
- Date pickers HTML5 implementados
- Manual del sistema generado
- Migración SQLite → MySQL
- Sistema de monitoreo HERMES
- Formularios optimizados para UX

### 🔄 En Desarrollo:
- Optimizaciones de rendimiento
- Nuevas funcionalidades según requerimientos

### 📈 Métricas:
- **29 archivos modificados** en último commit
- **2,732 líneas agregadas**
- **976 líneas eliminadas**
- **Sistema 100% funcional**

---

## 🆘 Soporte

### Sistema de Tickets:
- Acceso desde menú principal
- Creación de tickets con adjuntos
- Seguimiento en tiempo real
- Historial completo de conversaciones

### Documentación:
- Manual del sistema completo
- Documentación técnica en código
- Comentarios detallados en controladores

---

*Documento generado automáticamente - Sistema MITATC v1.0*
*Última actualización: Diciembre 2024*

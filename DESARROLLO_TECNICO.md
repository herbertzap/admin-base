# 🔧 MITATC - Guía Técnica de Desarrollo

## 📋 Información para Desarrolladores

Este documento contiene información técnica específica para desarrolladores que trabajen en el proyecto MITATC.

---

## 🏗️ Arquitectura Técnica

### Stack Tecnológico:
- **Framework:** Laravel 11.45.1
- **PHP:** 8.2.29
- **Base de Datos:** MySQL 8.0
- **Frontend:** Blade + Bootstrap 5 + jQuery
- **Autenticación:** Laravel Auth + Spatie Permissions
- **Colas:** Laravel Queues
- **PDF:** Dompdf
- **API Externa:** HERMES (REST JSON)

---

## 🗄️ Estructura de Base de Datos

### Tablas Principales:

#### `users`
```sql
- id (bigint, primary)
- name (varchar)
- email (varchar, unique)
- password (varchar, hashed)
- operador_id (bigint, foreign)
- rut_usuario (varchar)
- estado (enum: activo, inactivo)
- ultimo_movimiento (datetime)
- fecha_renovacion_password (datetime)
- cambio_password_requerido (boolean)
```

#### `tatcs`
```sql
- id (bigint, primary)
- numero_tatc (varchar, unique)
- numero_contenedor (varchar)
- tipo_contenedor (varchar)
- tipo_ingreso (enum: traspaso, desembarque)
- ingreso_pais (datetime)
- ingreso_deposito (datetime)
- fecha_traspaso (date)
- fecha_emision_tatc (date) -- NUEVO CAMPO
- tara_contenedor (decimal)
- valor_fob (decimal)
- estado (enum: Pendiente, Aprobado, Finalizado)
- user_id (bigint, foreign)
- hermes_request (json)
- hermes_response (json)
- hermes_status (varchar)
```

#### `tstcs`
```sql
- id (bigint, primary)
- numero_tstc (varchar, unique)
- operador_id (bigint, foreign)
- fecha_emision_tstc (date)
- numero_contenedor (varchar)
- tipo_contenedor (varchar)
- destino_contenedor (varchar)
- valor_fob (decimal)
- ingreso_deposito (date)
- aduana_salida (varchar)
- fecha_salida_pais (datetime)
- estado (varchar)
- user_id (bigint, foreign)
```

#### `salidas`
```sql
- id (bigint, primary)
- tatc_id (bigint, foreign, nullable)
- tstc_id (bigint, foreign, nullable)
- tipo_salida (enum: Declaración de Internación, Cancelación, Traspaso)
- fecha_salida (datetime)
- estado (enum: Pendiente, Aprobado)
- user_id (bigint, foreign)
```

#### `hermes_logs`
```sql
- id (bigint, primary)
- tipo_operacion (varchar)
- numero_documento (varchar)
- payload_enviado (json)
- respuesta_recibida (json)
- estado (varchar)
- codigo_respuesta (int)
- mensaje_error (text)
- endpoint (varchar)
- api_key_utilizada (varchar)
- intentos (int)
- ultimo_intento (datetime)
- metadata (json)
```

---

## 🔗 Integración HERMES

### Configuración (`config/hermes.php`):
```php
return [
    'base_url' => 'https://api-hermes.aduana.cl',
    'api_key' => env('HERMES_API_KEY'),
    'timeout' => 30,
    'max_retries' => 3,
    'endpoints' => [
        'tatc' => '/mensajeria/tatc',
        'tstc' => '/mensajeria/tstc',
        'salida' => '/mensajeria/salida',
    ],
    'operador' => [
        'codigo' => 'S46',
        'nombre' => 'Contenedores Tomás Dagnino Vicencio E.I.R.L',
        'rut' => '76666087-8',
    ],
];
```

### Servicio HERMES (`app/Services/Hermes/HermesService.php`):
```php
class HermesService
{
    // Métodos principales:
    public function enviarTatcCreacion($tatcId)
    public function enviarTatcModificacion($tatcId)
    public function enviarTatcCancelacion($tatcId)
    public function enviarTatcTraspaso($tatcId)
    public function enviarTatcCumplido($tatcId)
    public function enviarTstcCreacion($tstcId)
    public function enviarTstcModificacion($tstcId)
    public function enviarSalidaCreacion($salidaId)
    
    // Métodos auxiliares:
    private function enviarMensaje($endpoint, $payload)
    private function construirPayloadTatc($tatc, $tipoOperacion)
    private function construirPayloadTstc($tstc, $tipoOperacion)
    private function construirPayloadSalida($salida, $tipoOperacion)
}
```

### Job Asincrónico (`app/Jobs/EnviarHermesJob.php`):
```php
class EnviarHermesJob implements ShouldQueue
{
    public function __construct(
        public string $tipoOperacion,
        public int $documentoId,
        public string $modelo
    ) {}
    
    public function handle(HermesService $hermesService)
    {
        // Lógica de envío según tipo de operación
    }
}
```

---

## 📝 Formularios y Validaciones

### Date Pickers HTML5 Implementados:

#### TATC Create (`resources/views/tatc/create.blade.php`):
```html
<!-- Ingreso al País (fecha y hora) -->
<input type="datetime-local" name="ingreso_pais" 
       value="{{ date('Y-m-d\TH:i') }}" required>

<!-- Fecha Traspaso (solo fecha) -->
<input type="date" name="fecha_traspaso" 
       value="{{ date('Y-m-d') }}" required>

<!-- Ingreso al Depósito (fecha y hora) -->
<input type="datetime-local" name="ingreso_deposito" 
       value="{{ date('Y-m-d\TH:i') }}" required>

<!-- Año de Fabricación (número) -->
<input type="number" name="anio_fabricacion" 
       min="1900" max="{{ date('Y') + 1 }}" 
       placeholder="Ej: 2020">
```

#### TSTC Create (`resources/views/tstc/create.blade.php`):
```html
<!-- Ingreso al Depósito (solo fecha) -->
<input type="date" name="ingreso_deposito" 
       value="{{ date('Y-m-d') }}" required>

<!-- Fecha Salida del País (fecha y hora) -->
<input type="datetime-local" name="fecha_salida_pais" 
       value="{{ date('Y-m-d\TH:i') }}" required>
```

### Validaciones en Controladores:

#### TatcController:
```php
// Conversión de fechas HTML5 a formato de base de datos
if ($request->filled('ingreso_pais')) {
    $data['ingreso_pais'] = \Carbon\Carbon::parse($request->ingreso_pais)
        ->format('Y-m-d H:i:s');
}
if ($request->filled('fecha_traspaso')) {
    $data['fecha_traspaso'] = \Carbon\Carbon::parse($request->fecha_traspaso)
        ->format('Y-m-d');
}
```

---

## 🎨 Frontend y UX

### JavaScript para Sincronización de Fechas:
```javascript
// Sincronización automática entre fechas
$j('#ingreso_pais').on('change', function() {
    var fechaIngresoPais = $j(this).val();
    if (fechaIngresoPais) {
        $j('#ingreso_deposito').val(fechaIngresoPais);
    }
});

// Validación de fechas
$j('#formulario').on('submit', function(e) {
    var fechaIngresoPais = $j('#ingreso_pais').val();
    var fechaIngresoDeposito = $j('#ingreso_deposito').val();
    
    if (fechaIngresoPais && fechaIngresoDeposito) {
        var fechaPais = new Date(fechaIngresoPais);
        var fechaDeposito = new Date(fechaIngresoDeposito);
        
        if (fechaDeposito < fechaPais) {
            if (!confirm('Advertencia: La fecha de ingreso al depósito es anterior...')) {
                e.preventDefault();
                return false;
            }
        }
    }
});
```

### Estilos CSS Personalizados:
```css
/* Date pickers con iconos */
.input-group .input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

/* Campos readonly */
.form-control.bg-light {
    background-color: #f8f9fa !important;
}

/* Textos de ayuda */
.text-muted {
    font-size: 0.875rem;
    color: #6c757d;
}
```

---

## 🛠️ Comandos Artisan Personalizados

### Importar Datos Históricos:
```bash
php artisan tatc:importar-historico --archivo=datos.xlsx
```
**Archivo:** `app/Console/Commands/ImportarDatosHistoricosTact.php`

### Probar Integración HERMES:
```bash
php artisan hermes:test --tipo=tatc --id=1
php artisan hermes:test-integration --tipo=tatc --id=1 --dispatch
```
**Archivos:** 
- `app/Console/Commands/TestHermesApi.php`
- `app/Console/Commands/TestHermesIntegration.php`

### Migrar a MySQL:
```bash
php artisan migrate:to-mysql
```
**Archivo:** `app/Console/Commands/MigrateToMysql.php`

### Probar Codificación HERMES 2024:
```bash
php artisan hermes:test-2024-codification
```
**Archivo:** `app/Console/Commands/TestHermes2024Codification.php`

---

## 🔐 Autenticación y Permisos

### Sistema de Roles (Spatie Permissions):
```php
// Roles disponibles:
- super-admin
- admin  
- usuario

// Permisos por módulo:
- tatc.create, tatc.edit, tatc.delete, tatc.view
- tstc.create, tstc.edit, tstc.delete, tstc.view
- salida.create, salida.edit, salida.delete, salida.view
- hermes.monitor, hermes.historial
- manual.view
```

### Middleware de Autenticación:
```php
// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('tatc', TatcController::class);
    Route::resource('tstc', TstcController::class);
    // ... más rutas
});
```

---

## 📊 Monitoreo y Logs

### Logs HERMES:
```php
// Tabla hermes_logs
HermesLog::create([
    'tipo_operacion' => 'TATC_CREACION',
    'numero_documento' => $tatc->numero_tatc,
    'payload_enviado' => $payload,
    'respuesta_recibida' => $response,
    'estado' => 'exitoso',
    'codigo_respuesta' => 200,
    'endpoint' => '/mensajeria/tatc',
    'intentos' => 1,
    'ultimo_intento' => now(),
]);
```

### Dashboard de Monitoreo:
- **Ruta:** `/hermes/monitor`
- **Controlador:** `HermesMonitorController`
- **Vista:** `resources/views/hermes/monitor.blade.php`

### Estadísticas en Tiempo Real:
```php
// Métricas disponibles:
- Total de mensajes enviados
- Mensajes exitosos vs fallidos
- Estadísticas por tipo de operación
- Últimos mensajes enviados
- Errores recientes
```

---

## 🗂️ Migraciones de Base de Datos

### Migración Principal (Fecha Emisión TATC):
```php
// database/migrations/2025_09_04_161520_add_fecha_emision_tatc_to_tatcs_table.php
public function up(): void
{
    Schema::table('tatcs', function (Blueprint $table) {
        $table->date('fecha_emision_tatc')->nullable()->after('fecha_traspaso');
    });
}
```

### Migración HERMES Logs:
```php
// database/migrations/2025_09_02_231055_create_hermes_logs_table.php
public function up(): void
{
    Schema::create('hermes_logs', function (Blueprint $table) {
        $table->id();
        $table->string('tipo_operacion');
        $table->string('numero_documento');
        $table->json('payload_enviado');
        $table->json('respuesta_recibida');
        $table->string('estado');
        $table->integer('codigo_respuesta')->nullable();
        $table->text('mensaje_error')->nullable();
        $table->string('endpoint');
        $table->string('api_key_utilizada');
        $table->integer('intentos')->default(1);
        $table->datetime('ultimo_intento');
        $table->json('metadata')->nullable();
        $table->timestamps();
    });
}
```

---

## 🚀 Despliegue y Configuración

### Variables de Entorno Requeridas:
```env
# Base de datos
DB_CONNECTION=mysql
DB_DATABASE=admin_base_hermes
DB_HOST=127.0.0.1
DB_PORT=3306
DB_USERNAME=root
DB_PASSWORD=

# Sesiones
SESSION_CONNECTION=mysql

# HERMES API
HERMES_API_KEY=WW2Psa5F201ONZHSxuDif8M7smW12pE29tvups3l
HERMES_BASE_URL=https://api-hermes.aduana.cl

# Colas (opcional)
QUEUE_CONNECTION=database
```

### Comandos de Despliegue:
```bash
# Instalación inicial
composer install
npm install && npm run build

# Configuración
cp .env.example .env
php artisan key:generate

# Base de datos
php artisan migrate
php artisan db:seed

# Limpiar caché
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 🐛 Debugging y Troubleshooting

### Logs de Laravel:
```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Logs específicos de HERMES
grep "HERMES" storage/logs/laravel.log
```

### Debugging HERMES:
```php
// En HermesService.php
Log::info('HERMES Request', [
    'endpoint' => $endpoint,
    'payload' => $payload,
    'headers' => $headers
]);

Log::info('HERMES Response', [
    'status' => $response->status(),
    'body' => $response->body()
]);
```

### Comandos de Debug:
```bash
# Probar conexión HERMES
php artisan hermes:test --tipo=tatc --id=1

# Verificar colas
php artisan queue:work --verbose

# Limpiar caché completo
php artisan optimize:clear
```

---

## 📈 Optimizaciones Implementadas

### Base de Datos:
- ✅ Índices en campos de búsqueda frecuente
- ✅ Relaciones optimizadas con `with()`
- ✅ Paginación en listados grandes
- ✅ Queries optimizadas con `select()`

### Frontend:
- ✅ Date pickers HTML5 nativos
- ✅ Validación en tiempo real
- ✅ Sincronización automática de fechas
- ✅ Carga asíncrona de datos

### API:
- ✅ Jobs asincrónicos para HERMES
- ✅ Reintentos automáticos
- ✅ Timeouts configurables
- ✅ Logging completo

---

## 🔄 Flujo de Datos

### Creación de TATC:
1. Usuario llena formulario con date pickers
2. Validación en frontend (JavaScript)
3. Validación en backend (Laravel)
4. Guardado en base de datos
5. Dispatch de `EnviarHermesJob`
6. Envío asincrónico a HERMES
7. Log de respuesta en `hermes_logs`

### Modificación de TATC:
1. Verificación de permisos de edición
2. Validación de estado (no editable si "Finalizado")
3. Actualización en base de datos
4. Dispatch de `EnviarHermesJob` (modificación)
5. Log de operación

---

## 📋 Checklist de Desarrollo

### Antes de Hacer Commit:
- [ ] Tests unitarios pasando
- [ ] Validaciones funcionando
- [ ] Date pickers probados
- [ ] HERMES integration probada
- [ ] Logs verificados
- [ ] Performance optimizada

### Antes de Deploy:
- [ ] Migraciones ejecutadas
- [ ] Configuración actualizada
- [ ] Caché limpiado
- [ ] Logs monitoreados
- [ ] Backup de base de datos

---

*Documento técnico generado para desarrolladores MITATC*
*Versión: 1.0 - Diciembre 2024*

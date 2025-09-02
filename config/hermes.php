<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración de HERMES
    |--------------------------------------------------------------------------
    |
    | Configuración para la integración con el sistema HERMES de Aduanas
    |
    */

    // URL base de la API de HERMES
    'base_url' => env('HERMES_BASE_URL', 'https://api-hermes.aduana.cl'),

    // API Key para autenticación
    'api_key' => env('HERMES_API_KEY', 'WW2Psa5F201ONZHSxuDif8M7smW12pE29tvups3l'),

    // Timeout para las peticiones HTTP (en segundos)
    'timeout' => env('HERMES_TIMEOUT', 30),

    // Número máximo de reintentos para mensajes fallidos
    'max_retries' => env('HERMES_MAX_RETRIES', 3),

    // Endpoints de la API
    'endpoints' => [
        'tatc' => '/mensajeria/tatc',
        'tstc' => '/mensajeria/tstc',
        'salida' => '/mensajeria/salida',
        'consulta' => '/consulta/estado',
    ],

    // Configuración del operador
    'operador' => [
        'codigo' => env('HERMES_OPERADOR_CODIGO', 'S46'),
        'razon_social' => env('HERMES_OPERADOR_RAZON_SOCIAL', 'Contenedores Tomás Dagnino Vicencio E.I.R.L'),
        'rut' => env('HERMES_OPERADOR_RUT', '76666087-8'),
        'domicilio' => env('HERMES_OPERADOR_DOMICILIO', '13 Norte 853 oficina 803, valparaiso'),
        'representante_legal' => env('HERMES_OPERADOR_REPRESENTANTE', 'Tomas Sebastian Dagnino Vicencio'),
        'tipo_participante' => env('HERMES_OPERADOR_TIPO', 'OPERADOR'),
        'ambiente' => env('HERMES_AMBIENTE', 'Producción'),
    ],

    // Configuración de aduanas
    'aduana_default' => [
        'codigo' => env('HERMES_ADUANA_CODIGO', 98),
        'nombre' => env('HERMES_ADUANA_NOMBRE', 'DNA'),
    ],

    // Configuración de depósitos
    'deposito_default' => [
        'codigo' => env('HERMES_DEPOSITO_CODIGO', 'DEP001'),
        'razon_social' => env('HERMES_DEPOSITO_RAZON_SOCIAL', 'Depósito Principal'),
        'codigo_devolucion' => env('HERMES_DEPOSITO_CODIGO_DEVOLUCION', 'DEPDEV001'),
        'comuna' => env('HERMES_DEPOSITO_COMUNA', 'CODCL'),
    ],

    // Configuración de reintentos
    'retry' => [
        'enabled' => env('HERMES_RETRY_ENABLED', true),
        'delay' => env('HERMES_RETRY_DELAY', 60), // segundos
        'max_attempts' => env('HERMES_MAX_ATTEMPTS', 3),
    ],

    // Configuración de logging
    'logging' => [
        'enabled' => env('HERMES_LOGGING_ENABLED', true),
        'level' => env('HERMES_LOGGING_LEVEL', 'info'),
        'channel' => env('HERMES_LOGGING_CHANNEL', 'daily'),
    ],

    // Configuración de notificaciones
    'notifications' => [
        'enabled' => env('HERMES_NOTIFICATIONS_ENABLED', false),
        'email' => env('HERMES_NOTIFICATION_EMAIL'),
        'slack_webhook' => env('HERMES_SLACK_WEBHOOK'),
    ],
]; 
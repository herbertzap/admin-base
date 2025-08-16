<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Hermes API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuración para la integración con la API de Hermes de Aduanas
    |
    */

    // URL base de la API de Hermes
    'api_url' => env('HERMES_API_URL', 'https://api.hermes.aduana.cl'),

    // Token de autenticación para la API
    'api_token' => env('HERMES_API_TOKEN'),

    // Timeout para las peticiones HTTP (en segundos)
    'timeout' => env('HERMES_TIMEOUT', 30),

    // Modo de operación (production, testing, development)
    'mode' => env('HERMES_MODE', 'testing'),

    // Configuración de reintentos
    'retry_attempts' => env('HERMES_RETRY_ATTEMPTS', 3),
    'retry_delay' => env('HERMES_RETRY_DELAY', 5), // segundos

    // Configuración de logging
    'log_requests' => env('HERMES_LOG_REQUESTS', true),
    'log_responses' => env('HERMES_LOG_RESPONSES', true),

    // Configuración de validación
    'validate_before_send' => env('HERMES_VALIDATE_BEFORE_SEND', true),

    // Endpoints específicos
    'endpoints' => [
        'tatc' => '/tatc',
        'tstc' => '/tstc',
        'status' => '/status',
        'health' => '/health',
    ],
]; 
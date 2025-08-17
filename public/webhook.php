<?php

// Webhook para despliegue automático desde GitHub
// Este archivo recibe notificaciones de GitHub cuando hay cambios en el repositorio

// Configuración
$secret = 'tu_secret_webhook_aqui'; // Cambiar por un secret seguro
$logFile = '/var/www/html/contenedores-pricer-cl/webhook.log';

// Función para escribir logs
function writeLog($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

// Función para obtener headers de forma compatible
function getHeaders() {
    $headers = [];
    foreach ($_SERVER as $key => $value) {
        if (strpos($key, 'HTTP_') === 0) {
            $header = str_replace('_', '-', strtolower(substr($key, 5)));
            $headers[$header] = $value;
        }
    }
    return $headers;
}

// Verificar que es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    writeLog('Método no permitido: ' . $_SERVER['REQUEST_METHOD']);
    exit('Método no permitido');
}

// Obtener el payload
$payload = file_get_contents('php://input');
$headers = getHeaders();

writeLog('Headers recibidos: ' . json_encode($headers));

// Verificar que es un evento de GitHub
$githubEvent = $headers['x-github-event'] ?? null;
if (!$githubEvent) {
    http_response_code(400);
    writeLog('No es un evento de GitHub - Header x-github-event no encontrado');
    exit('No es un evento de GitHub');
}

// Verificar la firma del webhook (opcional pero recomendado)
$signature = $headers['x-hub-signature-256'] ?? null;
if ($signature) {
    $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $secret);
    
    if (!hash_equals($expectedSignature, $signature)) {
        http_response_code(401);
        writeLog('Firma del webhook inválida');
        exit('Firma inválida');
    }
}

// Decodificar el payload
$data = json_decode($payload, true);

// Verificar que es un push al branch main
if ($githubEvent === 'push' && 
    isset($data['ref']) && 
    $data['ref'] === 'refs/heads/main') {
    
    writeLog('Push detectado en main branch - Iniciando despliegue');
    
    // Ejecutar el script de despliegue en segundo plano
    $command = 'cd /var/www/html/contenedores-pricer-cl && ./deploy-final.sh > /var/www/html/contenedores-pricer-cl/deploy.log 2>&1 &';
    exec($command);
    
    writeLog('Script de despliegue ejecutado en segundo plano');
    
    // Responder con éxito
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Despliegue iniciado',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
} else {
    writeLog('Evento ignorado: ' . $githubEvent . ' - Ref: ' . ($data['ref'] ?? 'N/A'));
    
    // Responder con éxito pero sin hacer nada
    http_response_code(200);
    echo json_encode([
        'status' => 'ignored',
        'message' => 'Evento ignorado',
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}

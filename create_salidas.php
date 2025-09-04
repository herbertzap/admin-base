<?php

require_once 'vendor/autoload.php';

echo "🚀 Creando registros de salida para TATCs finalizados...\n";

try {
    // Conectar a MySQL
    $mysqlPdo = new PDO(
        'mysql:host=127.0.0.1;dbname=admin_base_hermes;charset=utf8mb4',
        'root',
        ''
    );
    
    echo "✅ Conexión establecida\n";
    
    // Obtener TATCs finalizados (estado Aprobado)
    $tatcs = $mysqlPdo->query("SELECT * FROM tatcs WHERE estado = 'Aprobado'")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📥 Encontrados " . count($tatcs) . " TATCs finalizados\n";
    
    foreach ($tatcs as $tatc) {
        // Generar número de salida único
        $numeroSalida = 'SAL' . date('Y') . str_pad($tatc['id'], 6, '0', STR_PAD_LEFT);
        
        // Calcular fecha de salida (30 días después del ingreso)
        $fechaIngreso = new DateTime($tatc['ingreso_pais']);
        $fechaSalida = $fechaIngreso->modify('+30 days')->format('Y-m-d');
        
        $stmt = $mysqlPdo->prepare("INSERT INTO salidas (tatc_id, numero_salida, fecha_salida, tipo_salida, motivo_salida, numero_contenedor, tipo_contenedor, estado_contenedor, aduana_salida, documento_aduana, numero_documento, empresa_transportista_id, rut_chofer, patente_camion, destino_final, pais_destino, observaciones, estado, user_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $tatc['id'],
            $numeroSalida,
            $fechaSalida,
            'Traspaso', // Tipo de salida basado en tipo_ingreso
            'Traspaso de contenedor según TATC',
            $tatc['numero_contenedor'],
            $tatc['tipo_contenedor'],
            $tatc['estado_contenedor'],
            $tatc['aduana_ingreso'], // Usar la misma aduana de ingreso
            'DI', // Declaración de Internación
            $tatc['numero_tatc'], // Usar el número TATC como documento
            $tatc['empresa_transportista_id'] ?? null,
            $tatc['rut_chofer'] ?? null,
            $tatc['patente_camion'] ?? null,
            'Destino Final', // Valor por defecto
            'Chile', // País destino
            'Salida generada automáticamente para TATC finalizado',
            'Aprobado', // Estado de la salida
            $tatc['user_id'],
            $tatc['created_at'],
            $tatc['updated_at']
        ]);
        
        echo "✅ Salida creada para TATC " . $tatc['numero_tatc'] . "\n";
    }
    
    echo "🎉 Registros de salida creados exitosamente!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

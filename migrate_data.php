<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use PDO;

echo "🚀 Iniciando migración directa de datos...\n";

// Configurar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Conectar a SQLite
    $sqlitePath = __DIR__ . '/database/database.sqlite';
    $sqlitePdo = new PDO("sqlite:{$sqlitePath}");
    $sqlitePdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conexión a SQLite establecida\n";
    
    // Conectar a MySQL
    DB::connection('mysql')->getPdo();
    echo "✅ Conexión a MySQL establecida\n";
    
    // Migrar usuarios
    echo "📥 Migrando usuarios...\n";
    $users = $sqlitePdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($users)) {
        DB::connection('mysql')->table('users')->insert($users);
        echo "  ✅ " . count($users) . " usuarios migrados\n";
    }
    
    // Migrar operadores
    echo "📥 Migrando operadores...\n";
    $operators = $sqlitePdo->query("SELECT * FROM operadors")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($operators)) {
        DB::connection('mysql')->table('operadors')->insert($operators);
        echo "  ✅ " . count($operators) . " operadores migrados\n";
    }
    
    // Migrar TATCs
    echo "📥 Migrando TATCs...\n";
    $tatcs = $sqlitePdo->query("SELECT * FROM tatcs")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($tatcs)) {
        DB::connection('mysql')->table('tatcs')->insert($tatcs);
        echo "  ✅ " . count($tatcs) . " TATCs migrados\n";
    }
    
    // Migrar TSTCs
    echo "📥 Migrando TSTCs...\n";
    $tstcs = $sqlitePdo->query("SELECT * FROM tstcs")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($tstcs)) {
        DB::connection('mysql')->table('tstcs')->insert($tstcs);
        echo "  ✅ " . count($tstcs) . " TSTCs migrados\n";
    }
    
    // Migrar salidas
    echo "📥 Migrando salidas...\n";
    $salidas = $sqlitePdo->query("SELECT * FROM salidas")->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($salidas)) {
        DB::connection('mysql')->table('salidas')->insert($salidas);
        echo "  ✅ " . count($salidas) . " salidas migradas\n";
    }
    
    echo "✅ Migración completada exitosamente!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PDO;

class MigrateToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-to-mysql {--fresh : Ejecutar migraciones fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrar datos de SQLite a MySQL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando migración de SQLite a MySQL...');

        // Verificar conexión SQLite
        if (!file_exists(database_path('database.sqlite'))) {
            $this->error('❌ Base de datos SQLite no encontrada');
            return 1;
        }

        // Verificar conexión MySQL
        try {
            DB::connection('mysql')->getPdo();
            $this->info('✅ Conexión a MySQL verificada');
        } catch (\Exception $e) {
            $this->error('❌ Error conectando a MySQL: ' . $e->getMessage());
            return 1;
        }

        // Crear conexión SQLite manual
        $sqlitePath = database_path('database.sqlite');
        $sqlitePdo = new PDO("sqlite:{$sqlitePath}");
        $sqlitePdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener tablas de SQLite
        $tables = $this->getSqliteTables($sqlitePdo);
        $this->info("📊 Tablas encontradas en SQLite: " . count($tables));

        // Ejecutar migraciones si se solicita
        if ($this->option('fresh')) {
            $this->info('🔄 Ejecutando migraciones fresh en MySQL...');
            $this->call('migrate:fresh', ['--database' => 'mysql']);
        } else {
            $this->info('🔄 Ejecutando migraciones en MySQL...');
            $this->call('migrate', ['--database' => 'mysql']);
        }

        // Migrar datos tabla por tabla
        $this->migrateTables($sqlitePdo, $tables);

        $this->info('✅ Migración completada exitosamente!');
        return 0;
    }

    /**
     * Obtener lista de tablas de SQLite
     */
    private function getSqliteTables($sqlitePdo)
    {
        $stmt = $sqlitePdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Migrar datos de todas las tablas
     */
    private function migrateTables($sqlitePdo, $tables)
    {
        $this->info('📥 Migrando datos...');

        foreach ($tables as $table) {
            if (in_array($table, ['migrations', 'failed_jobs', 'job_batches'])) {
                $this->line("  ⏭️ Saltando tabla del sistema: {$table}");
                continue;
            }

            $this->line("  📋 Migrando tabla: {$table}");

            try {
                // Verificar si la tabla existe en MySQL
                if (!Schema::connection('mysql')->hasTable($table)) {
                    $this->warn("    ⚠️ Tabla {$table} no existe en MySQL, saltando...");
                    continue;
                }

                // Obtener datos de SQLite
                $stmt = $sqlitePdo->query("SELECT * FROM {$table}");
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($rows)) {
                    $this->line("    ℹ️ Tabla {$table} está vacía");
                    continue;
                }

                // Migrar datos
                $this->migrateTableData($table, $rows);

            } catch (\Exception $e) {
                $this->error("    ❌ Error migrando tabla {$table}: " . $e->getMessage());
            }
        }
    }

    /**
     * Migrar datos de una tabla específica
     */
    private function migrateTableData($table, $rows)
    {
        $this->line("    📥 Migrando " . count($rows) . " registros...");

        // Limpiar tabla MySQL
        DB::connection('mysql')->table($table)->truncate();

        // Insertar datos en lotes
        $batchSize = 100;
        $totalRows = count($rows);
        
        for ($i = 0; $i < $totalRows; $i += $batchSize) {
            $batch = array_slice($rows, $i, $batchSize);
            
            try {
                DB::connection('mysql')->table($table)->insert($batch);
                $this->line("      ✅ Lote " . (($i / $batchSize) + 1) . " migrado");
            } catch (\Exception $e) {
                $this->error("      ❌ Error en lote " . (($i / $batchSize) + 1) . ": " . $e->getMessage());
                
                // Intentar insertar registro por registro
                foreach ($batch as $row) {
                    try {
                        DB::connection('mysql')->table($table)->insert($row);
                    } catch (\Exception $e2) {
                        $this->error("        ❌ Error insertando registro: " . $e2->getMessage());
                    }
                }
            }
        }

        $this->info("    ✅ Tabla {$table} migrada exitosamente");
    }
}

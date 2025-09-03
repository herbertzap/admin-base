<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tatc;
use App\Models\Operador;

class TestHermes2024Codification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hermes:test-2024-codification {--aduana=Valparaíso} {--operador=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar la nueva codificación HERMES 2024 para TATC';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Probando nueva codificación HERMES 2024...');
        
        $aduana = $this->option('aduana');
        $operadorId = $this->option('operador');
        
        $this->info("📍 Aduana: {$aduana}");
        
        if ($operadorId) {
            $operador = Operador::find($operadorId);
            if ($operador) {
                $this->info("👤 Operador: {$operador->nombre_operador} (ID: {$operador->id})");
            } else {
                $this->error("❌ Operador no encontrado con ID: {$operadorId}");
                return 1;
            }
        } else {
            $this->info("👤 Operador: Por defecto (S46 - Contenedores Tomás Dagnino)");
            $operador = null;
        }
        
        // Probar generación de números
        $this->info("\n🔢 Generando números de prueba...");
        
        for ($i = 1; $i <= 5; $i++) {
            $numero = Tatc::generarNumeroTatcHermes2024($aduana, $operador);
            $this->info("  TATC {$i}: {$numero}");
            
            // Analizar estructura
            $anio = substr($numero, 0, 4);
            $codigoAduana = substr($numero, 4, 2);
            $codigoOperador = substr($numero, 6, 3);
            $correlativo = substr($numero, 9, 7);
            
            $this->line("    📊 Estructura: {$anio}-{$codigoAduana}-{$codigoOperador}-{$correlativo}");
        }
        
        // Verificar TATCs existentes
        $this->info("\n📋 Verificando TATCs existentes...");
        $tatcsExistentes = Tatc::latest()->take(5)->get();
        
        foreach ($tatcsExistentes as $tatc) {
            $longitud = strlen($tatc->numero_tatc);
            $esHermes2024 = $longitud === 16;
            
            $status = $esHermes2024 ? '✅ HERMES 2024' : '⚠️ Formato anterior';
            $this->info("  TATC {$tatc->numero_tatc}: {$status} ({$longitud} dígitos)");
        }
        
        // Estadísticas
        $this->info("\n📊 Estadísticas:");
        $totalTatcs = Tatc::count();
        $hermes2024 = Tatc::whereRaw('LENGTH(numero_tatc) = 16')->count();
        $formatoAnterior = $totalTatcs - $hermes2024;
        
        $this->info("  Total TATCs: {$totalTatcs}");
        $this->info("  HERMES 2024: {$hermes2024}");
        $this->info("  Formato anterior: {$formatoAnterior}");
        
        $this->info("\n✅ Prueba de codificación HERMES 2024 completada.");
        return 0;
    }
}

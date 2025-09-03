<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;
use App\Jobs\EnviarHermesJob;
use Illuminate\Support\Facades\Log;

class TestHermesIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hermes:test-integration {--type=all} {--id=} {--dispatch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar la integración completa de HERMES con el sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Iniciando pruebas de integración HERMES...');
        
        $type = $this->option('type');
        $id = $this->option('id');
        $dispatch = $this->option('dispatch');

        if ($dispatch) {
            $this->testJobDispatch($type, $id);
        } else {
            $this->testDirectIntegration($type, $id);
        }

        $this->info('✅ Pruebas de integración completadas.');
    }

    /**
     * Probar el dispatch de jobs
     */
    private function testJobDispatch($type, $id)
    {
        $this->info('📤 Probando dispatch de jobs...');

        if ($type === 'all' || $type === 'tatc') {
            $tatcs = $id ? Tatc::where('id', $id)->get() : Tatc::latest()->take(3)->get();
            
            foreach ($tatcs as $tatc) {
                $this->info("  - Dispatch TATC_CREACION para TATC {$tatc->numero_tatc}");
                EnviarHermesJob::dispatch('TATC_CREACION', $tatc->id, 'Tatc');
            }
        }

        if ($type === 'all' || $type === 'tstc') {
            $tstcs = $id ? Tstc::where('id', $id)->get() : Tstc::latest()->take(3)->get();
            
            foreach ($tstcs as $tstc) {
                $this->info("  - Dispatch TSTC_CREACION para TSTC {$tstc->numero_tstc}");
                EnviarHermesJob::dispatch('TSTC_CREACION', $tstc->id, 'Tstc');
            }
        }

        if ($type === 'all' || $type === 'salida') {
            $salidas = $id ? Salida::where('id', $id)->get() : Salida::latest()->take(3)->get();
            
            foreach ($salidas as $salida) {
                $this->info("  - Dispatch SALIDA_CREACION para Salida {$salida->numero_salida}");
                EnviarHermesJob::dispatch('SALIDA_CREACION', $salida->id, 'Salida');
            }
        }

        $this->info('  ✅ Jobs dispatchados correctamente.');
    }

    /**
     * Probar la integración directa
     */
    private function testDirectIntegration($type, $id)
    {
        $this->info('🔗 Probando integración directa...');

        if ($type === 'all' || $type === 'tatc') {
            $this->testTatcIntegration($id);
        }

        if ($type === 'all' || $type === 'tstc') {
            $this->testTstcIntegration($id);
        }

        if ($type === 'all' || $type === 'salida') {
            $this->testSalidaIntegration($id);
        }
    }

    /**
     * Probar integración TATC
     */
    private function testTatcIntegration($id)
    {
        $this->info('  📦 Probando integración TATC...');
        
        $tatcs = $id ? Tatc::where('id', $id)->get() : Tatc::latest()->take(2)->get();
        
        foreach ($tatcs as $tatc) {
            $this->info("    - TATC {$tatc->numero_tatc} (ID: {$tatc->id})");
            $this->info("      Operador: " . ($tatc->user->operador->nombre_operador ?? 'N/A'));
            $this->info("      Aduana: " . ($tatc->aduana->nombre_aduana ?? 'N/A'));
            $this->info("      Contenedor: " . ($tatc->numero_contenedor ?? 'N/A'));
            $this->info("      Estado: " . ($tatc->estado ?? 'N/A'));
        }
    }

    /**
     * Probar integración TSTC
     */
    private function testTstcIntegration($id)
    {
        $this->info('  📤 Probando integración TSTC...');
        
        $tstcs = $id ? Tstc::where('id', $id)->get() : Tstc::latest()->take(2)->get();
        
        foreach ($tstcs as $tstc) {
            $this->info("    - TSTC {$tstc->numero_tstc} (ID: {$tstc->id})");
            $this->info("      Operador: " . ($tstc->user->operador->nombre_operador ?? 'N/A'));
            $this->info("      Aduana: " . ($tstc->user->aduana->nombre_aduana ?? 'N/A'));
            $this->info("      Contenedor: " . ($tstc->numero_contenedor ?? 'N/A'));
            $this->info("      Estado: " . ($tstc->estado ?? 'N/A'));
        }
    }

    /**
     * Probar integración Salida
     */
    private function testSalidaIntegration($id)
    {
        $this->info('  🚪 Probando integración Salida...');
        
        $salidas = $id ? Salida::where('id', $id)->get() : Salida::latest()->take(2)->get();
        
        foreach ($salidas as $salida) {
            $this->info("    - Salida {$salida->numero_salida} (ID: {$salida->id})");
            $this->info("      TATC: " . ($salida->tatc->numero_tatc ?? 'N/A'));
            $this->info("      Tipo: " . ($salida->tipo_salida ?? 'N/A'));
            $this->info("      Estado: " . ($salida->estado ?? 'N/A'));
        }
    }
}

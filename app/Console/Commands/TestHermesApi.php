<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Hermes\HermesService;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;

class TestHermesApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hermes:test {--type=all : Tipo de prueba (tatc, tstc, salida, all)} {--id= : ID específico del registro a probar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Probar la API de HERMES con datos reales del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando pruebas de la API de HERMES...');
        
        $type = $this->option('type');
        $id = $this->option('id');

        try {
            $hermesService = new HermesService();

            switch ($type) {
                case 'tatc':
                    $this->probarTatc($hermesService, $id);
                    break;
                case 'tstc':
                    $this->probarTstc($hermesService, $id);
                    break;
                case 'salida':
                    $this->probarSalida($hermesService, $id);
                    break;
                case 'all':
                default:
                    $this->probarTatc($hermesService, $id);
                    $this->probarTstc($hermesService, $id);
                    $this->probarSalida($hermesService, $id);
                    break;
            }

            $this->info('✅ Pruebas completadas exitosamente');
            
        } catch (\Exception $e) {
            $this->error('❌ Error durante las pruebas: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }

        return 0;
    }

    /**
     * Probar envío de TATC
     */
    private function probarTatc(HermesService $hermesService, $id = null)
    {
        $this->info('📦 Probando envío de TATC...');

        if ($id) {
            $tatc = Tatc::find($id);
            if (!$tatc) {
                $this->warn("⚠️  TATC con ID {$id} no encontrado");
                return;
            }
            $tatcs = collect([$tatc]);
        } else {
            $tatcs = Tatc::limit(2)->get();
        }

        foreach ($tatcs as $tatc) {
            $this->info("  - Enviando TATC: {$tatc->numero_tatc}");
            
            try {
                $resultado = $hermesService->enviarTatc($tatc);
                
                if ($resultado['success']) {
                    $this->info("    ✅ Enviado exitosamente (Log ID: {$resultado['log_id']})");
                } else {
                    $this->warn("    ⚠️  Error: " . ($resultado['error'] ?? 'Error desconocido'));
                }
                
            } catch (\Exception $e) {
                $this->error("    ❌ Excepción: " . $e->getMessage());
            }
        }
    }

    /**
     * Probar envío de TSTC
     */
    private function probarTstc(HermesService $hermesService, $id = null)
    {
        $this->info('📤 Probando envío de TSTC...');

        if ($id) {
            $tstc = Tstc::find($id);
            if (!$tstc) {
                $this->warn("⚠️  TSTC con ID {$id} no encontrado");
                return;
            }
            $tstcs = collect([$tstc]);
        } else {
            $tstcs = Tstc::limit(2)->get();
        }

        foreach ($tstcs as $tstc) {
            $this->info("  - Enviando TSTC: {$tstc->numero_tstc}");
            
            try {
                $resultado = $hermesService->enviarTstc($tstc);
                
                if ($resultado['success']) {
                    $this->info("    ✅ Enviado exitosamente (Log ID: {$resultado['log_id']})");
                } else {
                    $this->warn("    ⚠️  Error: " . ($resultado['error'] ?? 'Error desconocido'));
                }
                
            } catch (\Exception $e) {
                $this->error("    ❌ Excepción: " . $e->getMessage());
            }
        }
    }

    /**
     * Probar envío de Salida
     */
    private function probarSalida(HermesService $hermesService, $id = null)
    {
        $this->info('🚪 Probando envío de Salida...');

        if ($id) {
            $salida = Salida::find($id);
            if (!$salida) {
                $this->warn("⚠️  Salida con ID {$id} no encontrada");
                return;
            }
            $salidas = collect([$salida]);
        } else {
            $salidas = Salida::limit(2)->get();
        }

        foreach ($salidas as $salida) {
            $this->info("  - Enviando Salida: {$salida->numero_salida}");
            
            try {
                $resultado = $hermesService->enviarSalida($salida);
                
                if ($resultado['success']) {
                    $this->info("    ✅ Enviada exitosamente (Log ID: {$resultado['log_id']})");
                } else {
                    $this->warn("    ⚠️  Error: " . ($resultado['error'] ?? 'Error desconocido'));
                }
                
            } catch (\Exception $e) {
                $this->error("    ❌ Excepción: " . $e->getMessage());
            }
        }
    }
}

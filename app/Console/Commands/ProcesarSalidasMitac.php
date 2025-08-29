<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tatc;
use App\Models\Salida;
use App\Models\User;
use Carbon\Carbon;

class ProcesarSalidasMitac extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mitac:procesar-salidas {--tatc= : Número de TATC específico} {--force : Forzar procesamiento}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesa automáticamente las salidas desde datos de Mitac';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando procesamiento de salidas desde Mitac...');
        
        // Obtener TATCs con salidas registradas en Mitac
        $tatcsConSalidas = $this->obtenerTatcsConSalidasMitac();
        
        if (empty($tatcsConSalidas)) {
            $this->warn('⚠️  No se encontraron TATCs con salidas registradas en Mitac.');
            return;
        }
        
        $this->info("📋 Se encontraron " . count($tatcsConSalidas) . " TATCs con salidas registradas en Mitac.");
        
        $bar = $this->output->createProgressBar(count($tatcsConSalidas));
        $bar->start();
        
        $procesados = 0;
        $errores = 0;
        
        foreach ($tatcsConSalidas as $tatcData) {
            try {
                $this->procesarSalidaTatc($tatcData);
                $procesados++;
            } catch (\Exception $e) {
                $errores++;
                Log::error('Error procesando salida TATC: ' . $tatcData['numero_tatc'], [
                    'error' => $e->getMessage(),
                    'tatc_data' => $tatcData
                ]);
                $this->error("❌ Error procesando TATC {$tatcData['numero_tatc']}: " . $e->getMessage());
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info("✅ Procesamiento completado:");
        $this->info("   - TATCs procesados: {$procesados}");
        $this->info("   - Errores: {$errores}");
    }
    
    /**
     * Obtiene TATCs con salidas registradas en Mitac
     */
    private function obtenerTatcsConSalidasMitac()
    {
        // Datos basados en el historial de Mitac que me mostraste
        $tatcsConSalidas = [
            [
                'numero_tatc' => '342460000001', // Formato Mitac
                'numero_tatc_sistema' => '34246000001', // Formato nuestro sistema
                'numero_contenedor' => 'CAXU985399-1',
                'tipo_salida' => 'internacion',
                'fecha_salida' => '2017-08-31',
                'declaracion_internacion' => '3370005048-9',
                'comentario_internacion' => 'factura agencia 1997',
                'estado_mitac' => 'Salida por DI',
                'usuario_mitac' => 'Tomas Dagnino Vicencio',
                'fecha_registro_mitac' => '2019-12-09'
            ],
            // Aquí puedes agregar más TATCs con salidas registradas en Mitac
            // Basándote en los datos del historial que exportaste
        ];
        
        // Si se especifica un TATC específico, filtrar solo ese
        if ($tatcEspecifico = $this->option('tatc')) {
            $tatcsConSalidas = array_filter($tatcsConSalidas, function($tatc) use ($tatcEspecifico) {
                return $tatc['numero_tatc'] === $tatcEspecifico || $tatc['numero_tatc_sistema'] === $tatcEspecifico;
            });
        }
        
        return $tatcsConSalidas;
    }
    
    /**
     * Procesa la salida de un TATC específico
     */
    private function procesarSalidaTatc($tatcData)
    {
        // Buscar el TATC en nuestro sistema (probar ambos formatos)
        $tatc = Tatc::where('numero_tatc', $tatcData['numero_tatc_sistema'])->first();
        
        if (!$tatc) {
            // Intentar con el formato de Mitac
            $tatc = Tatc::where('numero_tatc', $tatcData['numero_tatc'])->first();
        }
        
        if (!$tatc) {
            throw new \Exception("TATC {$tatcData['numero_tatc']} no encontrado en el sistema");
        }
        
        // Verificar si ya tiene una salida registrada
        $salidaExistente = Salida::where('tatc_id', $tatc->id)
            ->where('tipo_salida', $tatcData['tipo_salida'])
            ->first();
            
        if ($salidaExistente && !$this->option('force')) {
            $this->warn("⚠️  TATC {$tatc->numero_tatc} ya tiene salida registrada. Usar --force para reprocesar.");
            return;
        }
        
        // Obtener usuario del sistema (o crear uno si no existe)
        $usuario = User::where('name', 'like', '%' . $tatcData['usuario_mitac'] . '%')->first();
        if (!$usuario) {
            // Usar el usuario por defecto o crear uno
            $usuario = User::first() ?? User::factory()->create();
        }
        
        // Generar número de salida
        $numeroSalida = Salida::generarNumeroSalida($tatc, $tatcData['tipo_salida']);
        
        // Crear o actualizar la salida
        $datosSalida = [
            'tatc_id' => $tatc->id,
            'numero_salida' => $numeroSalida,
            'fecha_salida' => $tatcData['fecha_salida'],
            'tipo_salida' => $tatcData['tipo_salida'],
            'numero_contenedor' => $tatc->numero_contenedor,
            'tipo_contenedor' => $tatc->tipo_contenedor,
            'estado_contenedor' => $tatc->estado_contenedor,
            'aduana_salida' => $tatc->aduana_ingreso,
            'estado' => 'Aprobado', // Las salidas de Mitac ya están aprobadas
            'user_id' => $usuario->id,
        ];
        
        // Agregar campos específicos según tipo de salida
        if ($tatcData['tipo_salida'] === 'internacion') {
            $datosSalida['declaracion_internacion'] = $tatcData['declaracion_internacion'];
            $datosSalida['comentario_internacion'] = $tatcData['comentario_internacion'];
        }
        
        if ($salidaExistente) {
            $salidaExistente->update($datosSalida);
            $this->info("🔄 Salida actualizada para TATC {$tatc->numero_tatc}");
        } else {
            Salida::create($datosSalida);
            $this->info("✅ Salida creada para TATC {$tatc->numero_tatc}");
        }
        
        // Actualizar estado del TATC
        $tatc->update(['estado' => 'Con Salida']);
        
        // Registrar en el historial del TATC
        $this->registrarEnHistorial($tatc, $tatcData);
    }
    
    /**
     * Registra la acción en el historial del TATC
     */
    private function registrarEnHistorial($tatc, $tatcData)
    {
        $accion = '';
        switch($tatcData['tipo_salida']) {
            case 'internacion':
                $accion = 'Genera Salida por DI';
                break;
            case 'cancelacion':
                $accion = 'Genera Salida por Cancelación';
                break;
            case 'traspaso':
                $accion = 'Genera Salida por Traspaso';
                break;
            default:
                $accion = 'Genera Salida';
        }
        
        // Aquí registrarías en el historial del TATC
        // Por ahora solo log
        Log::info("Historial TATC {$tatc->numero_tatc}: {$accion}", [
            'fecha' => $tatcData['fecha_salida'],
            'usuario' => $tatcData['usuario_mitac'],
            'tipo_salida' => $tatcData['tipo_salida']
        ]);
    }
}

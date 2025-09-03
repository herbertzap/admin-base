<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Hermes\HermesService;
use Illuminate\Support\Facades\Log;

class EnviarHermesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120; // 2 minutos
    public $tries = 3; // 3 intentos

    protected $tipoOperacion;
    protected $modeloId;
    protected $modeloTipo;

    /**
     * Create a new job instance.
     */
    public function __construct(string $tipoOperacion, int $modeloId, string $modeloTipo)
    {
        $this->tipoOperacion = $tipoOperacion;
        $this->modeloId = $modeloId;
        $this->modeloTipo = $modeloTipo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $hermesService = app(HermesService::class);
            
            // Obtener el modelo según el tipo
            $modelo = $this->obtenerModelo();
            
            if (!$modelo) {
                Log::error('EnviarHermesJob: No se pudo obtener el modelo', [
                    'tipo' => $this->modeloTipo,
                    'id' => $this->modeloId
                ]);
                return;
            }

            // Enviar según el tipo de operación
            $resultado = null;
            
            switch($this->tipoOperacion) {
                case 'TATC_CREACION':
                    $resultado = $hermesService->enviarTatc($modelo);
                    break;
                case 'TATC_MODIFICACION':
                    $resultado = $hermesService->enviarModificacionTatc($modelo);
                    break;
                case 'TATC_CANCELACION':
                    $resultado = $hermesService->enviarCancelacionTatc($modelo);
                    break;
                case 'TATC_TRASPASO':
                    $resultado = $hermesService->enviarTraspasoTatc($modelo);
                    break;
                case 'TATC_CUMPLIDO':
                    $resultado = $hermesService->enviarCumplidoTatc($modelo);
                    break;
                case 'TSTC_CREACION':
                    $resultado = $hermesService->enviarTstc($modelo);
                    break;
                case 'TSTC_MODIFICACION':
                    $resultado = $hermesService->enviarTstc($modelo);
                    break;
                case 'SALIDA_CREACION':
                    $resultado = $hermesService->enviarSalida($modelo);
                    break;
                default:
                    throw new \Exception("Tipo de operación no válido: {$this->tipoOperacion}");
            }

            if ($resultado['success']) {
                Log::info('EnviarHermesJob: Envío exitoso a HERMES', [
                    'tipo_operacion' => $this->tipoOperacion,
                    'modelo_tipo' => $this->modeloTipo,
                    'modelo_id' => $this->modeloId
                ]);
            } else {
                Log::warning('EnviarHermesJob: Envío fallido a HERMES', [
                    'tipo_operacion' => $this->tipoOperacion,
                    'modelo_tipo' => $this->modeloTipo,
                    'modelo_id' => $this->modeloId,
                    'error' => $resultado['error'] ?? 'Error desconocido'
                ]);
                
                // Reintentar el job
                $this->fail(new \Exception($resultado['error'] ?? 'Error desconocido'));
            }

        } catch (\Exception $e) {
            Log::error('EnviarHermesJob: Error en el job', [
                'tipo_operacion' => $this->tipoOperacion,
                'modelo_tipo' => $this->modeloTipo,
                'modelo_id' => $this->modeloId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }

    /**
     * Obtener el modelo según el tipo
     */
    private function obtenerModelo()
    {
        switch($this->modeloTipo) {
            case 'Tatc':
                return \App\Models\Tatc::find($this->modeloId);
            case 'Tstc':
                return \App\Models\Tstc::find($this->modeloId);
            case 'Salida':
                return \App\Models\Salida::find($this->modeloId);
            default:
                return null;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('EnviarHermesJob: Job falló definitivamente', [
            'tipo_operacion' => $this->tipoOperacion,
            'modelo_tipo' => $this->modeloTipo,
            'modelo_id' => $this->modeloId,
            'error' => $exception->getMessage()
        ]);
    }
}

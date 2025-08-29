<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tatc;
use App\Models\Salida;
use App\Models\User;
use Carbon\Carbon;

class ProcesarSalidaTatcEspecifico extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mitac:procesar-tatc-especifico {numero_tatc} {--force : Forzar procesamiento}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Procesa la salida de un TATC específico desde datos de Mitac';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $numeroTatc = $this->argument('numero_tatc');
        
        $this->info("🚀 Procesando salida para TATC: {$numeroTatc}");
        
        // Buscar el TATC en nuestro sistema
        $tatc = Tatc::where('numero_tatc', $numeroTatc)->first();
        
        if (!$tatc) {
            $this->error("❌ TATC {$numeroTatc} no encontrado en el sistema.");
            return 1;
        }
        
        $this->info("✅ TATC encontrado: {$tatc->numero_contenedor}");
        
        // Verificar si ya tiene una salida registrada
        $salidaExistente = Salida::where('tatc_id', $tatc->id)->first();
        
        if ($salidaExistente && !$this->option('force')) {
            $this->warn("⚠️  TATC {$numeroTatc} ya tiene salida registrada. Usar --force para reprocesar.");
            return 0;
        }
        
        // Datos de la salida basados en el historial de Mitac
        $datosSalida = $this->obtenerDatosSalida($numeroTatc);
        
        if (!$datosSalida) {
            $this->error("❌ No se encontraron datos de salida para TATC {$numeroTatc}.");
            return 1;
        }
        
        try {
            $this->crearSalida($tatc, $datosSalida);
            $this->info("✅ Salida procesada exitosamente para TATC {$numeroTatc}");
        } catch (\Exception $e) {
            $this->error("❌ Error procesando salida: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Obtiene los datos de salida según el número de TATC
     */
    private function obtenerDatosSalida($numeroTatc)
    {
        // Datos basados en el historial de Mitac que me mostraste
        $datosSalidas = [
            '342460000001' => [
                'tipo_salida' => 'internacion',
                'fecha_salida' => '2017-08-31',
                'declaracion_internacion' => '3370005048-9',
                'comentario_internacion' => 'factura agencia 1997',
                'estado_mitac' => 'Salida por DI',
                'usuario_mitac' => 'Tomas Dagnino Vicencio'
            ]
        ];
        
        return $datosSalidas[$numeroTatc] ?? null;
    }
    
    /**
     * Crea la salida en el sistema
     */
    private function crearSalida($tatc, $datosSalida)
    {
        // Obtener usuario del sistema
        $usuario = User::first();
        
        // Generar número de salida
        $numeroSalida = Salida::generarNumeroSalida($tatc, $datosSalida['tipo_salida']);
        
        // Preparar datos de la salida con todos los campos obligatorios
        $datos = [
            'tatc_id' => $tatc->id,
            'numero_salida' => $numeroSalida,
            'fecha_salida' => $datosSalida['fecha_salida'],
            'tipo_salida' => $datosSalida['tipo_salida'],
            'numero_contenedor' => $tatc->numero_contenedor,
            'tipo_contenedor' => $tatc->tipo_contenedor,
            'aduana_salida' => $tatc->aduana_ingreso,
            'estado' => 'Aprobado',
            'user_id' => $usuario->id,
        ];
        
        // Agregar campos específicos según tipo de salida
        if ($datosSalida['tipo_salida'] === 'internacion') {
            $datos['declaracion_internacion'] = $datosSalida['declaracion_internacion'];
            $datos['comentario_internacion'] = $datosSalida['comentario_internacion'];
        }
        
        // Verificar si ya existe una salida
        $salidaExistente = Salida::where('tatc_id', $tatc->id)->first();
        
        if ($salidaExistente) {
            $salidaExistente->update($datos);
            $this->info("🔄 Salida actualizada");
        } else {
            Salida::create($datos);
            $this->info("✅ Salida creada");
        }
        
        // Actualizar estado del TATC
        $tatc->update(['estado' => 'Con Salida']);
        $this->info("🔄 Estado del TATC actualizado a 'Con Salida'");
        
        // Registrar en log
        Log::info("Salida procesada para TATC {$tatc->numero_tatc}", [
            'tipo_salida' => $datosSalida['tipo_salida'],
            'fecha_salida' => $datosSalida['fecha_salida'],
            'usuario_mitac' => $datosSalida['usuario_mitac']
        ]);
    }
}

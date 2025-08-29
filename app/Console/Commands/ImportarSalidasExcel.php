<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tatc;
use App\Models\Salida;
use App\Models\User;
use Carbon\Carbon;

class ImportarSalidasExcel extends Command
{
    protected $signature = 'mitac:importar-salidas-excel {archivo : Ruta al archivo Excel} {--force : Forzar importación}';
    protected $description = 'Importa salidas desde archivo Excel exportado de Mitac';

    public function handle()
    {
        $archivo = $this->argument('archivo');
        
        if (!file_exists($archivo)) {
            $this->error("❌ Archivo no encontrado: {$archivo}");
            return 1;
        }
        
        $this->info("📁 Procesando archivo: {$archivo}");
        
        // Leer el archivo Excel (simulado por ahora)
        $datos = $this->leerArchivoExcel($archivo);
        
        if (empty($datos)) {
            $this->warn("⚠️  No se encontraron datos en el archivo");
            return 0;
        }
        
        $this->info("📊 Se encontraron " . count($datos) . " registros para procesar");
        
        $bar = $this->output->createProgressBar(count($datos));
        $bar->start();
        
        $procesados = 0;
        $errores = 0;
        
        foreach ($datos as $registro) {
            try {
                $this->procesarRegistro($registro);
                $procesados++;
            } catch (\Exception $e) {
                $errores++;
                $this->error("❌ Error: " . $e->getMessage());
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info("✅ Importación completada:");
        $this->info("   - Registros procesados: {$procesados}");
        $this->info("   - Errores: {$errores}");
    }
    
    private function leerArchivoExcel($archivo)
    {
        // Por ahora, simular datos basados en el historial que me mostraste
        return [
            [
                'numero_tatc' => '342460000001',
                'numero_contenedor' => 'CAXU985399-1',
                'estado' => 'Salida por DI',
                'declaracion_internacion' => '3370005048-9',
                'fecha_internacion' => '31/08/2017',
                'comentario_internacion' => 'factura agencia 1997',
                'usuario' => 'Tomas Dagnino Vicencio',
                'fecha_registro' => '09/12/2019'
            ]
        ];
    }
    
    private function procesarRegistro($registro)
    {
        // Buscar TATC
        $tatc = Tatc::where('numero_tatc', $registro['numero_tatc'])->first();
        
        if (!$tatc) {
            throw new \Exception("TATC {$registro['numero_tatc']} no encontrado");
        }
        
        // Determinar tipo de salida
        $tipoSalida = $this->determinarTipoSalida($registro['estado']);
        
        // Crear salida
        $salida = Salida::create([
            'tatc_id' => $tatc->id,
            'numero_salida' => Salida::generarNumeroSalida($tatc, $tipoSalida),
            'fecha_salida' => Carbon::createFromFormat('d/m/Y', $registro['fecha_internacion']),
            'tipo_salida' => $tipoSalida,
            'estado' => 'Aprobado',
            'user_id' => User::first()->id,
            'declaracion_internacion' => $registro['declaracion_internacion'] ?? null,
            'comentario_internacion' => $registro['comentario_internacion'] ?? null,
        ]);
        
        // Actualizar estado del TATC
        $tatc->update(['estado' => 'Con Salida']);
        
        $this->info("✅ Salida creada para TATC {$registro['numero_tatc']}");
    }
    
    private function determinarTipoSalida($estado)
    {
        switch($estado) {
            case 'Salida por DI':
                return 'internacion';
            case 'Salida por Cancelación':
                return 'cancelacion';
            case 'Salida por Traspaso':
                return 'traspaso';
            default:
                return 'internacion';
        }
    }
}

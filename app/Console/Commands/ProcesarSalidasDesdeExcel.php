<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tatc;
use App\Models\Salida;
use App\Models\User;
use Carbon\Carbon;

class ProcesarSalidasDesdeExcel extends Command
{
    protected $signature = 'mitac:procesar-excel {archivo : Ruta al archivo Excel} {--force : Forzar procesamiento}';
    protected $description = 'Procesa salidas desde archivo Excel exportado de Mitac';

    public function handle()
    {
        $archivo = $this->argument('archivo');
        
        if (!file_exists($archivo)) {
            $this->error("❌ Archivo no encontrado: {$archivo}");
            return 1;
        }
        
        $this->info("📁 Procesando archivo: {$archivo}");
        
        // Leer datos del archivo Excel (simulado por ahora)
        $datos = $this->leerDatosExcel($archivo);
        
        if (empty($datos)) {
            $this->warn("⚠️  No se encontraron datos en el archivo");
            return 0;
        }
        
        $this->info("📊 Se encontraron " . count($datos) . " registros para procesar");
        
        $bar = $this->output->createProgressBar(count($datos));
        $bar->start();
        
        $procesados = 0;
        $errores = 0;
        $noEncontrados = 0;
        
        foreach ($datos as $registro) {
            try {
                $resultado = $this->procesarRegistro($registro);
                if ($resultado === 'procesado') {
                    $procesados++;
                } elseif ($resultado === 'no_encontrado') {
                    $noEncontrados++;
                }
            } catch (\Exception $e) {
                $errores++;
                $this->error("❌ Error: " . $e->getMessage());
            }
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info("✅ Procesamiento completado:");
        $this->info("   - Registros procesados: {$procesados}");
        $this->info("   - TATCs no encontrados: {$noEncontrados}");
        $this->info("   - Errores: {$errores}");
    }
    
    private function leerDatosExcel($archivo)
    {
        // Por ahora, simular datos basados en el historial que me mostraste
        // En el futuro, aquí se implementaría la lectura real del archivo Excel
        return [
            [
                'numero_tatc' => '342460000001', // Formato Mitac
                'numero_tatc_sistema' => '34246000001', // Formato nuestro sistema
                'numero_contenedor' => 'CAXU985399-1',
                'estado' => 'Salida por DI',
                'declaracion_internacion' => '3370005048-9',
                'fecha_internacion' => '31/08/2017',
                'comentario_internacion' => 'factura agencia 1997',
                'usuario' => 'Tomas Dagnino Vicencio',
                'fecha_registro' => '09/12/2019'
            ],
            // Aquí agregarías más registros del archivo Excel
        ];
    }
    
    private function procesarRegistro($registro)
    {
        // Buscar TATC en nuestro sistema
        $tatc = Tatc::where('numero_tatc', $registro['numero_tatc_sistema'])->first();
        
        if (!$tatc) {
            // Intentar con el formato de Mitac
            $tatc = Tatc::where('numero_tatc', $registro['numero_tatc'])->first();
        }
        
        if (!$tatc) {
            $this->warn("⚠️  TATC {$registro['numero_tatc']} no encontrado en el sistema");
            return 'no_encontrado';
        }
        
        // Determinar tipo de salida
        $tipoSalida = $this->determinarTipoSalida($registro['estado']);
        
        // Verificar si ya tiene salida registrada
        $salidaExistente = Salida::where('tatc_id', $tatc->id)
            ->where('tipo_salida', $tipoSalida)
            ->first();
            
        if ($salidaExistente && !$this->option('force')) {
            $this->warn("⚠️  TATC {$tatc->numero_tatc} ya tiene salida registrada");
            return 'ya_existe';
        }
        
        // Obtener usuario
        $usuario = User::where('name', 'like', '%' . $registro['usuario'] . '%')->first();
        if (!$usuario) {
            $usuario = User::first();
        }
        
        // Crear salida
        $datosSalida = [
            'tatc_id' => $tatc->id,
            'numero_salida' => Salida::generarNumeroSalida($tatc, $tipoSalida),
            'fecha_salida' => Carbon::createFromFormat('d/m/Y', $registro['fecha_internacion']),
            'tipo_salida' => $tipoSalida,
            'numero_contenedor' => $tatc->numero_contenedor,
            'tipo_contenedor' => $tatc->tipo_contenedor,
            'estado_contenedor' => $tatc->estado_contenedor,
            'aduana_salida' => $tatc->aduana_ingreso,
            'estado' => 'Aprobado',
            'user_id' => $usuario->id,
        ];
        
        // Agregar campos específicos según tipo de salida
        if ($tipoSalida === 'internacion') {
            $datosSalida['declaracion_internacion'] = $registro['declaracion_internacion'] ?? null;
            $datosSalida['comentario_internacion'] = $registro['comentario_internacion'] ?? null;
        }
        
        if ($salidaExistente) {
            $salidaExistente->update($datosSalida);
        } else {
            Salida::create($datosSalida);
        }
        
        // Actualizar estado del TATC
        $tatc->update(['estado' => 'Con Salida']);
        
        $this->info("✅ Salida procesada para TATC {$tatc->numero_tatc}");
        return 'procesado';
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

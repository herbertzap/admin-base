<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tatc;
use App\Models\Salida;
use App\Models\User;
use Carbon\Carbon;

class ImportarSalidasDesdeExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mitac:importar-salidas-excel {archivo : Ruta al archivo Excel} {--force : Forzar procesamiento}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa salidas desde archivo Excel de historial de Mitac';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $archivo = $this->argument('archivo');
        
        if (!file_exists($archivo)) {
            $this->error("❌ El archivo {$archivo} no existe.");
            return 1;
        }
        
        $this->info("📁 Procesando archivo: {$archivo}");
        
        // Leer el archivo Excel/HTML
        $contenido = file_get_contents($archivo);
        
        // Extraer datos de salidas
        $salidas = $this->extraerSalidasDelArchivo($contenido);
        
        if (empty($salidas)) {
            $this->warn("⚠️  No se encontraron salidas en el archivo.");
            return 0;
        }
        
        $this->info("📋 Se encontraron " . count($salidas) . " salidas en el archivo.");
        
        $bar = $this->output->createProgressBar(count($salidas));
        $bar->start();
        
        $procesados = 0;
        $errores = 0;
        
        foreach ($salidas as $salidaData) {
            try {
                $this->procesarSalida($salidaData);
                $procesados++;
            } catch (\Exception $e) {
                $errores++;
                Log::error('Error procesando salida: ' . $salidaData['numero_tatc'], [
                    'error' => $e->getMessage(),
                    'salida_data' => $salidaData
                ]);
                $this->error("❌ Error procesando TATC {$salidaData['numero_tatc']}: " . $e->getMessage());
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        $this->info("✅ Importación completada:");
        $this->info("   - Salidas procesadas: {$procesados}");
        $this->info("   - Errores: {$errores}");
        
        return 0;
    }
    
    /**
     * Extrae las salidas del archivo HTML/Excel
     */
    private function extraerSalidasDelArchivo($contenido)
    {
        $salidas = [];
        
        // Buscar filas que contengan "Salida por DI" o similar
        $patrones = [
            '/Salida por DI/',
            '/Salida por Cancelación/',
            '/Salida por Traspaso/'
        ];
        
        // Dividir el contenido en líneas
        $lineas = explode("\n", $contenido);
        
        foreach ($lineas as $linea) {
            // Buscar líneas que contengan datos de TATC con salidas
            if (preg_match('/<td>(\d{12})<\/td>/', $linea, $matches)) {
                $numeroTatc = $matches[1];
                
                // Buscar información de salida en las siguientes líneas
                $salidaInfo = $this->buscarInformacionSalida($lineas, $linea);
                
                if ($salidaInfo) {
                    $salidas[] = array_merge(['numero_tatc' => $numeroTatc], $salidaInfo);
                }
            }
        }
        
        return $salidas;
    }
    
    /**
     * Busca información de salida en las líneas del archivo
     */
    private function buscarInformacionSalida($lineas, $lineaActual)
    {
        // Buscar campos específicos de salida
        $salidaInfo = [];
        
        // Buscar declaración de internación
        if (preg_match('/<td>(\d{9,10}-\d)<\/td>/', $lineaActual, $matches)) {
            $salidaInfo['declaracion_internacion'] = $matches[1];
            $salidaInfo['tipo_salida'] = 'internacion';
        }
        
        // Buscar fecha de internación
        if (preg_match('/<td>(\d{2}\/\d{2}\/\d{4})<\/td>/', $lineaActual, $matches)) {
            $salidaInfo['fecha_salida'] = $this->convertirFecha($matches[1]);
        }
        
        // Buscar comentario de internación
        if (preg_match('/<td>([^<]+)<\/td>/', $lineaActual, $matches)) {
            $salidaInfo['comentario_internacion'] = trim($matches[1]);
        }
        
        return !empty($salidaInfo) ? $salidaInfo : null;
    }
    
    /**
     * Convierte fecha de formato dd/mm/yyyy a yyyy-mm-dd
     */
    private function convertirFecha($fecha)
    {
        $partes = explode('/', $fecha);
        if (count($partes) === 3) {
            return $partes[2] . '-' . $partes[1] . '-' . $partes[0];
        }
        return $fecha;
    }
    
    /**
     * Procesa una salida individual
     */
    private function procesarSalida($salidaData)
    {
        // Buscar el TATC en nuestro sistema
        $tatc = Tatc::where('numero_tatc', $salidaData['numero_tatc'])->first();
        
        if (!$tatc) {
            throw new \Exception("TATC {$salidaData['numero_tatc']} no encontrado en el sistema");
        }
        
        // Verificar si ya tiene una salida registrada
        $salidaExistente = Salida::where('tatc_id', $tatc->id)
            ->where('tipo_salida', $salidaData['tipo_salida'])
            ->first();
            
        if ($salidaExistente && !$this->option('force')) {
            $this->warn("⚠️  TATC {$salidaData['numero_tatc']} ya tiene salida registrada.");
            return;
        }
        
        // Obtener usuario del sistema
        $usuario = User::first();
        
        // Generar número de salida
        $numeroSalida = Salida::generarNumeroSalida($tatc, $salidaData['tipo_salida']);
        
        // Crear o actualizar la salida
        $datosSalida = [
            'tatc_id' => $tatc->id,
            'numero_salida' => $numeroSalida,
            'fecha_salida' => $salidaData['fecha_salida'],
            'tipo_salida' => $salidaData['tipo_salida'],
            'estado' => 'Aprobado',
            'user_id' => $usuario->id,
        ];
        
        // Agregar campos específicos según tipo de salida
        if ($salidaData['tipo_salida'] === 'internacion') {
            $datosSalida['declaracion_internacion'] = $salidaData['declaracion_internacion'] ?? null;
            $datosSalida['comentario_internacion'] = $salidaData['comentario_internacion'] ?? null;
        }
        
        if ($salidaExistente) {
            $salidaExistente->update($datosSalida);
        } else {
            Salida::create($datosSalida);
        }
        
        // Actualizar estado del TATC
        $tatc->update(['estado' => 'Con Salida']);
        
        $this->info("✅ Salida procesada para TATC {$salidaData['numero_tatc']}");
    }
}

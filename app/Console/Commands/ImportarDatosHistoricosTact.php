<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tatc;
use App\Models\Operador;
use App\Models\AduanaChile;
use App\Models\EmpresaTransportista;
use App\Models\User;
use Carbon\Carbon;
// Los archivos .xls son realmente HTML, no Excel real

class ImportarDatosHistoricosTact extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tact:importar-historico {--file= : Archivo específico a procesar} {--force : Forzar importación}';

    /**
     * The console description.
     *
     * @var string
     */
    protected $description = 'Importa datos históricos de TACT desde archivos Excel de Mitac';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando importación de datos históricos de TACT...');
        
        $directorio = 'docs/datos-tact';
        
        if (!is_dir($directorio)) {
            $this->error("❌ El directorio {$directorio} no existe.");
            return 1;
        }
        
        $archivos = glob($directorio . '/*.xls');
        
        if (empty($archivos)) {
            $this->error("❌ No se encontraron archivos .xls en {$directorio}");
            return 1;
        }
        
        $this->info("📁 Se encontraron " . count($archivos) . " archivos para procesar:");
        foreach ($archivos as $archivo) {
            $this->line("   - " . basename($archivo));
        }
        
        if ($this->option('file')) {
            $archivoEspecifico = $directorio . '/' . $this->option('file');
            if (!in_array($archivoEspecifico, $archivos)) {
                $this->error("❌ El archivo especificado no existe en {$directorio}");
                return 1;
            }
            $archivos = [$archivoEspecifico];
            $this->info("🎯 Procesando solo el archivo: " . basename($archivoEspecifico));
        }
        
        if (!$this->option('force') && !$this->confirm('¿Deseas continuar con la importación?')) {
            $this->info('❌ Importación cancelada por el usuario.');
            return 0;
        }
        
        $totalProcesados = 0;
        $totalErrores = 0;
        
        foreach ($archivos as $archivo) {
            $this->info("\n📋 Procesando: " . basename($archivo));
            
            try {
                $resultado = $this->procesarArchivo($archivo);
                $totalProcesados += $resultado['procesados'];
                $totalErrores += $resultado['errores'];
                
                $this->info("✅ Archivo procesado: {$resultado['procesados']} registros, {$resultado['errores']} errores");
                
            } catch (\Exception $e) {
                $this->error("❌ Error procesando archivo " . basename($archivo) . ": " . $e->getMessage());
                Log::error('Error procesando archivo TACT: ' . $archivo, [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $totalErrores++;
            }
        }
        
        $this->newLine();
        $this->info("🎉 Importación completada:");
        $this->info("   - Total de registros procesados: {$totalProcesados}");
        $this->info("   - Total de errores: {$totalErrores}");
        
        return 0;
    }
    
    /**
     * Procesa un archivo Excel y extrae los datos
     */
    private function procesarArchivo($archivo)
    {
        $this->info("📁 Procesando archivo: " . basename($archivo));
        
        // Leer contenido del archivo
        $contenido = file_get_contents($archivo);
        if (!$contenido) {
            $this->error("❌ No se pudo leer el archivo: " . basename($archivo));
            return ['procesados' => 0, 'errores' => 1];
        }
        
        // Extraer filas del HTML
        $filas = $this->extraerFilasDelHTML($contenido);
        
        if (empty($filas)) {
            $this->warn("⚠️  No se encontraron datos en el archivo: " . basename($archivo));
            return ['procesados' => 0, 'errores' => 1];
        }
        
        $procesados = 0;
        $errores = 0;
        
        // IMPORTANTE: Cada archivo representa UN SOLO TATC con su historial
        // Solo procesamos la PRIMERA fila para obtener la información básica del TATC
        $primeraFila = $filas[0];
        
        try {
            // Solo crear el historial de importación, no actualizar TATCs existentes
            $tatc = Tatc::where('numero_tatc', $primeraFila[6])->first();
            if ($tatc) {
                $this->guardarHistorialImportacion($tatc, $filas, basename($archivo));
                $procesados = 1; // Solo 1 TATC por archivo
            } else {
                $this->warn("⚠️  TATC no encontrado: " . $primeraFila[6]);
                $errores++;
            }
        } catch (\Exception $e) {
            $errores++;
            Log::error('Error procesando TATC del archivo: ' . basename($archivo), [
                'error' => $e->getMessage(),
                'fila' => $primeraFila
            ]);
            $this->error("❌ Error procesando archivo " . basename($archivo) . ": " . $e->getMessage());
        }
        
        return [
            'procesados' => $procesados,
            'errores' => $errores
        ];
    }
    
    /**
     * Extrae las filas del archivo HTML
     */
    private function extraerFilasDelHTML($contenido)
    {
        $filas = [];
        
        // Buscar todas las filas de datos (tr con td)
        preg_match_all('/<tr>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>\s*<td>(.*?)<\/td>/s', $contenido, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            // Limpiar HTML tags y espacios
            $fila = array_map(function($celda) {
                return trim(strip_tags($celda));
            }, array_slice($match, 1)); // Saltar el match completo, solo las celdas
            
            $filas[] = $fila;
        }
        
        return $filas;
    }
    
    /**
     * Procesa UN TATC desde un archivo (no múltiples filas)
     */
    private function procesarTatcDelArchivo($fila, $archivo)
    {
        // Mapear campos del Excel a variables
        $operador = $fila[0] ?? '';
        $tipoIngreso = $fila[1] ?? '';
        $fechaIngresoPais = $fila[2] ?? '';
        $fechaIngresoDeposito = $fila[3] ?? '';
        $numeroContenedor = $fila[4] ?? '';
        $aduana = $fila[5] ?? '';
        $numeroTatc = $fila[6] ?? '';
        $eir = $fila[7] ?? '';
        $tatcOrigen = $fila[8] ?? '';
        $tatcDestino = $fila[9] ?? '';
        $tipoContenedor = $fila[10] ?? '';
        $tamanoContenedor = $fila[11] ?? '';
        $documentoIngreso = $fila[12] ?? '';
        $puertoIngreso = $fila[13] ?? '';
        $tatcEmisor = $fila[14] ?? '';
        $tatcIngreso = $fila[15] ?? '';
        $fechaTraspaso = $fila[16] ?? '';
        $taraContenedor = $fila[17] ?? '';
        $anioFabricacion = $fila[18] ?? '';
        $estadoContenedor = $fila[19] ?? '';
        $tipoBulto = $fila[20] ?? '';
        $valorCif = $fila[21] ?? '';
        $comentario = $fila[22] ?? '';
        $fechaRegistro = $fila[23] ?? '';
        $usuarioRegistro = $fila[24] ?? '';
        $estado = $fila[25] ?? '';
        
        // Validar datos mínimos requeridos
        if (empty($numeroTatc) || empty($numeroContenedor)) {
            $this->warn("⚠️  Fila sin número TATC o contenedor válido en " . basename($archivo));
            return false;
        }
        
        // Verificar si el TATC ya existe
        $tatcExistente = Tatc::where('numero_tatc', $numeroTatc)->first();
        
        if ($tatcExistente) {
            // Actualizar TATC existente
            $this->actualizarTatc($tatcExistente, $fila);
            $this->info("🔄 TATC actualizado: {$tatcExistente->numero_tatc}");
        } else {
            // Crear nuevo TATC
            $tatc = $this->crearTatc($fila);
            $this->info("✅ TATC creado: {$tatc->numero_tatc}");
        }
        
        return true;
    }
    
    /**
     * Crea un nuevo TATC
     */
    private function crearTatc($row)
    {
        // Obtener o crear operador
        $operador = $this->obtenerOCrearOperador($row[0]);
        
        // Obtener o crear aduana
        $aduana = $this->obtenerOCrearAduana($row[5]);
        
        // Obtener usuario del sistema
        $usuario = User::first();
        
        $tatc = new Tatc();
        $tatc->numero_tatc = $row[6];
        $tatc->numero_contenedor = $row[4];
        $tatc->tipo_contenedor = $row[10];
        $tatc->tipo_ingreso = $this->mapearTipoIngreso($row[1]);
        $tatc->ingreso_pais = $this->parsearFecha($row[2]);
        $tatc->ingreso_deposito = $this->parsearFecha($row[3]);
        $tatc->tatc_origen = $row[8];
        $tatc->tatc_destino = $row[9];
        $tatc->documento_ingreso = $row[12];
        $tatc->fecha_traspaso = $this->parsearFecha($row[16]);
        $tatc->tara_contenedor = $this->parsearNumero($row[17]);
        $tatc->tipo_bulto = $row[20];
        $tatc->valor_cif = $this->parsearNumero($row[21]);
        $tatc->comentario = $row[22];
        $tatc->aduana_ingreso = $row[5];
        $tatc->eir = $row[7];
        $tatc->tamano_contenedor = $this->mapearTamanoContenedor($row[11]);
        $tatc->puerto_ingreso = $row[13];
        $tatc->estado_contenedor = $this->mapearEstadoContenedor($row[19]);
        $tatc->anio_fabricacion = $this->parsearNumero($row[18]);
        $tatc->estado = $this->mapearEstado($row[25]);
        $tatc->user_id = $usuario ? $usuario->id : 1;
        
        // Asignar valores por defecto para campos requeridos
        $tatc->ubicacion_fisica = $row[13] ?? 'Puerto'; // Puerto de ingreso como ubicación por defecto
        $tatc->valor_fob = $this->parsearNumero($row[21]); // Usar valor CIF como FOB por defecto
        
        // Nota: La tabla tatcs no tiene campo operador_id en la estructura actual
        
        $tatc->save();
        
        return $tatc;
    }
    
    /**
     * Actualiza un TATC existente
     */
    private function actualizarTatc($tatc, $row)
    {
        $tatc->tipo_ingreso = $this->mapearTipoIngreso($row[1]);
        $tatc->ingreso_pais = $this->parsearFecha($row[2]);
        $tatc->ingreso_deposito = $this->parsearFecha($row[3]);
        $tatc->tatc_origen = $row[8];
        $tatc->tatc_destino = $row[9];
        $tatc->documento_ingreso = $row[12];
        $tatc->fecha_traspaso = $this->parsearFecha($row[16]);
        $tatc->tara_contenedor = $this->parsearNumero($row[17]);
        $tatc->tipo_bulto = $row[20];
        $tatc->valor_cif = $this->parsearNumero($row[21]);
        $tatc->comentario = $row[22];
        $tatc->eir = $row[7];
        $tatc->tamano_contenedor = $this->mapearTamanoContenedor($row[11]);
        $tatc->puerto_ingreso = $row[13];
        $tatc->estado_contenedor = $this->mapearEstadoContenedor($row[19]);
        $tatc->anio_fabricacion = $this->parsearNumero($row[18]);
        $tatc->estado = $this->mapearEstado($row[25]);
        
        $tatc->save();
        
        return $tatc;
    }
    
    /**
     * Obtiene o crea un operador
     */
    private function obtenerOCrearOperador($nombreOperador)
    {
        if (empty($nombreOperador)) {
            return null;
        }
        
        // Primero buscar por nombre exacto
        $operador = Operador::where('nombre_operador', $nombreOperador)->first();
        
        // Si no existe, buscar por nombre similar
        if (!$operador) {
            $operador = Operador::where('nombre_operador', 'like', "%{$nombreOperador}%")->first();
        }
        
        // Si no existe, usar el operador existente o crear uno nuevo
        if (!$operador) {
            // Usar el operador existente si es el mismo nombre
            if (strpos($nombreOperador, 'DAVI') !== false || strpos($nombreOperador, 'CONTENEDORES DAVI') !== false) {
                $operador = Operador::where('codigo', 'S46')->first();
            } else {
                // Crear nuevo operador con RUT válido
                $operador = new Operador();
                $operador->nombre_operador = $nombreOperador;
                $operador->codigo = 'OP' . rand(100, 999);
                $operador->rut_operador = $this->generarRutValido();
                $operador->estado = 'Activo';
                $operador->save();
            }
        }
        
        return $operador;
    }
    
    /**
     * Genera un RUT válido para operadores
     */
    private function generarRutValido()
    {
        // Generar un RUT válido (formato: 12345678-9)
        $numero = rand(10000000, 99999999);
        $dv = $this->calcularDigitoVerificador($numero);
        return $numero . '-' . $dv;
    }
    
    /**
     * Calcula el dígito verificador de un RUT
     */
    private function calcularDigitoVerificador($numero)
    {
        $suma = 0;
        $multiplicador = 2;
        
        while ($numero > 0) {
            $suma += ($numero % 10) * $multiplicador;
            $numero = intval($numero / 10);
            $multiplicador = $multiplicador == 7 ? 2 : $multiplicador + 1;
        }
        
        $resto = $suma % 11;
        $dv = 11 - $resto;
        
        if ($dv == 11) return '0';
        if ($dv == 10) return 'K';
        return $dv;
    }
    
    /**
     * Obtiene o crea una aduana
     */
    private function obtenerOCrearAduana($codigoAduana)
    {
        if (empty($codigoAduana)) {
            return null;
        }
        
        // Primero buscar por código
        $aduana = AduanaChile::where('codigo', $codigoAduana)->first();
        
        // Si no existe, buscar por nombre
        if (!$aduana) {
            $aduana = AduanaChile::where('nombre_aduana', $codigoAduana)->first();
        }
        
        // Si no existe, crear una nueva
        if (!$aduana) {
            $aduana = new AduanaChile();
            $aduana->codigo = $codigoAduana;
            $aduana->nombre_aduana = $codigoAduana;
            $aduana->estado = 'Activo';
            $aduana->save();
        }
        
        return $aduana;
    }
    
    /**
     * Mapea el tipo de ingreso
     */
    private function mapearTipoIngreso($tipo)
    {
        $mapeo = [
            'Traspaso' => 'Por Traspaso',
            'Desembarque' => 'Por Desembarque',
            'Reingreso' => 'Por Reingreso'
        ];
        
        return $mapeo[$tipo] ?? 'Por Traspaso';
    }
    
    /**
     * Mapea el tamaño del contenedor
     */
    private function mapearTamanoContenedor($tamano)
    {
        if (strpos($tamano, '40') !== false) {
            return '40';
        } elseif (strpos($tamano, '20') !== false) {
            return '20';
        } elseif (strpos($tamano, '45') !== false) {
            return '45';
        }
        
        return '40';
    }
    
    /**
     * Mapea el estado del contenedor
     */
    private function mapearEstadoContenedor($estado)
    {
        if (strpos($estado, 'Operativo') !== false) {
            return 'OP';
        } elseif (strpos($estado, 'Dañado') !== false) {
            return 'DM';
        }
        
        return 'OP';
    }
    
    /**
     * Mapea el estado
     */
    private function mapearEstado($estado)
    {
        if (strpos($estado, 'Salida') !== false) {
            return 'finalizado';
        } elseif (strpos($estado, 'Cancelado') !== false) {
            return 'cancelado';
        }
        
        return 'activo';
    }
    
    /**
     * Parsea una fecha
     */
    private function parsearFecha($fecha)
    {
        if (empty($fecha)) {
            return null;
        }
        
        try {
            return Carbon::createFromFormat('d/m/Y H:i:s', $fecha);
        } catch (\Exception $e) {
            try {
                return Carbon::createFromFormat('d/m/Y', $fecha);
            } catch (\Exception $e) {
                try {
                    return Carbon::parse($fecha);
                } catch (\Exception $e) {
                    return null;
                }
            }
        }
    }
    
    /**
     * Parsea un número
     */
    private function parsearNumero($numero)
    {
        if (empty($numero)) {
            return 0;
        }
        
        return is_numeric($numero) ? $numero : 0;
    }

    /**
     * Guarda el historial de importación del Excel para un TATC
     */
    private function guardarHistorialImportacion($tatc, $filas, $nombreArchivo)
    {
        // Limpiar historial anterior del TATC
        $tatc->historialImportacion()->delete();
        
        foreach ($filas as $fila) {
            try {
                $tatc->historialImportacion()->create([
                    'archivo_origen' => $nombreArchivo,
                    'operador' => $fila[0] ?? null,
                    'tipo_ingreso' => $fila[1] ?? null,
                    'fecha_ingreso_pais' => $this->parsearFecha($fila[2]),
                    'fecha_ingreso_deposito' => $this->parsearFecha($fila[3]),
                    'numero_contenedor' => $fila[4] ?? null,
                    'aduana' => $fila[5] ?? null,
                    'numero_tatc' => $fila[6] ?? null,
                    'eir' => $fila[7] ?? null,
                    'tatc_origen' => $fila[8] ?? null,
                    'tatc_destino' => $fila[9] ?? null,
                    'tipo_contenedor' => $fila[10] ?? null,
                    'tamano_contenedor' => $fila[11] ?? null,
                    'documento_ingreso' => $fila[12] ?? null,
                    'puerto_ingreso' => $fila[13] ?? null,
                    'tatc_emisor' => $fila[14] ?? null,
                    'tatc_ingreso' => $fila[15] ?? null,
                    'fecha_traspaso' => $this->parsearFecha($fila[16]),
                    'tara_contenedor' => $this->parsearNumero($fila[17]),
                    'anio_fabricacion' => $this->parsearNumero($fila[18]),
                    'estado_contenedor' => $fila[19] ?? null,
                    'tipo_bulto' => $fila[20] ?? null,
                    'valor_cif' => $this->parsearNumero($fila[21]),
                    'comentario' => $fila[22] ?? null,
                    'fecha_registro' => $this->parsearFecha($fila[23]),
                    'usuario_registro' => $fila[24] ?? null,
                    'estado' => $fila[25] ?? null,
                ]);
            } catch (\Exception $e) {
                $this->warn("⚠️  Error guardando historial de importación: " . $e->getMessage());
            }
        }
        
        $this->info("📚 Historial de importación guardado para TATC {$tatc->numero_tatc}");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;
use App\Models\AduanaChile;
use App\Models\LugarDeposito;
use Carbon\Carbon;

class ControlFiscalizacionController extends Controller
{
    /**
     * Mostrar el formulario de Informe de Movimientos
     */
    public function informeMovimientos(Request $request)
    {
        // Obtener datos para los filtros
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();
        $lugaresDeposito = LugarDeposito::where('estado', 'Activo')->orderBy('nombre_deposito')->get();

        // Procesar filtros si se envió el formulario
        $resultados = null;
        if ($request->isMethod('post')) {
            $resultados = $this->procesarFiltrosMovimientos($request);
        }

        return view('control-fiscalizacion.informe-movimientos', compact('aduanas', 'lugaresDeposito', 'resultados'));
    }

    /**
     * Mostrar el formulario de Búsqueda y Extracción
     */
    public function busquedaExtraccion(Request $request)
    {
        // Obtener datos para los filtros
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();
        $lugaresDeposito = LugarDeposito::where('estado', 'Activo')->orderBy('nombre_deposito')->get();

        // Procesar filtros si se envió el formulario
        $resultados = null;
        if ($request->isMethod('post')) {
            $resultados = $this->procesarFiltrosBusqueda($request);
        }

        return view('control-fiscalizacion.busqueda-extraccion', compact('aduanas', 'lugaresDeposito', 'resultados'));
    }

    /**
     * Procesar filtros para Informe de Movimientos
     */
    private function procesarFiltrosMovimientos(Request $request)
    {
        $query = collect();

        // Obtener TATCs
        $tatcs = Tatc::with(['user', 'aduana', 'empresaTransportista'])
            ->when($request->tipo && $request->tipo !== '*', function($q) use ($request) {
                // Si se selecciona TSTC (2), no mostrar TATCs
                if ($request->tipo == '2') {
                    return $q->whereRaw('1 = 0'); // No mostrar TATCs si se selecciona TSTC
                }
                return $q->where('tipo_ingreso', $request->tipo);
            })
            ->when($request->aduana_id && $request->aduana_id !== '*', function($q) use ($request) {
                return $q->where('aduana_ingreso', $request->aduana_id);
            })
            ->when($request->filtro == '0', function($q) use ($request) {
                // Filtro por fecha de ingreso
                if ($request->fecdes && $request->fechas) {
                    $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->fecdes)->startOfDay();
                    $fechaFin = Carbon::createFromFormat('d/m/Y', $request->fechas)->endOfDay();
                    return $q->whereBetween('ingreso_pais', [$fechaInicio, $fechaFin]);
                }
                return $q;
            })
            ->get()
            ->map(function($tatc) {
                return [
                    'numero_contenedor' => $tatc->numero_contenedor,
                    'fecha_ingreso' => $tatc->ingreso_pais ? $tatc->ingreso_pais->format('d/m/Y') : '-',
                    'aduana_ingreso' => $tatc->aduana_ingreso,
                    'aduana_salida' => '-',
                    'tipo_salida' => '-',
                    'fecha_salida' => '-',
                    'di_aduana_oper' => '-',
                    'tipo' => 'TATC',
                    'numero_tatc' => $tatc->numero_tatc,
                    'tipo_contenedor' => $tatc->tipo_contenedor,
                    'tamano_contenedor' => $tatc->tamano_contenedor,
                    'lugar_deposito' => $tatc->ubicacion_fisica,
                    'id' => $tatc->id,
                    'modelo' => 'Tatc'
                ];
            });

        // Obtener TSTCs
        $tstcs = Tstc::with(['user', 'aduana', 'empresaTransportista'])
            ->when($request->tipo && $request->tipo !== '*', function($q) use ($request) {
                // TSTC no tiene tipo_ingreso, filtrar por tipo de contenedor o usar otro criterio
                // Por ahora, si se selecciona TATC (1), no mostrar TSTCs
                // Si se selecciona TSTC (2), mostrar todos los TSTCs
                if ($request->tipo == '1') {
                    return $q->whereRaw('1 = 0'); // No mostrar TSTCs si se selecciona TATC
                }
                return $q; // Mostrar todos los TSTCs si se selecciona TSTC
            })
            ->when($request->aduana_id && $request->aduana_id !== '*', function($q) use ($request) {
                return $q->where('aduana_salida', $request->aduana_id);
            })
            ->when($request->filtro == '0', function($q) use ($request) {
                // Filtro por fecha de ingreso
                if ($request->fecdes && $request->fechas) {
                    $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->fecdes)->startOfDay();
                    $fechaFin = Carbon::createFromFormat('d/m/Y', $request->fechas)->endOfDay();
                    return $q->whereBetween('fecha_emision_tstc', [$fechaInicio, $fechaFin]);
                }
                return $q;
            })
            ->get()
            ->map(function($tstc) {
                return [
                    'numero_contenedor' => $tstc->numero_contenedor,
                    'fecha_ingreso' => $tstc->fecha_emision_tstc ? $tstc->fecha_emision_tstc->format('d/m/Y') : '-',
                    'aduana_ingreso' => '-',
                    'aduana_salida' => $tstc->aduana_salida,
                    'tipo_salida' => '-',
                    'fecha_salida' => '-',
                    'di_aduana_oper' => '-',
                    'tipo' => 'TSTC',
                    'numero_tatc' => $tstc->numero_tstc,
                    'tipo_contenedor' => $tstc->tipo_contenedor,
                    'tamano_contenedor' => $tstc->tamano_contenedor,
                    'lugar_deposito' => $tstc->destino_contenedor,
                    'id' => $tstc->id,
                    'modelo' => 'Tstc'
                ];
            });

        // Obtener Salidas
        $salidas = Salida::with(['tatc', 'user'])
            ->when($request->estado && $request->estado !== '*', function($q) use ($request) {
                $tiposSalida = [
                    '0' => 'Ingresados', // No aplica para salidas
                    '1' => 'Declaración de Internación',
                    '2' => 'Cancelación',
                    '3' => 'Traspaso'
                ];
                if (isset($tiposSalida[$request->estado]) && $request->estado !== '0') {
                    return $q->where('tipo_salida', $tiposSalida[$request->estado]);
                }
                return $q;
            })
            ->when($request->filtro == '1', function($q) use ($request) {
                // Filtro por fecha de salida
                if ($request->fecdes && $request->fechas) {
                    $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->fecdes)->startOfDay();
                    $fechaFin = Carbon::createFromFormat('d/m/Y', $request->fechas)->endOfDay();
                    return $q->whereBetween('created_at', [$fechaInicio, $fechaFin]);
                }
                return $q;
            })
            ->get()
            ->map(function($salida) {
                return [
                    'numero_contenedor' => $salida->tatc->numero_contenedor ?? '-',
                    'fecha_ingreso' => $salida->tatc->ingreso_pais ? $salida->tatc->ingreso_pais->format('d/m/Y') : '-',
                    'aduana_ingreso' => $salida->tatc->aduana_ingreso ?? '-',
                    'aduana_salida' => $salida->aduana_salida ?? '-',
                    'tipo_salida' => ucfirst($salida->tipo_salida),
                    'fecha_salida' => $salida->created_at ? $salida->created_at->format('d/m/Y') : '-',
                    'di_aduana_oper' => $this->obtenerDIAduanaOper($salida),
                    'tipo' => 'TATC',
                    'numero_tatc' => $salida->tatc->numero_tatc ?? '-',
                    'tipo_contenedor' => $salida->tatc->tipo_contenedor ?? '-',
                    'tamano_contenedor' => $salida->tatc->tamano_contenedor ?? '-',
                    'lugar_deposito' => $salida->tatc->ubicacion_fisica ?? '-',
                    'id' => $salida->id,
                    'modelo' => 'Salida'
                ];
            });

        // Combinar todos los resultados
        $resultados = $tatcs->concat($tstcs)->concat($salidas);

        // Aplicar filtro de lugar de depósito si se especificó
        if ($request->lugardeposito_id && $request->lugardeposito_id !== '*') {
            $resultados = $resultados->filter(function($item) use ($request) {
                return $item['lugar_deposito'] == $request->lugardeposito_id;
            });
        }

        return $resultados;
    }

    /**
     * Procesar filtros para Búsqueda y Extracción
     */
    private function procesarFiltrosBusqueda(Request $request)
    {
        // Similar a informe de movimientos pero con filtros más específicos
        return $this->procesarFiltrosMovimientos($request);
    }

    /**
     * Obtener información de DI/Aduana/Operador para salidas
     */
    private function obtenerDIAduanaOper($salida)
    {
        $info = [];
        
        if ($salida->tipo_salida === 'Declaración de Internación' && $salida->declaracion_internacion) {
            $info[] = 'DI: ' . $salida->declaracion_internacion;
        }
        
        if ($salida->aduana_salida) {
            $info[] = 'Aduana: ' . $salida->aduana_salida;
        }
        
        if ($salida->tatc && $salida->tatc->user) {
            $info[] = 'Oper: ' . $salida->tatc->user->name;
        }
        
        return implode(' / ', $info) ?: '-';
    }

    /**
     * Exportar resultados a Excel
     */
    public function exportar(Request $request)
    {
        $resultados = $this->procesarFiltrosMovimientos($request);
        
        $filename = 'informe_movimientos_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($resultados) {
            $file = fopen('php://output', 'w');
            
            // Agregar BOM para UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Encabezados
            fputcsv($file, [
                'Nro Contenedor',
                'Fecha Ingreso',
                'Aduana Ingreso',
                'Aduana Salida',
                'Tipo Salida',
                'Fecha Salida',
                'DI / Aduana / Oper.',
                'Tipo',
                'TATC / TSTC',
                'Tipo Contenedor',
                'Tamaño',
                'Lugar de Depósito'
            ]);
            
            // Datos
            foreach ($resultados as $resultado) {
                fputcsv($file, [
                    $resultado['numero_contenedor'],
                    $resultado['fecha_ingreso'],
                    $resultado['aduana_ingreso'],
                    $resultado['aduana_salida'],
                    $resultado['tipo_salida'],
                    $resultado['fecha_salida'],
                    $resultado['di_aduana_oper'],
                    $resultado['tipo'],
                    $resultado['numero_tatc'],
                    $resultado['tipo_contenedor'],
                    $resultado['tamano_contenedor'],
                    $resultado['lugar_deposito']
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Imprimir resultados en PDF
     */
    public function imprimir(Request $request)
    {
        $resultados = $this->procesarFiltrosMovimientos($request);
        
        // Obtener parámetros de filtro para mostrar en el PDF
        $filtros = [
            'tipo' => $request->tipo,
            'estado' => $request->estado,
            'filtro' => $request->filtro,
            'fecha_desde' => $request->fecdes,
            'fecha_hasta' => $request->fechas,
            'aduana_ingreso' => $request->aduana_id,
            'aduana_salida' => $request->salida_cancelacion_aduana_id,
            'lugar_deposito' => $request->lugardeposito_id
        ];
        
        $pdf = \PDF::loadView('control-fiscalizacion.pdf.informe-movimientos', [
            'resultados' => $resultados,
            'filtros' => $filtros,
            'fecha_generacion' => now()->format('d/m/Y H:i:s')
        ]);
        
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('informe_movimientos_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;
use App\Models\Prorroga;
use App\Models\AduanaChile;
use App\Models\Operador;

class ControlPlazosController extends Controller
{
    /**
     * Plazos de Vigencia - Lista de TATC/TSTC vigentes
     */
    public function plazosVigencia()
    {
        // Solo TATCs que NO tienen salidas registradas (realmente vigentes)
        $tatcsVigentes = Tatc::with(['user.operador', 'aduana'])
            ->whereDoesntHave('salidas', function($query) {
                $query->where('estado', '!=', 'Cancelado');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Solo TSTCs que NO tienen salidas registradas (realmente vigentes)
        // Nota: Las salidas solo están relacionadas con TATCs, no con TSTCs
        $tstcsVigentes = Tstc::with(['user.operador', 'aduana'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('control-plazos.plazos-vigencia', compact('tatcsVigentes', 'tstcsVigentes'))
            ->with('titlePage', 'Plazos de Vigencia');
    }

    /**
     * Registro de Cancelación - Lista de TATC/TSTC cancelados
     */
    public function registroCancelacion()
    {
        $cancelaciones = Salida::with(['tatc.user.operador', 'tatc.aduana'])
            ->where('tipo_salida', 'Cancelación')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('control-plazos.registro-cancelacion', compact('cancelaciones'))
            ->with('titlePage', 'Registro de Cancelación');
    }

    /**
     * Registro de Prórrogas - Lista de TATC/TSTC con prórrogas
     */
    public function registroProrrogas()
    {
        // Mostrar prórrogas de la tabla prorrogas
        $prorrogas = Prorroga::with(['tatc.user.operador', 'tatc.aduana', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('control-plazos.registro-prorrogas', compact('prorrogas'))
            ->with('titlePage', 'Registro de Prórrogas');
    }

    /**
     * Registro de Traspaso - Lista de TATC/TSTC con traspasos
     */
    public function registroTraspaso()
    {
        $traspasos = Salida::with(['tatc.user.operador', 'tatc.aduana'])
            ->where('tipo_salida', 'Traspaso')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('control-plazos.registro-traspaso', compact('traspasos'))
            ->with('titlePage', 'Registro de Traspaso');
    }

    /**
     * Mostrar detalle de un registro específico
     */
    public function show($tipo, $id)
    {
        if ($tipo === 'tatc') {
            $registro = Tatc::with(['user.operador', 'aduana', 'historialImportacion', 'salidas'])->findOrFail($id);
        } elseif ($tipo === 'tstc') {
            $registro = Tstc::with(['user.operador', 'aduana', 'historial', 'salidas'])->findOrFail($id);
        } else {
            abort(404);
        }

        return view('control-plazos.show', compact('registro', 'tipo'))
            ->with('titlePage', 'Detalle de ' . strtoupper($tipo) . ' #' . $registro->numero_tatc ?? $registro->numero_tstc);
    }

    /**
     * Buscar registros
     */
    public function buscar(Request $request)
    {
        $query = $request->get('q');
        $tipo = $request->get('tipo', 'tatc');

        if ($tipo === 'tatc') {
            $resultados = Tatc::with(['user.operador', 'aduana'])
                ->where('numero_tatc', 'like', "%{$query}%")
                ->orWhere('numero_contenedor', 'like', "%{$query}%")
                ->orWhereHas('user.operador', function($q) use ($query) {
                    $q->where('nombre_operador', 'like', "%{$query}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $resultados = Tstc::with(['user.operador', 'aduana'])
                ->where('numero_tstc', 'like', "%{$query}%")
                ->orWhere('numero_contenedor', 'like', "%{$query}%")
                ->orWhereHas('user.operador', function($q) use ($query) {
                    $q->where('nombre_operador', 'like', "%{$query}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('control-plazos.buscar', compact('resultados', 'query', 'tipo'))
            ->with('titlePage', 'Búsqueda de ' . strtoupper($tipo));
    }

    /**
     * Exportar registros a Excel
     */
    public function exportar(Request $request)
    {
        $tipo = $request->get('tipo', 'tatc');
        $fecha = now()->format('Y-m-d_H-i-s');
        
        if ($tipo === 'tatc') {
            $registros = Tatc::with(['user.operador', 'aduana'])->get();
            $filename = "TATCs_Export_{$fecha}.csv";
            $headers = [
                'Número TATC',
                'Contenedor',
                'Operador',
                'Fecha Ingreso',
                'Aduana',
                'Estado',
                'Vigencia'
            ];
        } else {
            $registros = Tstc::with(['user.operador', 'aduana'])->get();
            $filename = "TSTCs_Export_{$fecha}.csv";
            $headers = [
                'Número TSTC',
                'Contenedor',
                'Operador',
                'Fecha Ingreso',
                'Aduana',
                'Estado',
                'Vigencia'
            ];
        }

        // Crear contenido CSV
        $csvContent = $this->generarContenidoCSV($registros, $tipo, $headers);
        
        // Configurar headers para descarga
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ];

        return response($csvContent, 200, $headers);
    }

    /**
     * Generar contenido CSV para exportación
     */
    private function generarContenidoCSV($registros, $tipo, $headers)
    {
        $output = fopen('php://temp', 'r+');
        
        // Agregar BOM para UTF-8 (para que Excel abra correctamente los caracteres especiales)
        fwrite($output, "\xEF\xBB\xBF");
        
        // Escribir headers
        fputcsv($output, $headers, ';');
        
        // Escribir datos
        foreach ($registros as $registro) {
            $fechaVencimiento = $registro->created_at->addYear();
            $diasRestantes = floor(now()->diffInDays($fechaVencimiento, false));
            $vigencia = $diasRestantes < 0 ? 'Vencido' : ($diasRestantes <= 30 ? 'Por vencer' : 'Vigente');
            
            $row = [
                $tipo === 'tatc' ? $registro->numero_tatc : $registro->numero_tstc,
                $registro->numero_contenedor ?? 'N/A',
                $registro->user->operador->nombre_operador ?? 'N/A',
                $registro->created_at->format('d/m/Y H:i'),
                $registro->aduana->nombre_aduana ?? 'N/A',
                $registro->estado ?? 'N/A',
                $vigencia . ' (' . $fechaVencimiento->format('d/m/Y') . ')'
            ];
            
            fputcsv($output, $row, ';');
        }
        
        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);
        
        return $csvContent;
    }

    /**
     * Solicitar prórroga de vigencia
     */
    public function solicitarProrroga(Request $request)
    {
        $request->validate([
            'tatc_id' => 'required|exists:tatcs,id',
            'fecha_solicitud' => 'required|date',
            'motivo' => 'required|string|min:10|max:500'
        ]);

        try {
            // Crear la prórroga
            $prorroga = new Prorroga();
            $prorroga->tatc_id = $request->tatc_id;
            $prorroga->numero_prorroga = Prorroga::generarNumeroProrroga();
            $prorroga->fecha_solicitud = $request->fecha_solicitud;
            $prorroga->motivo = $request->motivo;
            $prorroga->estado = 'Pendiente';
            $prorroga->user_id = auth()->id();
            $prorroga->save();

            // Aquí se podría integrar con HERMES para enviar la solicitud
            // Por ahora, simulamos el envío exitoso
            Log::info('Solicitud de prórroga creada', [
                'prorroga_id' => $prorroga->id,
                'tatc_id' => $request->tatc_id,
                'usuario' => auth()->user()->email
            ]);

            return redirect()->route('control-plazos.plazos-vigencia')
                ->with('success', 'Solicitud de prórroga enviada exitosamente a HERMES. Número de solicitud: ' . $prorroga->numero_prorroga);

        } catch (\Exception $e) {
            Log::error('Error al crear solicitud de prórroga', [
                'error' => $e->getMessage(),
                'tatc_id' => $request->tatc_id,
                'usuario' => auth()->user()->email
            ]);

            return redirect()->back()
                ->with('error', 'Error al procesar la solicitud de prórroga. Por favor, intente nuevamente.')
                ->withInput();
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\HermesLog;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;
use App\Services\Hermes\HermesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HermesMonitorController extends Controller
{
    protected $hermesService;

    public function __construct(HermesService $hermesService)
    {
        $this->hermesService = $hermesService;
    }

    /**
     * Mostrar el dashboard de monitoreo de HERMES
     */
    public function index()
    {
        // Estadísticas generales
        $estadisticas = [
            'total_mensajes' => HermesLog::count(),
            'mensajes_exitosos' => HermesLog::where('estado', 'EXITOSO')->count(),
            'mensajes_error' => HermesLog::where('estado', 'ERROR')->count(),
            'mensajes_pendientes' => HermesLog::where('estado', 'ENVIADO')->count(),
        ];

        // Tasa de éxito
        $estadisticas['tasa_exito'] = $estadisticas['total_mensajes'] > 0 
            ? round(($estadisticas['mensajes_exitosos'] / $estadisticas['total_mensajes']) * 100, 2) 
            : 0;

        // Estadísticas por tipo de operación
        $estadisticasPorTipo = HermesLog::selectRaw('tipo_operacion, COUNT(*) as total, 
            SUM(CASE WHEN estado = "EXITOSO" THEN 1 ELSE 0 END) as exitosos,
            SUM(CASE WHEN estado = "ERROR" THEN 1 ELSE 0 END) as errores')
            ->groupBy('tipo_operacion')
            ->get();

        // Estadísticas por estado
        $estadisticasPorEstado = HermesLog::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get();

        // Últimos mensajes
        $ultimosMensajes = HermesLog::with(['tatc', 'tstc', 'salida'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Mensajes con error recientes
        $mensajesError = HermesLog::where('estado', 'ERROR')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('hermes.monitor', compact(
            'estadisticas',
            'estadisticasPorTipo',
            'estadisticasPorEstado',
            'ultimosMensajes',
            'mensajesError'
        ));
    }

    /**
     * Mostrar el historial completo de comunicaciones
     */
    public function historial(Request $request)
    {
        $query = HermesLog::with(['tatc', 'tstc', 'salida']);

        // Filtros
        if ($request->filled('tipo_operacion')) {
            $query->where('tipo_operacion', $request->tipo_operacion);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->filled('numero_documento')) {
            $query->where('numero_documento', 'like', '%' . $request->numero_documento . '%');
        }

        // Ordenamiento
        $query->orderBy('created_at', 'desc');

        // Paginación
        $logs = $query->paginate(20);

        // Opciones para filtros
        $tiposOperacion = HermesLog::distinct()->pluck('tipo_operacion');
        $estados = HermesLog::distinct()->pluck('estado');

        return view('hermes.historial', compact('logs', 'tiposOperacion', 'estados'));
    }

    /**
     * Mostrar detalles de un mensaje específico
     */
    public function show($id)
    {
        $log = HermesLog::with(['tatc', 'tstc', 'salida'])->findOrFail($id);

        return view('hermes.show', compact('log'));
    }

    /**
     * Reintentar mensajes fallidos
     */
    public function reintentar(Request $request)
    {
        try {
            $maxIntentos = $request->get('max_intentos', 3);
            $this->hermesService->reintentarMensajesFallidos($maxIntentos);

            return redirect()->back()->with('success', 'Proceso de reintento iniciado correctamente');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al reintentar mensajes: ' . $e->getMessage());
        }
    }

    /**
     * Enviar TATC específico a HERMES
     */
    public function enviarTatc(Request $request)
    {
        $request->validate([
            'tatc_id' => 'required|exists:tatcs,id'
        ]);

        try {
            $tatc = Tatc::findOrFail($request->tatc_id);
            $resultado = $this->hermesService->enviarTatc($tatc);

            if ($resultado['success']) {
                return redirect()->back()->with('success', 'TATC enviado exitosamente a HERMES');
            } else {
                return redirect()->back()->with('error', 'Error al enviar TATC: ' . ($resultado['error'] ?? 'Error desconocido'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar TATC: ' . $e->getMessage());
        }
    }

    /**
     * Enviar TSTC específico a HERMES
     */
    public function enviarTstc(Request $request)
    {
        $request->validate([
            'tstc_id' => 'required|exists:tstcs,id'
        ]);

        try {
            $tstc = Tstc::findOrFail($request->tstc_id);
            $resultado = $this->hermesService->enviarTstc($tstc);

            if ($resultado['success']) {
                return redirect()->back()->with('success', 'TSTC enviado exitosamente a HERMES');
            } else {
                return redirect()->back()->with('error', 'Error al enviar TSTC: ' . ($resultado['error'] ?? 'Error desconocido'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar TSTC: ' . $e->getMessage());
        }
    }

    /**
     * Enviar Salida específica a HERMES
     */
    public function enviarSalida(Request $request)
    {
        $request->validate([
            'salida_id' => 'required|exists:salidas,id'
        ]);

        try {
            $salida = Salida::findOrFail($request->salida_id);
            $resultado = $this->hermesService->enviarSalida($salida);

            if ($resultado['success']) {
                return redirect()->back()->with('success', 'Salida enviada exitosamente a HERMES');
            } else {
                return redirect()->back()->with('error', 'Error al enviar Salida: ' . ($resultado['error'] ?? 'Error desconocido'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar Salida: ' . $e->getMessage());
        }
    }

    /**
     * Obtener estadísticas en tiempo real (AJAX)
     */
    public function estadisticas()
    {
        $estadisticas = [
            'total_mensajes' => HermesLog::count(),
            'mensajes_exitosos' => HermesLog::where('estado', 'EXITOSO')->count(),
            'mensajes_error' => HermesLog::where('estado', 'ERROR')->count(),
            'mensajes_pendientes' => HermesLog::where('estado', 'ENVIADO')->count(),
        ];

        $estadisticas['tasa_exito'] = $estadisticas['total_mensajes'] > 0 
            ? round(($estadisticas['mensajes_exitosos'] / $estadisticas['total_mensajes']) * 100, 2) 
            : 0;

        return response()->json($estadisticas);
    }
}

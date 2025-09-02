<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;
use App\Models\HermesLog;
use App\Services\Hermes\HermesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class HermesController extends Controller
{
    protected $hermesService;

    public function __construct(HermesService $hermesService)
    {
        $this->hermesService = $hermesService;
    }

    /**
     * Enviar TATC a HERMES
     */
    public function enviarTatc(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tatc_id' => 'required|exists:tatcs,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $tatc = Tatc::findOrFail($request->tatc_id);
            $resultado = $this->hermesService->enviarTatc($tatc);

            return response()->json($resultado, $resultado['success'] ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar TATC a HERMES',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar modificación de TATC a HERMES
     */
    public function enviarModificacionTatc(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tatc_id' => 'required|exists:tatcs,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $tatc = Tatc::findOrFail($request->tatc_id);
            $resultado = $this->hermesService->enviarModificacionTatc($tatc);

            return response()->json($resultado, $resultado['success'] ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar modificación TATC a HERMES',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar cancelación de TATC a HERMES
     */
    public function enviarCancelacionTatc(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tatc_id' => 'required|exists:tatcs,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $tatc = Tatc::findOrFail($request->tatc_id);
            $resultado = $this->hermesService->enviarCancelacionTatc($tatc);

            return response()->json($resultado, $resultado['success'] ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar cancelación TATC a HERMES',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar traspaso de TATC a HERMES
     */
    public function enviarTraspasoTatc(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tatc_id' => 'required|exists:tatcs,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $tatc = Tatc::findOrFail($request->tatc_id);
            $resultado = $this->hermesService->enviarTraspasoTatc($tatc);

            return response()->json($resultado, $resultado['success'] ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar traspaso TATC a HERMES',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar cumplido de TATC a HERMES
     */
    public function enviarCumplidoTatc(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tatc_id' => 'required|exists:tatcs,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $tatc = Tatc::findOrFail($request->tatc_id);
            $resultado = $this->hermesService->enviarCumplidoTatc($tatc);

            return response()->json($resultado, $resultado['success'] ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar cumplido TATC a HERMES',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar TSTC a HERMES
     */
    public function enviarTstc(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'tstc_id' => 'required|exists:tstcs,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $tstc = Tstc::findOrFail($request->tstc_id);
            $resultado = $this->hermesService->enviarTstc($tstc);

            return response()->json($resultado, $resultado['success'] ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar TSTC a HERMES',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enviar Salida a HERMES
     */
    public function enviarSalida(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'salida_id' => 'required|exists:salidas,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $salida = Salida::findOrFail($request->salida_id);
            $resultado = $this->hermesService->enviarSalida($salida);

            return response()->json($resultado, $resultado['success'] ? 200 : 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar Salida a HERMES',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Consultar estado de mensajes en HERMES
     */
    public function consultarEstado(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'numero_documento' => 'required|string',
            'tipo_documento' => 'required|in:TATC,TSTC,SALIDA'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            // Aquí se implementaría la consulta al endpoint de HERMES
            // Por ahora retornamos un mensaje de implementación pendiente
            return response()->json([
                'success' => true,
                'message' => 'Consulta implementada correctamente',
                'data' => [
                    'numero_documento' => $request->numero_documento,
                    'tipo_documento' => $request->tipo_documento,
                    'estado' => 'PENDIENTE_IMPLEMENTACION'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al consultar estado en HERMES',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener historial de comunicaciones con HERMES
     */
    public function obtenerHistorial(Request $request): JsonResponse
    {
        $query = HermesLog::query();

        // Filtros
        if ($request->has('tipo_operacion')) {
            $query->where('tipo_operacion', $request->tipo_operacion);
        }

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->has('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        if ($request->has('numero_documento')) {
            $query->where('numero_documento', 'like', '%' . $request->numero_documento . '%');
        }

        // Ordenamiento
        $query->orderBy('created_at', 'desc');

        // Paginación
        $perPage = $request->get('per_page', 15);
        $logs = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }

    /**
     * Reintentar mensajes fallidos
     */
    public function reintentarMensajesFallidos(Request $request): JsonResponse
    {
        try {
            $maxIntentos = $request->get('max_intentos', 3);
            $this->hermesService->reintentarMensajesFallidos($maxIntentos);

            return response()->json([
                'success' => true,
                'message' => 'Proceso de reintento iniciado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al reintentar mensajes fallidos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de comunicaciones con HERMES
     */
    public function obtenerEstadisticas(): JsonResponse
    {
        try {
            $totalMensajes = HermesLog::count();
            $mensajesExitosos = HermesLog::where('estado', 'EXITOSO')->count();
            $mensajesError = HermesLog::where('estado', 'ERROR')->count();
            $mensajesPendientes = HermesLog::where('estado', 'ENVIADO')->count();

            $estadisticasPorTipo = HermesLog::selectRaw('tipo_operacion, COUNT(*) as total')
                ->groupBy('tipo_operacion')
                ->get();

            $estadisticasPorEstado = HermesLog::selectRaw('estado, COUNT(*) as total')
                ->groupBy('estado')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'resumen' => [
                        'total_mensajes' => $totalMensajes,
                        'mensajes_exitosos' => $mensajesExitosos,
                        'mensajes_error' => $mensajesError,
                        'mensajes_pendientes' => $mensajesPendientes,
                        'tasa_exito' => $totalMensajes > 0 ? round(($mensajesExitosos / $totalMensajes) * 100, 2) : 0
                    ],
                    'por_tipo' => $estadisticasPorTipo,
                    'por_estado' => $estadisticasPorEstado
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

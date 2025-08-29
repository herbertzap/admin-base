<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Salida;
use App\Models\Tatc;
use App\Models\EmpresaTransportista;
use App\Models\AduanaChile;
use App\Models\Operador;

class SalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salidas = Salida::with(['tatc', 'user', 'empresaTransportista'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('salidas.index', compact('salidas'))
            ->with('titlePage', 'Salidas y Cancelaciones');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener TATCs vigentes (sin salidas registradas)
        $tatcsVigentes = Tatc::whereDoesntHave('salidas')
            ->orWhereHas('salidas', function($query) {
                $query->where('estado', 'Cancelado');
            })
            ->with('user.operador')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $empresasTransportistas = EmpresaTransportista::where('estado', 'Activo')
            ->orderBy('nombre_empresa')
            ->get();

        $aduanas = AduanaChile::where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        return view('salidas.create', compact('tatcsVigentes', 'empresasTransportistas', 'aduanas'))
            ->with('titlePage', 'Registrar Salida');
    }

    /**
     * Show the form for registering a specific TATC salida.
     */
    public function registrarSalida(Tatc $tatc)
    {
        // Verificar que el TATC no tenga salidas vigentes
        $salidaVigente = $tatc->salidas()->where('estado', '!=', 'Cancelado')->first();
        if ($salidaVigente) {
            return redirect()->route('salidas.create')
                ->with('error', 'Este TATC ya tiene una salida registrada.');
        }

        $empresasTransportistas = EmpresaTransportista::where('estado', 'Activo')
            ->orderBy('nombre_empresa')
            ->get();

        $aduanas = AduanaChile::where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        return view('salidas.registrar', compact('tatc', 'empresasTransportistas', 'aduanas'))
            ->with('titlePage', 'Registrar Salida - TATC ' . $tatc->numero_tatc);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log para debugging
        Log::info('Salida store request', [
            'user_id' => Auth::id(),
            'data' => $request->all()
        ]);

        // Validaciones base
        $validator = Validator::make($request->all(), [
            'tatc_id' => 'required|exists:tatcs,id',
            'tipo_salida' => 'required|in:internacion,cancelacion,traspaso',
        ]);

        if ($validator->fails()) {
            Log::error('Salida validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validaciones específicas según tipo de salida
        $tipoSalida = $request->tipo_salida;
        
        if ($tipoSalida === 'internacion') {
            $validator = Validator::make($request->all(), [
                'tatc_id' => 'required|exists:tatcs,id',
                'tipo_salida' => 'required|in:internacion,cancelacion,traspaso',
                'declaracion_internacion' => 'required|string|max:50',
                'fecha_internacion' => 'required|string',
                'comentario_internacion' => 'nullable|string|max:200',
            ]);
        } elseif ($tipoSalida === 'cancelacion') {
            $validator = Validator::make($request->all(), [
                'tatc_id' => 'required|exists:tatcs,id',
                'tipo_salida' => 'required|in:internacion,cancelacion,traspaso',
                'fecha_cancelacion' => 'required|string',
                'aduana_ingreso_cancelacion' => 'required|string|max:10',
                'documento_cancelacion' => 'required|string|max:500',
            ]);
        } elseif ($tipoSalida === 'traspaso') {
            $validator = Validator::make($request->all(), [
                'tatc_id' => 'required|exists:tatcs,id',
                'tipo_salida' => 'required|in:internacion,cancelacion,traspaso',
                'tatc_destino' => 'required|string|max:50',
                'fecha_traspaso' => 'required|string',
                'operador_destino' => 'required|string|max:50',
                'lugar_deposito_origen' => 'nullable|string|max:200',
                'lugar_deposito_destino' => 'nullable|string|max:200',
                'valor_contenedor_traspaso' => 'nullable|numeric',
                'tipo_bulto_traspaso' => 'nullable|string|max:10',
            ]);
        }

        if ($validator->fails()) {
            Log::error('Salida validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Obtener el TATC
            $tatc = Tatc::findOrFail($request->tatc_id);

            // Generar número de salida automáticamente
            $numeroSalida = Salida::generarNumeroSalida($tatc, $tipoSalida);

            // Preparar datos según tipo de salida
            $datosSalida = [
                'tatc_id' => $tatc->id,
                'numero_salida' => $numeroSalida,
                'tipo_salida' => $tipoSalida,
                'estado' => 'Pendiente',
                'user_id' => Auth::id(),
            ];

            // Agregar campos específicos según tipo
            if ($tipoSalida === 'internacion') {
                $datosSalida['fecha_salida'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_internacion)->format('Y-m-d');
                $datosSalida['declaracion_internacion'] = $request->declaracion_internacion;
                $datosSalida['comentario_internacion'] = $request->comentario_internacion;
            } elseif ($tipoSalida === 'cancelacion') {
                $datosSalida['fecha_salida'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_cancelacion)->format('Y-m-d');
                $datosSalida['aduana_ingreso_cancelacion'] = $request->aduana_ingreso_cancelacion;
                $datosSalida['documento_cancelacion'] = $request->documento_cancelacion;
            } elseif ($tipoSalida === 'traspaso') {
                $datosSalida['fecha_salida'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_traspaso)->format('Y-m-d');
                $datosSalida['tatc_destino'] = $request->tatc_destino;
                $datosSalida['operador_destino'] = $request->operador_destino;
                $datosSalida['lugar_deposito_origen'] = $request->lugar_deposito_origen;
                $datosSalida['lugar_deposito_destino'] = $request->lugar_deposito_destino;
                $datosSalida['valor_contenedor_traspaso'] = $request->valor_contenedor_traspaso;
                $datosSalida['tipo_bulto_traspaso'] = $request->tipo_bulto_traspaso;
            }

            // Crear la salida
            $salida = Salida::create($datosSalida);

            Log::info('Salida created successfully', [
                'salida_id' => $salida->id,
                'numero_salida' => $salida->numero_salida,
                'tipo_salida' => $tipoSalida
            ]);

            return redirect()->route('salidas.index')
                ->with('success', 'Salida registrada exitosamente. Número: ' . $salida->numero_salida);

        } catch (\Exception $e) {
            Log::error('Error creating Salida', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Error al registrar la salida: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Salida $salida)
    {
        $salida->load(['tatc.user.operador', 'empresaTransportista']);
        return view('salidas.show', compact('salida'))
            ->with('titlePage', 'Detalle de Salida');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salida $salida)
    {
        $empresasTransportistas = EmpresaTransportista::where('estado', 'Activo')
            ->orderBy('nombre_empresa')
            ->get();

        $aduanas = AduanaChile::where('estado', 'Activo')
            ->orderBy('codigo')
            ->get();

        return view('salidas.edit', compact('salida', 'empresasTransportistas', 'aduanas'))
            ->with('titlePage', 'Editar Salida');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salida $salida)
    {
        // Log para debugging
        Log::info('Salida update request', [
            'salida_id' => $salida->id,
            'user_id' => Auth::id(),
            'data' => $request->all()
        ]);

        // Convertir fechas de formato dd/mm/yyyy a yyyy-mm-dd
        $data = $request->all();
        if ($request->filled('fecha_salida')) {
            $data['fecha_salida'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_salida)->format('Y-m-d');
        }

        // Validaciones
        $validator = Validator::make($data, [
            'fecha_salida' => 'required|date',
            'tipo_salida' => 'required|string|max:50',
            'motivo_salida' => 'nullable|string|max:200',
            'numero_contenedor' => 'required|string|max:20',
            'tipo_contenedor' => 'required|string|max:10',
            'estado_contenedor' => 'nullable|string|max:50',
            'aduana_salida' => 'required|string|max:10',
            'documento_aduana' => 'nullable|string|max:50',
            'numero_documento' => 'nullable|string|max:50',
            'empresa_transportista_id' => 'nullable|exists:empresa_transportistas,id',
            'rut_chofer' => 'nullable|string|max:20',
            'patente_camion' => 'nullable|string|max:20',
            'destino_final' => 'nullable|string|max:200',
            'pais_destino' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:500',
            'estado' => 'required|in:Pendiente,Aprobado,Rechazado,Cancelado',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Actualizar la salida
            $salida->update([
                'fecha_salida' => $data['fecha_salida'],
                'tipo_salida' => $data['tipo_salida'],
                'motivo_salida' => $data['motivo_salida'] ?? null,
                'numero_contenedor' => $data['numero_contenedor'],
                'tipo_contenedor' => $data['tipo_contenedor'],
                'estado_contenedor' => $data['estado_contenedor'] ?? null,
                'aduana_salida' => $data['aduana_salida'],
                'documento_aduana' => $data['documento_aduana'] ?? null,
                'numero_documento' => $data['numero_documento'] ?? null,
                'empresa_transportista_id' => $data['empresa_transportista_id'] ?? null,
                'rut_chofer' => $data['rut_chofer'] ?? null,
                'patente_camion' => $data['patente_camion'] ?? null,
                'destino_final' => $data['destino_final'] ?? null,
                'pais_destino' => $data['pais_destino'] ?? null,
                'observaciones' => $data['observaciones'] ?? null,
                'estado' => $data['estado'],
            ]);

            Log::info('Salida updated successfully', [
                'salida_id' => $salida->id,
                'numero_salida' => $salida->numero_salida
            ]);

            return redirect()->route('salidas.index')
                ->with('success', 'Salida actualizada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error updating Salida', [
                'error' => $e->getMessage(),
                'salida_id' => $salida->id
            ]);

            return redirect()->back()
                ->with('error', 'Error al actualizar la salida: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salida $salida)
    {
        try {
            $salida->delete();

            Log::info('Salida deleted successfully', [
                'salida_id' => $salida->id,
                'numero_salida' => $salida->numero_salida
            ]);

            return redirect()->route('salidas.index')
                ->with('success', 'Salida eliminada exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error deleting Salida', [
                'error' => $e->getMessage(),
                'salida_id' => $salida->id
            ]);

            return redirect()->back()
                ->with('error', 'Error al eliminar la salida: ' . $e->getMessage());
        }
    }

    /**
     * Consulta general de salidas
     */
    public function consulta()
    {
        $salidas = Salida::with(['tatc.user.operador', 'empresaTransportista'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('salidas.consulta', compact('salidas'))
            ->with('titlePage', 'Consulta de Salidas');
    }

    /**
     * Exportar salidas
     */
    public function exportar()
    {
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();

        return view('salidas.exportar', compact('aduanas', 'operadores'))
            ->with('titlePage', 'Exportar Salidas');
    }

    /**
     * Procesar exportación
     */
    public function procesarExportacion(Request $request)
    {
        // Lógica de exportación
        return redirect()->route('salidas.exportar')
            ->with('info', 'Funcionalidad de exportación en desarrollo.');
    }

    /**
     * Obtener TATCs vigentes via AJAX
     */
    public function obtenerTatcsVigentes(Request $request)
    {
        try {
            $tatcs = Tatc::whereDoesntHave('salidas')
                ->orWhereHas('salidas', function($query) {
                    $query->where('estado', 'Cancelado');
                })
                ->with('user.operador')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'tatcs' => $tatcs
            ]);
        } catch (\Exception $e) {
            Log::error('Error obteniendo TATCs vigentes', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['error' => 'Error obteniendo TATCs vigentes'], 500);
        }
    }
}

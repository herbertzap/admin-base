<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Tstc;
use App\Models\Operador;
use App\Models\TipoContenedor;
use App\Models\LugarDeposito;
use App\Models\EmpresaTransportista;
use App\Models\AduanaChile;
use PDF;

class TstcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tstcs = Tstc::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('tstc.index', compact('tstcs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userOperador = Auth::user()->operador;
        $tiposContenedor = TipoContenedor::where('estado', 'Activo')->orderBy('descripcion')->get();
        $lugaresDeposito = LugarDeposito::where('estado', 'Activo')->orderBy('nombre_deposito')->get();
        $empresasTransportistas = EmpresaTransportista::where('estado', 'Activo')->orderBy('nombre_empresa')->get();
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();
        $estadosContenedor = \App\Models\Contenedor::getEstados();

        return view('tstc.create', compact('userOperador', 'tiposContenedor', 'lugaresDeposito', 'empresasTransportistas', 'aduanas', 'estadosContenedor'))
            ->with('titlePage', 'Registrar TSTC');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log para debugging
        Log::info('TSTC store request', [
            'user_id' => Auth::id(),
            'data' => $request->all()
        ]);

        // Convertir fechas de formato dd/mm/yyyy a yyyy-mm-dd
        $data = $request->all();
        if ($request->filled('fecha_emision_tstc')) {
            $data['fecha_emision_tstc'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_emision_tstc)->format('Y-m-d');
        }
        if ($request->filled('ingreso_deposito')) {
            $data['ingreso_deposito'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->ingreso_deposito)->format('Y-m-d');
        }
        if ($request->filled('fecha_salida_pais')) {
            $data['fecha_salida_pais'] = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->fecha_salida_pais)->format('Y-m-d H:i:s');
        }

        // Validaciones según el formulario de Mitac
        $validator = Validator::make($data, [
            'numero_contenedor' => 'required|string|max:20',
            'tipo_contenedor' => 'required|string|max:10',
            'destino_contenedor' => 'nullable|string|max:200',
            'valor_fob' => 'nullable|numeric|min:0',
            'tara_contenedor' => 'nullable|string|max:20',
            'comentario' => 'nullable|string|max:500',
            'ingreso_deposito' => 'required|date',
            'aduana_salida' => 'required|string|max:10',
            'fecha_salida_pais' => 'required|date',
            'tamano_contenedor' => 'required|in:20 Pies,40 Pies',
            'estado_contenedor' => 'required|in:[OP] Operativo,[DM] Dañado',
            'codigo_tipo_bulto' => 'required|string|max:10',
            'anio_fabricacion' => 'nullable|string|max:4',
            'empresa_transportista_id' => 'nullable|exists:empresa_transportistas,id',
            'rut_chofer' => 'nullable|string|max:20',
            'patente_camion' => 'nullable|string|max:20',
            'documento_transporte' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            Log::error('TSTC validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Generar número TSTC automáticamente
            $userOperador = Auth::user()->operador;
            $numeroTstc = Tstc::generarNumeroTstc($userOperador, $data['aduana_salida']);

            // Crear el TSTC
            $tstc = Tstc::create([
                'numero_tstc' => $numeroTstc,
                'operador_id' => $userOperador->id,
                'fecha_emision_tstc' => $data['fecha_emision_tstc'] ?? now()->format('Y-m-d'),
                'numero_contenedor' => $data['numero_contenedor'],
                'tipo_contenedor' => $data['tipo_contenedor'],
                'tara_contenedor' => $data['tara_contenedor'] ?? null,
                'destino_contenedor' => $data['destino_contenedor'] ?? null,
                'valor_fob' => $data['valor_fob'] ?? null,
                'comentario' => $data['comentario'] ?? null,
                'ingreso_deposito' => $data['ingreso_deposito'],
                'aduana_salida' => $data['aduana_salida'],
                'fecha_salida_pais' => $data['fecha_salida_pais'],
                'tamano_contenedor' => $data['tamano_contenedor'],
                'estado_contenedor' => $data['estado_contenedor'],
                'codigo_tipo_bulto' => $data['codigo_tipo_bulto'],
                'anio_fabricacion' => $data['anio_fabricacion'] ?? null,
                'empresa_transportista_id' => $data['empresa_transportista_id'] ?? null,
                'rut_chofer' => $data['rut_chofer'] ?? null,
                'patente_camion' => $data['patente_camion'] ?? null,
                'documento_transporte' => $data['documento_transporte'] ?? null,
                'estado' => 'activo',
                'user_id' => Auth::id(),
            ]);

            // Registrar en historial
            $this->registrarHistorial($tstc, 'crear', null, $tstc->toArray());

            Log::info('TSTC created successfully', [
                'tstc_id' => $tstc->id,
                'numero_tstc' => $tstc->numero_tstc
            ]);

            return redirect()->route('tstc.index')
                ->with('success', 'TSTC registrado exitosamente. Número: ' . $tstc->numero_tstc);

        } catch (\Exception $e) {
            Log::error('Error creating TSTC', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Error al registrar el TSTC: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tstc $tstc)
    {
        $tstc->load(['user.operador', 'empresaTransportista']);
        return view('tstc.show', compact('tstc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tstc $tstc)
    {
        $userOperador = Auth::user()->operador;
        $tiposContenedor = TipoContenedor::where('estado', 'Activo')->orderBy('descripcion')->get();
        $lugaresDeposito = LugarDeposito::where('estado', 'Activo')->orderBy('nombre_deposito')->get();
        $empresasTransportistas = EmpresaTransportista::where('estado', 'Activo')->orderBy('nombre_empresa')->get();
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();
        $estadosContenedor = \App\Models\Contenedor::getEstados();

        return view('tstc.edit', compact('tstc', 'userOperador', 'tiposContenedor', 'lugaresDeposito', 'empresasTransportistas', 'aduanas', 'estadosContenedor'))
            ->with('titlePage', 'Editar TSTC');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tstc $tstc)
    {
        // Log para debugging
        Log::info('TSTC update request', [
            'tstc_id' => $tstc->id,
            'user_id' => Auth::id(),
            'data' => $request->all()
        ]);

        // Guardar datos anteriores para el historial
        $datosAnteriores = $tstc->toArray();

        // Convertir fechas de formato dd/mm/yyyy a yyyy-mm-dd
        $data = $request->all();
        if ($request->filled('fecha_emision_tstc')) {
            $data['fecha_emision_tstc'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_emision_tstc)->format('Y-m-d');
        }
        if ($request->filled('ingreso_deposito')) {
            $data['ingreso_deposito'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->ingreso_deposito)->format('Y-m-d');
        }
        if ($request->filled('fecha_salida_pais')) {
            $data['fecha_salida_pais'] = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->fecha_salida_pais)->format('Y-m-d H:i:s');
        }

        // Validaciones
        $validator = Validator::make($data, [
            'numero_contenedor' => 'required|string|max:20',
            'tipo_contenedor' => 'required|string|max:10',
            'destino_contenedor' => 'nullable|string|max:200',
            'valor_fob' => 'nullable|numeric|min:0',
            'tara_contenedor' => 'nullable|string|max:20',
            'comentario' => 'nullable|string|max:500',
            'ingreso_deposito' => 'required|date',
            'aduana_salida' => 'required|string|max:10',
            'fecha_salida_pais' => 'required|date',
            'tamano_contenedor' => 'required|in:20 Pies,40 Pies',
            'estado_contenedor' => 'required|in:[OP] Operativo,[DM] Dañado',
            'codigo_tipo_bulto' => 'required|string|max:10',
            'anio_fabricacion' => 'nullable|string|max:4',
            'empresa_transportista_id' => 'nullable|exists:empresa_transportistas,id',
            'rut_chofer' => 'nullable|string|max:20',
            'patente_camion' => 'nullable|string|max:20',
            'documento_transporte' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Actualizar el TSTC
            $tstc->update([
                'numero_contenedor' => $data['numero_contenedor'],
                'tipo_contenedor' => $data['tipo_contenedor'],
                'tipo_salida' => $data['tipo_salida'],
                'salida_pais' => $data['salida_pais'],
                'salida_deposito' => $data['salida_deposito'],
                'tstc_origen' => $data['tstc_origen'] ?? null,
                'tstc_destino' => $data['tstc_destino'] ?? null,
                'fecha_traspaso' => $data['fecha_traspaso'],
                'tara_contenedor' => $data['tara_contenedor'] ?? null,
                'tipo_bulto' => $data['tipo_bulto'] ?? null,
                'valor_fob' => $data['valor_fob'] ?? null,
                'valor_cif' => $data['valor_cif'] ?? null,
                'aduana_salida' => $data['aduana_salida'],
                'puerto_salida' => $data['puerto_salida'] ?? null,
                'estado_contenedor' => $data['estado_contenedor'] ?? 'activo',
                'ubicacion_fisica' => $data['ubicacion_fisica'] ?? null,
                'empresa_transportista_id' => $data['empresa_transportista_id'] ?? null,
                'rut_chofer' => $data['rut_chofer'] ?? null,
                'patente_camion' => $data['patente_camion'] ?? null,
                'comentario' => $data['comentario'] ?? null,
            ]);

            // Registrar en historial
            $this->registrarHistorial($tstc, 'actualizar', $datosAnteriores, $tstc->toArray());

            Log::info('TSTC updated successfully', [
                'tstc_id' => $tstc->id,
                'numero_tstc' => $tstc->numero_tstc
            ]);

            return redirect()->route('tstc.index')
                ->with('success', 'TSTC actualizado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error updating TSTC', [
                'error' => $e->getMessage(),
                'tstc_id' => $tstc->id
            ]);

            return redirect()->back()
                ->with('error', 'Error al actualizar el TSTC: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tstc $tstc)
    {
        try {
            // Registrar en historial antes de eliminar
            $this->registrarHistorial($tstc, 'eliminar', $tstc->toArray(), null);

            $tstc->delete();

            Log::info('TSTC deleted successfully', [
                'tstc_id' => $tstc->id,
                'numero_tstc' => $tstc->numero_tstc
            ]);

            return redirect()->route('tstc.index')
                ->with('success', 'TSTC eliminado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error deleting TSTC', [
                'error' => $e->getMessage(),
                'tstc_id' => $tstc->id
            ]);

            return redirect()->back()
                ->with('error', 'Error al eliminar el TSTC: ' . $e->getMessage());
        }
    }

    /**
     * Consulta general de TSTCs
     */
    public function consulta()
    {
        $tstcs = Tstc::with(['user.operador'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('tstc.consulta', compact('tstcs'))
            ->with('titlePage', 'Consulta General de TSTC');
    }

    /**
     * Exportar TSTCs
     */
    public function exportar()
    {
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();

        return view('tstc.exportar', compact('aduanas', 'operadores'))
            ->with('titlePage', 'Exportar TSTC');
    }

    /**
     * Procesar exportación
     */
    public function procesarExportacion(Request $request)
    {
        // Lógica de exportación similar a TATC
        // Por ahora solo redirigir
        return redirect()->route('tstc.exportar')
            ->with('info', 'Funcionalidad de exportación en desarrollo.');
    }

    /**
     * Generar número TSTC via AJAX
     */
    public function generarNumeroTstcAjax(Request $request)
    {
        try {
            $aduanaSalida = $request->input('aduana_salida');
            if (!$aduanaSalida) {
                return response()->json(['error' => 'Aduana requerida'], 400);
            }

            $numeroTstc = Tstc::generarNumeroTstc(Auth::user()->operador, $aduanaSalida);
            
            return response()->json([
                'success' => true,
                'numero_tstc' => $numeroTstc
            ]);
        } catch (\Exception $e) {
            Log::error('Error generando número TSTC', [
                'error' => $e->getMessage(),
                'aduana' => $request->input('aduana_salida')
            ]);
            
            return response()->json(['error' => 'Error generando número TSTC'], 500);
        }
    }

    /**
     * Generar HTML del formato oficial de la aduana para impresión
     */
    public function generarPdf(Tstc $tstc)
    {
        // Cargar relaciones necesarias
        $tstc->load(['user.operador', 'empresaTransportista']);
        
        // Retornar vista HTML en lugar de PDF
        return view('tstc.pdf', compact('tstc'));
    }

    /**
     * Registrar cambios en el historial
     */
    private function registrarHistorial($tstc, $accion, $datosAnteriores = null, $datosNuevos = null, $estadoAnterior = null, $estadoNuevo = null)
    {
        try {
            // Detectar campos que cambiaron
            $camposCambiados = [];
            if ($datosAnteriores && $datosNuevos) {
                $camposImportantes = [
                    'numero_contenedor' => 'Número de Contenedor',
                    'tipo_contenedor' => 'Tipo de Contenedor',
                    'tipo_salida' => 'Tipo de Salida',
                    'salida_pais' => 'Salida del País',
                    'salida_deposito' => 'Salida del Depósito',
                    'tstc_origen' => 'TSTC Origen',
                    'tstc_destino' => 'TSTC Destino',
                    'fecha_traspaso' => 'Fecha de Traspaso',
                    'tara_contenedor' => 'Tara del Contenedor',
                    'tipo_bulto' => 'Tipo de Bulto',
                    'valor_fob' => 'Valor FOB',
                    'valor_cif' => 'Valor CIF',
                    'aduana_salida' => 'Aduana de Salida',
                    'puerto_salida' => 'Puerto de Salida',
                    'estado_contenedor' => 'Estado del Contenedor',
                    'ubicacion_fisica' => 'Ubicación Física',
                    'empresa_transportista_id' => 'Empresa Transportista',
                    'rut_chofer' => 'RUT del Chofer',
                    'patente_camion' => 'Patente del Camión',
                    'comentario' => 'Comentario'
                ];

                foreach ($camposImportantes as $campo => $nombre) {
                    $valorAnterior = $datosAnteriores[$campo] ?? null;
                    $valorNuevo = $datosNuevos[$campo] ?? null;
                    
                    if ($valorAnterior !== $valorNuevo) {
                        $camposCambiados[] = $nombre . ': "' . $valorAnterior . '" → "' . $valorNuevo . '"';
                    }
                }
            }

            $detalles = 'Modificación realizada por ' . Auth::user()->name;
            if (!empty($camposCambiados)) {
                $detalles .= '. Campos modificados: ' . implode(', ', $camposCambiados);
            }

            $tstc->historial()->create([
                'user_id' => Auth::id(),
                'accion' => $accion,
                'detalles' => $detalles,
                'datos_anteriores' => $datosAnteriores,
                'datos_nuevos' => $datosNuevos,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $estadoNuevo,
            ]);
        } catch (\Exception $e) {
            Log::error('Error registrando historial', [
                'error' => $e->getMessage(),
                'tstc_id' => $tstc->id
            ]);
        }
    }
}

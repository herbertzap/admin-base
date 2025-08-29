<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Tatc;
use App\Models\Operador;
use App\Models\TipoContenedor;
use App\Models\LugarDeposito;
use App\Models\EmpresaTransportista;
use App\Models\AduanaChile;
use PDF;

class TatcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tatcs = Tatc::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('tatc.index', compact('tatcs'));
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

        return view('tatc.create', compact('userOperador', 'tiposContenedor', 'lugaresDeposito', 'empresasTransportistas', 'aduanas'))
            ->with('titlePage', 'Registrar TATC');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log para debugging
        Log::info('TATC store request', [
            'user_id' => Auth::id(),
            'data' => $request->all()
        ]);

        // Convertir fechas de formato dd/mm/yyyy a yyyy-mm-dd
        $data = $request->all();
        if ($request->filled('ingreso_pais')) {
            $data['ingreso_pais'] = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->ingreso_pais)->format('Y-m-d H:i:s');
        }
        if ($request->filled('ingreso_deposito')) {
            $data['ingreso_deposito'] = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->ingreso_deposito)->format('Y-m-d H:i:s');
        }
        if ($request->filled('fecha_traspaso')) {
            $data['fecha_traspaso'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_traspaso)->format('Y-m-d');
        }

        // Validaciones según la documentación de Mitac
        $validator = Validator::make($data, [
            'numero_contenedor' => 'required|string|max:20',
            'tipo_contenedor' => 'required|string|max:10',
            'tipo_ingreso' => 'required|in:traspaso,desembarque',
            'ingreso_pais' => 'required|date',
            'ingreso_deposito' => 'required|date',
            'tatc_origen' => 'nullable|string|max:12',
            'tatc_destino' => 'nullable|string|max:12',
            'documento_ingreso' => 'nullable|string|max:50',
            'fecha_traspaso' => 'required|date',
            'tara_contenedor' => 'nullable|string|max:20',
            'tipo_bulto' => 'nullable|string|max:50',
            'valor_fob' => 'nullable|numeric|min:0',
            'comentario' => 'nullable|string|max:500',
            'aduana_ingreso' => 'required|string|max:100',
            'eir' => 'nullable|string|max:50',
            'tamano_contenedor' => 'nullable|string|max:10',
            'puerto_ingreso' => 'nullable|string|max:100',
            'estado_contenedor' => 'nullable|string|max:50',
            'anio_fabricacion' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'ubicacion_fisica' => 'nullable|string|max:200',
            'valor_cif' => 'nullable|numeric|min:0',
            'empresa_transportista_id' => 'nullable|exists:empresa_transportistas,id',
            'rut_chofer' => 'nullable|string|max:20',
            'patente_camion' => 'nullable|string|max:20',
            'documento_transporte' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            Log::error('TATC validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Generar número de TATC automáticamente
            $numeroTatc = $this->generarNumeroTatc($request->aduana_ingreso);
            
            Log::info('TATC number generated', ['numero_tatc' => $numeroTatc]);

            // Crear el TATC
            $tatc = new Tatc();
            $tatc->numero_tatc = $numeroTatc;
            $tatc->numero_contenedor = $request->numero_contenedor;
            $tatc->tipo_contenedor = $request->tipo_contenedor;
            $tatc->tipo_ingreso = $request->tipo_ingreso;
            $tatc->ingreso_pais = $data['ingreso_pais'];
            $tatc->ingreso_deposito = $data['ingreso_deposito'];
            $tatc->tatc_origen = $request->tatc_origen;
            $tatc->tatc_destino = $request->tatc_destino;
            $tatc->documento_ingreso = $request->documento_ingreso;
            $tatc->fecha_traspaso = $data['fecha_traspaso'];
            $tatc->tara_contenedor = $request->tara_contenedor;
            $tatc->tipo_bulto = $request->tipo_bulto;
            $tatc->valor_fob = $request->valor_fob;
            $tatc->comentario = $request->comentario;
            $tatc->aduana_ingreso = $request->aduana_ingreso;
            $tatc->eir = $request->eir;
            $tatc->tamano_contenedor = $request->tamano_contenedor;
            $tatc->puerto_ingreso = $request->puerto_ingreso;
            $tatc->estado_contenedor = $request->estado_contenedor;
            $tatc->anio_fabricacion = $request->anio_fabricacion;
            $tatc->ubicacion_fisica = $request->ubicacion_fisica;
            $tatc->valor_cif = $request->valor_cif;
            $tatc->empresa_transportista_id = $request->empresa_transportista_id;
            $tatc->rut_chofer = $request->rut_chofer;
            $tatc->patente_camion = $request->patente_camion;
            $tatc->documento_transporte = $request->documento_transporte;
            $tatc->estado = 'Pendiente';
            $tatc->user_id = Auth::id();

            $tatc->save();
            
            // Registrar creación en el historial
            $this->registrarHistorial($tatc, 'Creación del Registro', null, $tatc->toArray(), null, 'Pendiente');
            
            Log::info('TATC saved successfully', [
                'tatc_id' => $tatc->id,
                'numero_tatc' => $tatc->numero_tatc
            ]);

            return redirect()->route('tatc.index')
                ->with('success', 'TATC ' . $numeroTatc . ' registrado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error saving TATC', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Error al registrar TATC: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Genera automáticamente el número de TATC
     * Formato: [Código Aduana][Operador][Código Operador][Número Secuencial]
     * Ejemplo: 342460000010 (34=Aduana Valparaíso, 2=Operador, 46=Código Operador, 0000010=Número)
     */
    public function generarNumeroTatc($aduanaIngreso)
    {
        // Usar directamente el código de aduana que viene del formulario
        $codigoAduana = $aduanaIngreso;
        
        // Obtener código del operador del usuario autenticado
        $codigoOperador = $this->obtenerCodigoOperador();
        
        // Obtener el último número secuencial para este operador en esta aduana
        $ultimoTatc = Tatc::where('numero_tatc', 'LIKE', $codigoAduana . '2' . $codigoOperador . '%')
            ->orderBy('numero_tatc', 'desc')
            ->first();
        
        $numeroSecuencial = 1;
        if ($ultimoTatc) {
            // Extraer el número secuencial del último TATC (últimos 6 dígitos)
            $ultimoNumero = substr($ultimoTatc->numero_tatc, -6);
            $numeroSecuencial = intval($ultimoNumero) + 1;
        }
        
        // Formatear el número secuencial con ceros a la izquierda (6 dígitos)
        $numeroSecuencialFormateado = str_pad($numeroSecuencial, 6, '0', STR_PAD_LEFT);
        
        // Formato: código aduana + operador + código operador + número secuencial
        return $codigoAduana . '2' . $codigoOperador . $numeroSecuencialFormateado;
    }

    /**
     * Obtiene el código de aduana basado en el nombre
     */
    private function obtenerCodigoAduana($nombreAduana)
    {
        $codigosAduana = [
            'Valparaíso' => '34',
            'Santiago' => '33',
            'Antofagasta' => '23',
            'Iquique' => '21',
            'Arica' => '15',
            'Punta Arenas' => '63',
            'Puerto Montt' => '41',
            'Talcahuano' => '36',
            'Coquimbo' => '31',
            'Calama' => '22',
        ];
        
        foreach ($codigosAduana as $nombre => $codigo) {
            if (stripos($nombreAduana, $nombre) !== false) {
                return $codigo;
            }
        }
        
        // Si no encuentra coincidencia, usar código por defecto
        return '34'; // Valparaíso por defecto
    }

    /**
     * Obtiene el código del operador del usuario autenticado
     */
    private function obtenerCodigoOperador()
    {
        $user = Auth::user();
        
        if ($user && $user->operador) {
            // Si el operador tiene un código específico, extraer solo los números
            if ($user->operador->codigo) {
                // Extraer solo los números del código (ej: "S46" -> "46")
                $codigo = preg_replace('/[^0-9]/', '', $user->operador->codigo);
                return $codigo;
            }
            
            // Si no, usar el ID del operador
            return $user->operador->id;
        }
        
        // Si no hay operador asignado, usar el ID del usuario
        return $user->id;
    }

    /**
     * Display the specified resource.
     */
    public function show(Tatc $tatc)
    {
        return view('tatc.show', compact('tatc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tatc $tatc)
    {
        // Verificar si el TATC puede ser modificado
        if (!$tatc->puedeSerModificado()) {
            return redirect()->route('tatc.index')
                ->with('error', 'Este TATC no puede ser modificado porque ya tiene salidas registradas.');
        }

        $userOperador = Auth::user()->operador;
        $tiposContenedor = TipoContenedor::where('estado', 'Activo')->orderBy('descripcion')->get();
        $lugaresDeposito = LugarDeposito::where('estado', 'Activo')->orderBy('nombre_deposito')->get();
        $empresasTransportistas = EmpresaTransportista::where('estado', 'Activo')->orderBy('nombre_empresa')->get();
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();

        return view('tatc.edit', compact('tatc', 'userOperador', 'tiposContenedor', 'lugaresDeposito', 'empresasTransportistas', 'aduanas'))
            ->with('titlePage', 'Actualizar TATC');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tatc $tatc)
    {
        // Log para debugging
        Log::info('TATC update request', [
            'tatc_id' => $tatc->id,
            'user_id' => Auth::id(),
            'data' => $request->all()
        ]);

        // Convertir fechas de formato dd/mm/yyyy a yyyy-mm-dd
        $data = $request->all();
        if ($request->filled('ingreso_pais')) {
            $data['ingreso_pais'] = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->ingreso_pais)->format('Y-m-d H:i:s');
        }
        if ($request->filled('ingreso_deposito')) {
            $data['ingreso_deposito'] = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $request->ingreso_deposito)->format('Y-m-d H:i:s');
        }
        if ($request->filled('fecha_traspaso')) {
            $data['fecha_traspaso'] = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_traspaso)->format('Y-m-d');
        }

        // Validaciones
        $validator = Validator::make($data, [
            'numero_contenedor' => 'required|string|max:20',
            'tipo_contenedor' => 'required|string|max:10',
            'tipo_ingreso' => 'required|in:traspaso,desembarque',
            'ingreso_pais' => 'required|date',
            'ingreso_deposito' => 'required|date|after_or_equal:ingreso_pais',
            'tatc_origen' => 'nullable|string|max:12',
            'tatc_destino' => 'nullable|string|max:12',
            'documento_ingreso' => 'nullable|string|max:50',
            'fecha_traspaso' => 'required|date',
            'tara_contenedor' => 'nullable|string|max:20',
            'tipo_bulto' => 'nullable|string|max:50',
            'valor_fob' => 'nullable|numeric|min:0',
            'comentario' => 'nullable|string|max:500',
            'aduana_ingreso' => 'required|string|max:100',
            'eir' => 'nullable|string|max:50',
            'tamano_contenedor' => 'nullable|string|max:10',
            'puerto_ingreso' => 'nullable|string|max:100',
            'estado_contenedor' => 'nullable|string|max:50',
            'anio_fabricacion' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'ubicacion_fisica' => 'nullable|string|max:200',
            'valor_cif' => 'nullable|numeric|min:0',
            'empresa_transportista_id' => 'nullable|exists:empresa_transportistas,id',
            'rut_chofer' => 'nullable|string|max:20',
            'patente_camion' => 'nullable|string|max:20',
            'documento_transporte' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            Log::error('TATC update validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Guardar datos anteriores para el historial
            $datosAnteriores = $tatc->toArray();
            $estadoAnterior = $tatc->estado;

            // Actualizar el TATC
            $tatc->numero_contenedor = $request->numero_contenedor;
            $tatc->tipo_contenedor = $request->tipo_contenedor;
            $tatc->tipo_ingreso = $request->tipo_ingreso;
            $tatc->ingreso_pais = $data['ingreso_pais'];
            $tatc->ingreso_deposito = $data['ingreso_deposito'];
            $tatc->tatc_origen = $request->tatc_origen;
            $tatc->tatc_destino = $request->tatc_destino;
            $tatc->documento_ingreso = $request->documento_ingreso;
            $tatc->fecha_traspaso = $data['fecha_traspaso'];
            $tatc->tara_contenedor = $request->tara_contenedor;
            $tatc->tipo_bulto = $request->tipo_bulto;
            $tatc->valor_fob = $request->valor_fob;
            $tatc->comentario = $request->comentario;
            $tatc->aduana_ingreso = $request->aduana_ingreso;
            $tatc->eir = $request->eir;
            $tatc->tamano_contenedor = $request->tamano_contenedor;
            $tatc->puerto_ingreso = $request->puerto_ingreso;
            $tatc->estado_contenedor = $request->estado_contenedor;
            $tatc->anio_fabricacion = $request->anio_fabricacion;
            $tatc->ubicacion_fisica = $request->ubicacion_fisica;
            $tatc->valor_cif = $request->valor_cif;
            $tatc->empresa_transportista_id = $request->empresa_transportista_id;
            $tatc->rut_chofer = $request->rut_chofer;
            $tatc->patente_camion = $request->patente_camion;
            $tatc->documento_transporte = $request->documento_transporte;

            $tatc->save();

            // Registrar en el historial
            $this->registrarHistorial($tatc, 'Modificación del Registro', $datosAnteriores, $tatc->toArray(), $estadoAnterior, $tatc->estado);

            Log::info('TATC updated successfully', [
                'tatc_id' => $tatc->id,
                'numero_tatc' => $tatc->numero_tatc
            ]);

            return redirect()->route('tatc.index')
                ->with('success', 'TATC ' . $tatc->numero_tatc . ' actualizado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error updating TATC', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Error al actualizar TATC: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Registrar entrada en el historial del TATC
     */
    private function registrarHistorial($tatc, $accion, $datosAnteriores = null, $datosNuevos = null, $estadoAnterior = null, $estadoNuevo = null)
    {
        try {
            // Detectar campos que cambiaron
            $camposCambiados = [];
            if ($datosAnteriores && $datosNuevos) {
                $camposImportantes = [
                    'numero_contenedor' => 'Número de Contenedor',
                    'tipo_contenedor' => 'Tipo de Contenedor',
                    'tipo_ingreso' => 'Tipo de Ingreso',
                    'ingreso_pais' => 'Ingreso al País',
                    'ingreso_deposito' => 'Ingreso al Depósito',
                    'tatc_origen' => 'TATC Origen',
                    'tatc_destino' => 'TATC Destino',
                    'fecha_traspaso' => 'Fecha de Traspaso',
                    'tara_contenedor' => 'Tara del Contenedor',
                    'tipo_bulto' => 'Tipo de Bulto',
                    'valor_fob' => 'Valor FOB',
                    'valor_cif' => 'Valor CIF',
                    'aduana_ingreso' => 'Aduana de Ingreso',
                    'puerto_ingreso' => 'Puerto de Ingreso',
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

            $tatc->historial()->create([
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
                'tatc_id' => $tatc->id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tatc $tatc)
    {
        $tatc->delete();

        return redirect()->route('tatc.index')
            ->with('success', 'TATC eliminado exitosamente.');
    }

    /**
     * Mostrar formulario de consulta general
     */
    public function consulta(Request $request)
    {
        $query = Tatc::with(['user.operador']);

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('numero_tatc', 'like', "%{$buscar}%")
                  ->orWhere('numero_contenedor', 'like', "%{$buscar}%")
                  ->orWhere('aduana_ingreso', 'like', "%{$buscar}%")
                  ->orWhere('estado', 'like', "%{$buscar}%");
            });
        }

        // Cantidad de registros por página
        $perPage = $request->get('mostrar', 10);
        
        $tatcs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('tatc.consulta', compact('tatcs'));
    }

    /**
     * Mostrar formulario de exportación
     */
    public function exportar()
    {
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();

        return view('tatc.exportar', compact('aduanas', 'operadores'));
    }

    /**
     * Mostrar formulario de carga masiva
     */
    public function cargaMasiva()
    {
        return view('tatc.carga-masiva');
    }

    /**
     * Buscar TATC por número
     */
    public function buscar(Request $request)
    {
        $numeroTatc = $request->get('numero_tatc');
        
        $tatc = Tatc::where('numero_tatc', $numeroTatc)->first();
        
        if ($tatc) {
            return response()->json([
                'success' => true,
                'tatc' => $tatc
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'TATC no encontrado'
        ]);
    }

    /**
     * Procesar exportación de TATC
     */
    public function procesarExportacion(Request $request)
    {
        $request->validate([
            'fecha_desde' => 'required|date',
            'fecha_hasta' => 'required|date|after_or_equal:fecha_desde',
            'formato' => 'required|in:excel,csv,pdf',
            'campos' => 'required|array|min:1'
        ]);

        $query = Tatc::with(['user.operador']);

        // Filtros
        $query->whereBetween('created_at', [$request->fecha_desde, $request->fecha_hasta . ' 23:59:59']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('aduana')) {
            $query->where('aduana_ingreso', $request->aduana);
        }

        if ($request->filled('tipo_ingreso')) {
            $query->where('tipo_ingreso', $request->tipo_ingreso);
        }

        if ($request->filled('operador_id')) {
            $query->whereHas('user.operador', function($q) use ($request) {
                $q->where('id', $request->operador_id);
            });
        }

        if ($request->filled('numero_contenedor')) {
            $query->where('numero_contenedor', 'like', "%{$request->numero_contenedor}%");
        }

        $tatcs = $query->orderBy('created_at', 'desc')->get();

        // Generar archivo según formato
        switch ($request->formato) {
            case 'excel':
                return $this->exportarExcel($tatcs, $request->campos);
            case 'csv':
                return $this->exportarCsv($tatcs, $request->campos);
            case 'pdf':
                return $this->exportarPdf($tatcs, $request->campos);
            default:
                return redirect()->back()->with('error', 'Formato no válido');
        }
    }

    /**
     * Exportar a Excel
     */
    private function exportarExcel($tatcs, $campos)
    {
        // Aquí implementarías la lógica de exportación a Excel
        // Por ahora retornamos un mensaje
        return redirect()->back()->with('success', 'Exportación a Excel implementada');
    }

    /**
     * Exportar a CSV
     */
    private function exportarCsv($tatcs, $campos)
    {
        // Aquí implementarías la lógica de exportación a CSV
        return redirect()->back()->with('success', 'Exportación a CSV implementada');
    }

    /**
     * Exportar a PDF
     */
    private function exportarPdf($tatcs, $campos)
    {
        // Aquí implementarías la lógica de exportación a PDF
        return redirect()->back()->with('success', 'Exportación a PDF implementada');
    }

    /**
     * Generar número TATC via AJAX
     */
    public function generarNumeroTatcAjax(Request $request)
    {
        try {
            $aduanaIngreso = $request->input('aduana_ingreso');
            if (!$aduanaIngreso) {
                return response()->json(['error' => 'Aduana requerida'], 400);
            }

            $numeroTatc = $this->generarNumeroTatc($aduanaIngreso);
            
            return response()->json([
                'success' => true,
                'numero_tatc' => $numeroTatc
            ]);
        } catch (\Exception $e) {
            Log::error('Error generando número TATC', [
                'error' => $e->getMessage(),
                'aduana' => $request->input('aduana_ingreso')
            ]);
            
            return response()->json(['error' => 'Error generando número TATC'], 500);
        }
    }

    /**
     * Generar HTML del formato oficial de la aduana para impresión
     */
    public function generarPdf(Tatc $tatc)
    {
        // Cargar relaciones necesarias
        $tatc->load(['user.operador', 'empresaTransportista']);
        
        // Retornar vista HTML en lugar de PDF
        return view('tatc.pdf', compact('tatc'));
    }
}

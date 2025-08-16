<?php

namespace App\Http\Controllers;

use App\Models\Contenedor;
use App\Models\EmpresaTransportista;
use App\Models\TipoContenedor;
use App\Models\LugarDeposito;
use App\Models\AduanaChile;
use App\Models\Operador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contenedores = Contenedor::with(['operador', 'tipoContenedor', 'lugarDeposito', 'empresaTransportista'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('logistica.index', compact('contenedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();
        $tiposContenedores = TipoContenedor::where('estado', 'Activo')->orderBy('descripcion')->get();
        $lugaresDeposito = LugarDeposito::where('estado', 'Activo')->orderBy('nombre_deposito')->get();
        $empresasTransportistas = EmpresaTransportista::where('estado', 'Activo')->orderBy('nombre_empresa')->get();
        $aduanasChile = AduanaChile::where('estado', 'Activo')->orderBy('nombre_aduana')->get();
        $estadosContenedor = Contenedor::getEstados();
        
        // Cargar el operador del usuario autenticado
        $userOperador = null;
        if (Auth::user()->operador_id) {
            $userOperador = Operador::find(Auth::user()->operador_id);
        }

        return view('logistica.create', compact('operadores', 'tiposContenedores', 'lugaresDeposito', 'empresasTransportistas', 'aduanasChile', 'userOperador', 'estadosContenedor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Datos Contenedor
            'numero_contenedor' => 'required|string|max:12|min:12',
            'tipo_contenedor_id' => 'required|exists:tipo_contenedors,id',
            'tamano_contenedor' => 'required|in:20,40',
            'estado_contenedor' => 'required|in:OP,DM',
            'tara_contenedor' => 'nullable|integer|min:0|max:9999',
            'anofab_contenedor' => 'nullable|integer|min:1900|max:2030',
            'pais_id' => 'nullable|string|max:10',
            'ingreso_doc' => 'nullable|string|max:255',
            'comentario' => 'nullable|string|max:1000',
            'fecha_ingreso' => 'required|date|before_or_equal:today',
            'tatc' => 'nullable|string|max:12|min:12',
            'lugardeposito_id' => 'required|exists:lugar_depositos,id',
            'aduana_ingreso_id' => 'nullable|exists:aduana_chiles,id',
            
            // TATC Asociado
            'origen_tatc' => 'nullable|string|max:50',
            'destino_tatc' => 'nullable|string|max:50',
            'tatc_emisor' => 'nullable|string|max:255',
            'tatc_ingreso' => 'nullable|string|max:255',
            'tipo_ingreso' => 'nullable|in:1,2',
            'eir' => 'nullable|string|max:255',
            'comentario_tatc' => 'nullable|string|max:1000',
            
            // Facturación
            'rut_factura' => 'nullable|string|max:20',
            'nombre_factura' => 'nullable|string|max:255',
            'direccion_factura' => 'nullable|string|max:255',
            'giro_factura' => 'nullable|string|max:255',
            'fecha_factura' => 'nullable|date',
            'orden_compra' => 'nullable|string|max:255',
            'tipo_pago' => 'nullable|string|max:255',
            'valor_factura' => 'nullable|integer|min:0',
            'reserva_nombre' => 'nullable|string|max:255',
            'comentario_facturacion' => 'nullable|string|max:1000',
            'factura_oc' => 'nullable|string|max:255',
            'factura_comentario' => 'nullable|string|max:1000',
            
            // Transporte
            'empresa_transportista_id' => 'nullable|exists:empresa_transportistas,id',
            'rut_chofer' => 'nullable|string|max:20',
            'patente_camion' => 'nullable|string|max:10',
            'documento_transporte' => 'nullable|string|max:255',
            'transporte_documento' => 'nullable|string|max:255',
            
            // Datos Extras
            'extra_proveedor_nombre' => 'nullable|string|max:100',
            'extra_proveedor_factura' => 'nullable|string|max:100',
            'extra_proveedor_valor' => 'nullable|string|max:100',
            'extra_proveedor_fecha' => 'nullable|date',
            'extra_panama_factura' => 'nullable|string|max:100',
            'extra_panama_valor' => 'nullable|string|max:100',
            'extra_panama_fecha' => 'nullable|date',
            'extra_cym_factura' => 'nullable|string|max:100',
            'extra_cym_valor' => 'nullable|string|max:100',
            'extra_cym_fecha' => 'nullable|date',
            'extra_boxtam_factura' => 'nullable|string|max:100',
            'extra_boxtam_fecha' => 'nullable|date',
            'extra_ciudad' => 'nullable|string|max:100',
            'extra_tipo' => 'nullable|string|max:100',
            
            // Estado
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $data = $request->all();
        
        // Auto-asignar operador si el usuario tiene uno
        if (Auth::user()->operador_id) {
            $data['operador_id'] = Auth::user()->operador_id;
        }

        Contenedor::create($data);

        return redirect()->route('logistica.index')
            ->with('success', 'Contenedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contenedor $logistica)
    {
        return view('logistica.show', compact('logistica'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contenedor $logistica)
    {
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();
        $tiposContenedores = TipoContenedor::where('estado', 'Activo')->orderBy('descripcion')->get();
        $lugaresDeposito = LugarDeposito::where('estado', 'Activo')->orderBy('nombre_deposito')->get();
        $empresasTransportistas = EmpresaTransportista::where('estado', 'Activo')->orderBy('nombre_empresa')->get();
        $aduanasChile = AduanaChile::where('estado', 'Activo')->orderBy('nombre_aduana')->get();
        $estadosContenedor = Contenedor::getEstados();
        
        // Cargar el operador del usuario autenticado
        $userOperador = null;
        if (Auth::user()->operador_id) {
            $userOperador = Operador::find(Auth::user()->operador_id);
        }

        return view('logistica.edit', compact('logistica', 'operadores', 'tiposContenedores', 'lugaresDeposito', 'empresasTransportistas', 'aduanasChile', 'userOperador', 'estadosContenedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contenedor $logistica)
    {
        $request->validate([
            // Datos Contenedor
            'numero_contenedor' => 'required|string|max:12|min:12',
            'tipo_contenedor_id' => 'required|exists:tipo_contenedors,id',
            'tamano_contenedor' => 'required|in:20,40',
            'estado_contenedor' => 'required|in:OP,DM',
            'tara_contenedor' => 'nullable|integer|min:0|max:9999',
            'anofab_contenedor' => 'nullable|integer|min:1900|max:2030',
            'pais_id' => 'nullable|string|max:10',
            'ingreso_doc' => 'nullable|string|max:255',
            'comentario' => 'nullable|string|max:1000',
            'fecha_ingreso' => 'required|date|before_or_equal:today',
            'tatc' => 'nullable|string|max:12|min:12',
            'lugardeposito_id' => 'required|exists:lugar_depositos,id',
            'aduana_ingreso_id' => 'nullable|exists:aduana_chiles,id',
            
            // TATC Asociado
            'origen_tatc' => 'nullable|string|max:50',
            'destino_tatc' => 'nullable|string|max:50',
            'tatc_emisor' => 'nullable|string|max:255',
            'tatc_ingreso' => 'nullable|string|max:255',
            'tipo_ingreso' => 'nullable|in:1,2',
            'eir' => 'nullable|string|max:255',
            'comentario_tatc' => 'nullable|string|max:1000',
            
            // Facturación
            'rut_factura' => 'nullable|string|max:20',
            'nombre_factura' => 'nullable|string|max:255',
            'direccion_factura' => 'nullable|string|max:255',
            'giro_factura' => 'nullable|string|max:255',
            'fecha_factura' => 'nullable|date',
            'orden_compra' => 'nullable|string|max:255',
            'tipo_pago' => 'nullable|string|max:255',
            'valor_factura' => 'nullable|integer|min:0',
            'reserva_nombre' => 'nullable|string|max:255',
            'comentario_facturacion' => 'nullable|string|max:1000',
            'factura_oc' => 'nullable|string|max:255',
            'factura_comentario' => 'nullable|string|max:1000',
            
            // Transporte
            'empresa_transportista_id' => 'nullable|exists:empresa_transportistas,id',
            'rut_chofer' => 'nullable|string|max:20',
            'patente_camion' => 'nullable|string|max:10',
            'documento_transporte' => 'nullable|string|max:255',
            'transporte_documento' => 'nullable|string|max:255',
            
            // Datos Extras
            'extra_proveedor_nombre' => 'nullable|string|max:100',
            'extra_proveedor_factura' => 'nullable|string|max:100',
            'extra_proveedor_valor' => 'nullable|string|max:100',
            'extra_proveedor_fecha' => 'nullable|date',
            'extra_panama_factura' => 'nullable|string|max:100',
            'extra_panama_valor' => 'nullable|string|max:100',
            'extra_panama_fecha' => 'nullable|date',
            'extra_cym_factura' => 'nullable|string|max:100',
            'extra_cym_valor' => 'nullable|string|max:100',
            'extra_cym_fecha' => 'nullable|date',
            'extra_boxtam_factura' => 'nullable|string|max:100',
            'extra_boxtam_fecha' => 'nullable|date',
            'extra_ciudad' => 'nullable|string|max:100',
            'extra_tipo' => 'nullable|string|max:100',
            
            // Estado
            'estado' => 'required|in:Activo,Inactivo',
        ]);

        $data = $request->all();
        
        // Auto-asignar operador si el usuario tiene uno
        if (Auth::user()->operador_id) {
            $data['operador_id'] = Auth::user()->operador_id;
        }

        $logistica->update($data);

        return redirect()->route('logistica.index')
            ->with('success', 'Contenedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contenedor $logistica)
    {
        $logistica->delete();

        return redirect()->route('logistica.index')
            ->with('success', 'Contenedor eliminado exitosamente.');
    }

    /**
     * Mostrar inventario de contenedores
     */
    public function inventario()
    {
        $contenedores = Contenedor::with(['tipoContenedor', 'lugarDeposito', 'operador'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $lugaresDeposito = LugarDeposito::where('estado', 'Activo')->orderBy('nombre_deposito')->get();
        $estadosContenedor = Contenedor::getEstados();

        return view('logistica.inventario', compact('contenedores', 'lugaresDeposito', 'estadosContenedor'))
            ->with('titlePage', 'Inventario y Stock');
    }
}

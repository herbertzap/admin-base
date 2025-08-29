<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\AduanaChile;
use App\Models\Operador;

class ControlInventariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener filtros
        $aduana = $request->get('aduana');
        $operador = $request->get('operador');
        $tipoContenedor = $request->get('tipo_contenedor');
        $estadoContenedor = $request->get('estado_contenedor');
        $buscar = $request->get('buscar');

        // Obtener TATCs vigentes (sin salidas registradas)
        $tatcsQuery = Tatc::whereDoesntHave('salidas')
            ->orWhereHas('salidas', function($query) {
                $query->where('estado', 'Cancelado');
            })
            ->with(['user.operador', 'aduana']);

        // Aplicar filtros para TATCs
        if ($aduana) {
            $tatcsQuery->where('aduana_ingreso', $aduana);
        }
        if ($operador) {
            $tatcsQuery->whereHas('user.operador', function($query) use ($operador) {
                $query->where('id', $operador);
            });
        }
        if ($tipoContenedor) {
            $tatcsQuery->where('tipo_contenedor', $tipoContenedor);
        }
        if ($estadoContenedor) {
            $tatcsQuery->where('estado_contenedor', $estadoContenedor);
        }
        if ($buscar) {
            $tatcsQuery->where(function($query) use ($buscar) {
                $query->where('numero_contenedor', 'like', "%{$buscar}%")
                      ->orWhere('numero_tatc', 'like', "%{$buscar}%");
            });
        }

        $tatcs = $tatcsQuery->orderBy('created_at', 'desc')->paginate(15);

        // Obtener datos para filtros
        $aduanas = AduanaChile::where('estado', 'Activo')->orderBy('codigo')->get();
        $operadores = Operador::where('estado', 'activo')->orderBy('nombre_operador')->get();

        // Contar total de contenedores vigentes (solo TATCs por ahora)
        $totalContenedores = $tatcs->total();

        return view('control-inventarios.index', compact(
            'tatcs', 
            'aduanas', 
            'operadores', 
            'totalContenedores',
            'request'
        ))->with('titlePage', 'Control de Inventarios');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Exportar inventario
     */
    public function exportar(Request $request)
    {
        $request->validate([
            'formato' => 'required|in:excel,csv,pdf',
            'tipo' => 'required|in:tatc,tstc,todos'
        ]);

        // Obtener datos según tipo
        if ($request->tipo === 'tatc') {
            $datos = Tatc::whereDoesntHave('salidas')
                ->orWhereHas('salidas', function($query) {
                    $query->where('estado', 'Cancelado');
                })
                ->with(['user.operador', 'aduana'])
                ->get();
        } elseif ($request->tipo === 'tstc') {
            $datos = Tstc::whereDoesntHave('salidas')
                ->orWhereHas('salidas', function($query) {
                    $query->where('estado', 'Cancelado');
                })
                ->with(['operador', 'aduana'])
                ->get();
        } else {
            // Combinar TATCs y TSTCs
            $tatcs = Tatc::whereDoesntHave('salidas')
                ->orWhereHas('salidas', function($query) {
                    $query->where('estado', 'Cancelado');
                })
                ->with(['user.operador', 'aduana'])
                ->get();
            
            $tstcs = Tstc::whereDoesntHave('salidas')
                ->orWhereHas('salidas', function($query) {
                    $query->where('estado', 'Cancelado');
                })
                ->with(['operador', 'aduana'])
                ->get();
            
            $datos = $tatcs->concat($tstcs);
        }

        // Generar archivo según formato
        switch ($request->formato) {
            case 'excel':
                return $this->exportarExcel($datos, $request->tipo);
            case 'csv':
                return $this->exportarCsv($datos, $request->tipo);
            case 'pdf':
                return $this->exportarPdf($datos, $request->tipo);
            default:
                return redirect()->back()->with('error', 'Formato no válido');
        }
    }

    /**
     * Exportar a Excel
     */
    private function exportarExcel($datos, $tipo)
    {
        // Aquí implementarías la lógica de exportación a Excel
        return redirect()->back()->with('info', 'Exportación a Excel en desarrollo');
    }

    /**
     * Exportar a CSV
     */
    private function exportarCsv($datos, $tipo)
    {
        // Aquí implementarías la lógica de exportación a CSV
        return redirect()->back()->with('info', 'Exportación a CSV en desarrollo');
    }

    /**
     * Exportar a PDF
     */
    private function exportarPdf($datos, $tipo)
    {
        // Aquí implementarías la lógica de exportación a PDF
        return redirect()->back()->with('info', 'Exportación a PDF en desarrollo');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;
use App\Models\AduanaChile;
use App\Models\Operador;

class ControlPlazosController extends Controller
{
    /**
     * Plazos de Vigencia - Lista de TATC/TSTC vigentes
     */
    public function plazosVigencia()
    {
        $tatcsVigentes = Tatc::with(['user.operador', 'aduana'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

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
        // Por ahora, mostrar TATC/TSTC que han sido modificados (como prórrogas)
        $prorrogas = Tatc::with(['user.operador', 'aduana'])
            ->orderBy('updated_at', 'desc')
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
            $registro = Tatc::with(['user.operador', 'aduana', 'historial', 'salidas'])->findOrFail($id);
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
     * Exportar registros
     */
    public function exportar(Request $request)
    {
        $tipo = $request->get('tipo', 'tatc');
        $formato = $request->get('formato', 'excel');

        if ($tipo === 'tatc') {
            $registros = Tatc::with(['user.operador', 'aduana'])->get();
        } else {
            $registros = Tstc::with(['user.operador', 'aduana'])->get();
        }

        // Lógica de exportación (placeholder)
        return redirect()->back()
            ->with('info', 'Funcionalidad de exportación en desarrollo para ' . strtoupper($tipo));
    }
}

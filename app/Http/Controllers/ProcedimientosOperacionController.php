<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProcedimientosOperacionController extends Controller
{
    /**
     * Mostrar el procedimiento de operación del sistema
     */
    public function index()
    {
        return view('procedimientos-operacion.index');
    }

    /**
     * Generar PDF del procedimiento de operación
     */
    public function pdf()
    {
        $pdf = \PDF::loadView('procedimientos-operacion.pdf');
        return $pdf->download('Procedimiento_Operacion_CONTENEDORES_PRICER_' . now()->format('Y-m-d') . '.pdf');
    }
}


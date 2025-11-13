<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualController extends Controller
{
    /**
     * Mostrar el manual del sistema
     */
    public function index()
    {
        return view('manual.index');
    }

    /**
     * Generar PDF del manual
     */
    public function pdf()
    {
        $pdf = \PDF::loadView('manual.pdf');
        return $pdf->download('Manual_Sistema_Contenedores_Pricer_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Mostrar PDF del manual en el navegador (público)
     */
    public function pdfPublico()
    {
        $pdf = \PDF::loadView('manual.pdf');
        return $pdf->stream('Manual_Sistema_Contenedores_Pricer_' . now()->format('Y-m-d') . '.pdf');
    }
}
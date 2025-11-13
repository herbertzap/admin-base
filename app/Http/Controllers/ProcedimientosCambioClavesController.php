<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcedimientosCambioClavesController extends Controller
{
    /**
     * Mostrar el procedimiento de cambio de claves
     */
    public function index()
    {
        return view('procedimientos-cambio-claves.index')
            ->with('titlePage', 'Procedimiento de Cambio de Claves');
    }

    /**
     * Generar PDF del procedimiento de cambio de claves
     */
    public function pdf()
    {
        $data = [
            'fecha' => now()->format('d/m/Y'),
            'version' => '2.0'
        ];

        $pdf = Pdf::loadView('procedimientos-cambio-claves.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Procedimiento_Cambio_Claves_Contenedores_Pricer_' . now()->format('Y-m-d') . '.pdf');
    }
}


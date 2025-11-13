<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ManualAduanaController extends Controller
{
    /**
     * Mostrar el manual de usuario para Aduana
     */
    public function index()
    {
        return view('manual-aduana.index')
            ->with('titlePage', 'Manual de Usuario - Aduana');
    }

    /**
     * Generar PDF del manual de Aduana
     */
    public function pdf()
    {
        $data = [
            'fecha' => now()->format('d/m/Y'),
            'version' => '2.0'
        ];

        $pdf = Pdf::loadView('manual-aduana.pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('Manual_Usuario_Aduana_Contenedores_Pricer_' . now()->format('Y-m-d') . '.pdf');
    }
}


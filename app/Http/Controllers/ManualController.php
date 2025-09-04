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
        return $pdf->download('manual-sistema-mitac.pdf');
    }
}
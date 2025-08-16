<?php

namespace App\Http\Controllers;

use App\Models\AduanaChile;
use Illuminate\Http\Request;

class AduanaChileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aduanas = AduanaChile::orderBy('nombre_aduana')->paginate(10);
        return view('aduana-chiles.index', compact('aduanas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aduana-chiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:aduana_chiles',
            'nombre_aduana' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'estado' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        AduanaChile::create($request->all());

        return redirect()->route('aduana-chiles.index')
            ->with('success', 'Aduana creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AduanaChile $aduanaChile)
    {
        return view('aduana-chiles.show', compact('aduanaChile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AduanaChile $aduanaChile)
    {
        return view('aduana-chiles.edit', compact('aduanaChile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AduanaChile $aduanaChile)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:aduana_chiles,codigo,' . $aduanaChile->id,
            'nombre_aduana' => 'required|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'estado' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        $aduanaChile->update($request->all());

        return redirect()->route('aduana-chiles.index')
            ->with('success', 'Aduana actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AduanaChile $aduanaChile)
    {
        $aduanaChile->delete();

        return redirect()->route('aduana-chiles.index')
            ->with('success', 'Aduana eliminada exitosamente.');
    }
}

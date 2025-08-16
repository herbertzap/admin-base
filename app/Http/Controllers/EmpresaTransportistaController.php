<?php

namespace App\Http\Controllers;

use App\Models\EmpresaTransportista;
use Illuminate\Http\Request;

class EmpresaTransportistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = EmpresaTransportista::orderBy('nombre_empresa')->paginate(10);
        return view('empresa-transportistas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empresa-transportistas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'rut_empresa' => 'required|string|max:20|unique:empresa_transportistas',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contacto_persona' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:20',
            'contacto_email' => 'nullable|email|max:255',
            'estado' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        EmpresaTransportista::create($request->all());

        return redirect()->route('empresa-transportistas.index')
            ->with('success', 'Empresa transportista creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmpresaTransportista $empresaTransportista)
    {
        return view('empresa-transportistas.show', compact('empresaTransportista'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmpresaTransportista $empresaTransportista)
    {
        return view('empresa-transportistas.edit', compact('empresaTransportista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmpresaTransportista $empresaTransportista)
    {
        $request->validate([
            'nombre_empresa' => 'required|string|max:255',
            'rut_empresa' => 'required|string|max:20|unique:empresa_transportistas,rut_empresa,' . $empresaTransportista->id,
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'contacto_persona' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:20',
            'contacto_email' => 'nullable|email|max:255',
            'estado' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        $empresaTransportista->update($request->all());

        return redirect()->route('empresa-transportistas.index')
            ->with('success', 'Empresa transportista actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmpresaTransportista $empresaTransportista)
    {
        $empresaTransportista->delete();

        return redirect()->route('empresa-transportistas.index')
            ->with('success', 'Empresa transportista eliminada exitosamente.');
    }
}

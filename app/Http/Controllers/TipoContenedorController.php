<?php

namespace App\Http\Controllers;

use App\Models\TipoContenedor;
use App\Models\Operador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoContenedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipos = TipoContenedor::with('operador')->orderBy('codigo')->paginate(10);
        return view('tipo-contenedors.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();
        return view('tipo-contenedors.create', compact('operadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:tipo_contenedors',
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|in:Activo,Inactivo',
            'operador_id' => 'nullable|exists:operadors,id',
        ]);

        $data = $request->only(['codigo', 'descripcion', 'estado']);
        
        // Asignar operador automáticamente si el usuario actual es operador
        if (Auth::user()->hasOperador()) {
            $data['operador_id'] = Auth::user()->operador_id;
        } else {
            $data['operador_id'] = $request->input('operador_id');
        }

        TipoContenedor::create($data);

        return redirect()->route('tipo-contenedors.index')
            ->with('success', 'Tipo de contenedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoContenedor $tipoContenedor)
    {
        return view('tipo-contenedors.show', compact('tipoContenedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoContenedor $tipoContenedor)
    {
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();
        return view('tipo-contenedors.edit', compact('tipoContenedor', 'operadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoContenedor $tipoContenedor)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:tipo_contenedors,codigo,' . $tipoContenedor->id,
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|in:Activo,Inactivo',
            'operador_id' => 'nullable|exists:operadors,id',
        ]);

        $data = $request->only(['codigo', 'descripcion', 'estado']);
        
        // Asignar operador automáticamente si el usuario actual es operador
        if (Auth::user()->hasOperador()) {
            $data['operador_id'] = Auth::user()->operador_id;
        } else {
            $data['operador_id'] = $request->input('operador_id');
        }

        $tipoContenedor->update($data);

        return redirect()->route('tipo-contenedors.index')
            ->with('success', 'Tipo de contenedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoContenedor $tipoContenedor)
    {
        $tipoContenedor->delete();

        return redirect()->route('tipo-contenedors.index')
            ->with('success', 'Tipo de contenedor eliminado exitosamente.');
    }
}

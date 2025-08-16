<?php

namespace App\Http\Controllers;

use App\Models\LugarDeposito;
use App\Models\Operador;
use Illuminate\Http\Request;

class LugarDepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lugares = LugarDeposito::with('operador')->orderBy('nombre_deposito')->paginate(10);
        return view('lugar-depositos.index', compact('lugares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();
        return view('lugar-depositos.create', compact('operadores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:lugar_depositos',
            'nombre_deposito' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'capacidad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'operador_id' => 'nullable|exists:operadors,id',
            'estado' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        LugarDeposito::create($request->all());

        return redirect()->route('lugar-depositos.index')
            ->with('success', 'Lugar de depósito creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LugarDeposito $lugarDeposito)
    {
        return view('lugar-depositos.show', compact('lugarDeposito'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LugarDeposito $lugarDeposito)
    {
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();
        return view('lugar-depositos.edit', compact('lugarDeposito', 'operadores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LugarDeposito $lugarDeposito)
    {
        $request->validate([
            'codigo' => 'required|string|max:50|unique:lugar_depositos,codigo,' . $lugarDeposito->id,
            'nombre_deposito' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'capacidad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'operador_id' => 'nullable|exists:operadors,id',
            'estado' => 'required|in:Activo,Inactivo',
            'observaciones' => 'nullable|string',
        ]);

        $lugarDeposito->update($request->all());

        return redirect()->route('lugar-depositos.index')
            ->with('success', 'Lugar de depósito actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LugarDeposito $lugarDeposito)
    {
        $lugarDeposito->delete();

        return redirect()->route('lugar-depositos.index')
            ->with('success', 'Lugar de depósito eliminado exitosamente.');
    }
}

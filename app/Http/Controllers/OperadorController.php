<?php

namespace App\Http\Controllers;

use App\Models\Operador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperadorController extends Controller
{
    public function index()
    {
        $operadores = Operador::all();
        return view('operadores.index', compact('operadores'));
    }

    public function create()
    {
        return view('operadores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|unique:operadors',
            'rut_operador' => 'required',
            'nombre_operador' => 'required',
            'nombre_fantasia' => 'nullable',
            'direccion_operador' => 'nullable',
            'resolucion_operador' => 'nullable',
            'logo_operador' => 'nullable|file|image',
            'firma_operador' => 'nullable|file|image',
            'rut_representante' => 'nullable',
            'nombre_representante' => 'nullable',
            'cargo_representante' => 'nullable',
            'estado' => 'required',
            'nombre_remitente' => 'nullable',
            'email_remitente' => 'nullable|email',
            'email_copia' => 'nullable|email',
            'valida_ingreso_aduana' => 'boolean',
            'email_notificaciones' => 'nullable|email',
        ]);
        // Manejo de archivos
        if ($request->hasFile('logo_operador')) {
            $data['logo_operador'] = $request->file('logo_operador')->store('logos', 'public');
        }
        if ($request->hasFile('firma_operador')) {
            $data['firma_operador'] = $request->file('firma_operador')->store('firmas', 'public');
        }
        $data['usuario_id'] = Auth::id();
        $data['fecha_creacion'] = now();
        $data['fecha_actualizacion'] = now();
        Operador::create($data);
        return redirect()->route('operadores.index')->with('success', 'Operador creado correctamente');
    }

    public function edit(Operador $operador)
    {
        return view('operadores.edit', compact('operador'));
    }

    public function update(Request $request, Operador $operador)
    {
        $data = $request->validate([
            'codigo' => 'required|unique:operadors,codigo,' . $operador->id,
            'rut_operador' => 'required',
            'nombre_operador' => 'required',
            'nombre_fantasia' => 'nullable',
            'direccion_operador' => 'nullable',
            'resolucion_operador' => 'nullable',
            'logo_operador' => 'nullable|file|image',
            'firma_operador' => 'nullable|file|image',
            'rut_representante' => 'nullable',
            'nombre_representante' => 'nullable',
            'cargo_representante' => 'nullable',
            'estado' => 'required',
            'nombre_remitente' => 'nullable',
            'email_remitente' => 'nullable|email',
            'email_copia' => 'nullable|email',
            'valida_ingreso_aduana' => 'boolean',
            'email_notificaciones' => 'nullable|email',
        ]);
        if ($request->hasFile('logo_operador')) {
            $data['logo_operador'] = $request->file('logo_operador')->store('logos', 'public');
        }
        if ($request->hasFile('firma_operador')) {
            $data['firma_operador'] = $request->file('firma_operador')->store('firmas', 'public');
        }
        $data['usuario_id'] = Auth::id();
        $data['fecha_actualizacion'] = now();
        $operador->update($data);
        return redirect()->route('operadores.index')->with('success', 'Operador actualizado correctamente');
    }

    public function destroy(Operador $operador)
    {
        $operador->delete();
        return redirect()->route('operadores.index')->with('success', 'Operador eliminado correctamente');
    }
}

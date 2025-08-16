<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['usuario', 'asignado']);
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }
        $tickets = $query->orderByDesc('created_at')->paginate(10);
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        return view('tickets.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'nullable|in:nuevo,en_proceso,cerrado',
            'asignado_a' => 'nullable|exists:users,id',
        ]);
        $data['user_id'] = auth()->id();
        if (!auth()->user()->is_admin) {
            $data['estado'] = 'nuevo';
            $data['asignado_a'] = null;
        }
        Ticket::create($data);
        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['usuario', 'asignado']);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $usuarios = User::all();
        return view('tickets.edit', compact('ticket', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'nullable|in:nuevo,en_proceso,cerrado',
            'asignado_a' => 'nullable|exists:users,id',
        ]);
        if (!auth()->user()->is_admin) {
            unset($data['estado'], $data['asignado_a']);
        }
        $ticket->update($data);
        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado');
    }
}

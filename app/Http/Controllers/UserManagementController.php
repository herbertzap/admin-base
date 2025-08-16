<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Operador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = Auth::user();
        
        // Filtrar usuarios según permisos
        if ($currentUser->isSuperAdmin()) {
            $users = User::with('operador')->orderBy('name')->paginate(10);
        } elseif ($currentUser->isAdmin()) {
            $users = User::with('operador')->orderBy('name')->paginate(10);
        } else {
            // Usuario operador solo ve usuarios de su operador
            $users = User::with('operador')
                ->where('operador_id', $currentUser->operador_id)
                ->orderBy('name')
                ->paginate(10);
        }
        
        return view('user-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->canCreateUsers()) {
            return redirect()->route('user-management.index')
                ->with('error', 'No tienes permisos para crear usuarios.');
        }
        
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();
        $roles = Role::all();
        
        return view('user-management.create', compact('operadores', 'roles', 'currentUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->canCreateUsers()) {
            return redirect()->route('user-management.index')
                ->with('error', 'No tienes permisos para crear usuarios.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'rut_usuario' => 'nullable|string|max:20|unique:users,rut_usuario',
            'password' => 'required|string|min:8|confirmed',
            'operador_id' => 'nullable|exists:operadors,id',
            'estado' => 'required|in:Activo,Inactivo',
            'fotografia' => 'nullable|file|image|max:2048',
            'roles' => 'required|array',
        ]);
        
        // Verificar permisos para asignar roles
        $selectedRoles = $request->input('roles', []);
        if (!$currentUser->isSuperAdmin()) {
            // Solo super admin puede crear admin
            $adminRoles = ['admin', 'super-admin'];
            foreach ($selectedRoles as $role) {
                if (in_array($role, $adminRoles)) {
                    return redirect()->back()
                        ->with('error', 'Solo los super administradores pueden crear usuarios admin.')
                        ->withInput();
                }
            }
        }
        
        // Asignar operador automáticamente si el usuario actual es operador
        $operadorId = $request->input('operador_id');
        if (!$currentUser->isAdmin() && $currentUser->hasOperador()) {
            $operadorId = $currentUser->operador_id;
        }
        
        $data = $request->only([
            'name', 'email', 'rut_usuario', 'estado'
        ]);
        
        $data['password'] = Hash::make($request->password);
        $data['operador_id'] = $operadorId;
        $data['ultimo_movimiento'] = now();
        $data['fecha_renovacion_password'] = now()->addDays(365); // Renovar en 1 año
        
        // Manejo de fotografía
        if ($request->hasFile('fotografia')) {
            $data['fotografia'] = $request->file('fotografia')->store('fotografias', 'public');
        }
        
        $user = User::create($data);
        
        // Asignar roles
        $user->assignRole($selectedRoles);
        
        return redirect()->route('user-management.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $currentUser = Auth::user();
        
        // Verificar permisos para ver el usuario
        if (!$currentUser->canEditUsers() && $currentUser->id !== $user->id) {
            return redirect()->route('user-management.index')
                ->with('error', 'No tienes permisos para ver este usuario.');
        }
        
        return view('user-management.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $currentUser = Auth::user();
        
        // Verificar permisos para editar el usuario
        if (!$currentUser->canEditUsers() && $currentUser->id !== $user->id) {
            return redirect()->route('user-management.index')
                ->with('error', 'No tienes permisos para editar este usuario.');
        }
        
        $operadores = Operador::where('estado', 'Activo')->orderBy('nombre_operador')->get();
        $roles = Role::all();
        
        return view('user-management.edit', compact('user', 'operadores', 'roles', 'currentUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();
        
        // Verificar permisos para editar el usuario
        if (!$currentUser->canEditUsers() && $currentUser->id !== $user->id) {
            return redirect()->route('user-management.index')
                ->with('error', 'No tienes permisos para editar este usuario.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'rut_usuario' => 'nullable|string|max:20|unique:users,rut_usuario,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'operador_id' => 'nullable|exists:operadors,id',
            'estado' => 'required|in:Activo,Inactivo',
            'fotografia' => 'nullable|file|image|max:2048',
            'roles' => 'required|array',
        ]);
        
        // Verificar permisos para asignar roles
        $selectedRoles = $request->input('roles', []);
        if (!$currentUser->isSuperAdmin()) {
            // Solo super admin puede asignar roles admin
            $adminRoles = ['admin', 'super-admin'];
            foreach ($selectedRoles as $role) {
                if (in_array($role, $adminRoles)) {
                    return redirect()->back()
                        ->with('error', 'Solo los super administradores pueden asignar roles admin.')
                        ->withInput();
                }
            }
        }
        
        $data = $request->only([
            'name', 'email', 'rut_usuario', 'estado'
        ]);
        
        // Actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        // Asignar operador automáticamente si el usuario actual es operador
        if (!$currentUser->isAdmin() && $currentUser->hasOperador()) {
            $data['operador_id'] = $currentUser->operador_id;
        } else {
            $data['operador_id'] = $request->input('operador_id');
        }
        
        $data['ultimo_movimiento'] = now();
        
        // Manejo de fotografía
        if ($request->hasFile('fotografia')) {
            // Eliminar fotografía anterior si existe
            if ($user->fotografia) {
                Storage::disk('public')->delete($user->fotografia);
            }
            $data['fotografia'] = $request->file('fotografia')->store('fotografias', 'public');
        }
        
        $user->update($data);
        
        // Actualizar roles
        $user->syncRoles($selectedRoles);
        
        return redirect()->route('user-management.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        
        if (!$currentUser->canEditUsers()) {
            return redirect()->route('user-management.index')
                ->with('error', 'No tienes permisos para eliminar usuarios.');
        }
        
        // No permitir eliminar el propio usuario
        if ($currentUser->id === $user->id) {
            return redirect()->route('user-management.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }
        
        // Eliminar fotografía si existe
        if ($user->fotografia) {
            Storage::disk('public')->delete($user->fotografia);
        }
        
        $user->delete();
        
        return redirect()->route('user-management.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}

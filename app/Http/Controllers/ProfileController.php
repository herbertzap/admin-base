<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user profile form.
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Log para debugging
        Log::info('Profile update request', [
            'user_id' => $user->id,
            'has_password' => $request->filled('password'),
            'password_length' => $request->filled('password') ? strlen($request->password) : 0,
            'password_confirmed' => $request->filled('password_confirmation'),
        ]);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'rut_usuario' => 'nullable|string|max:20|unique:users,rut_usuario,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'fotografia' => 'nullable|file|image|max:2048',
        ]);
        
        $data = $request->only([
            'name', 'email', 'rut_usuario'
        ]);
        
        // Actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            Log::info('Password updated', ['user_id' => $user->id]);
        }
        
        // Actualizar último movimiento
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
        
        Log::info('Profile updated successfully', ['user_id' => $user->id]);
        
        return redirect()->route('profile')
            ->with('success', 'Perfil actualizado exitosamente.');
    }
}

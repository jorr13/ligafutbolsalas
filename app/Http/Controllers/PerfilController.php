<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PerfilController extends Controller
{
    /**
     * Mostrar el perfil del usuario autenticado
     */
    public function show()
    {
        $user = Auth::user();
        
        // Obtener datos adicionales según el rol
        $datosAdicionales = null;
        
        if ($user->rol_id == 'entrenador') {
            $datosAdicionales = \App\Models\Entrenadores::where('user_id', $user->id)->first();
        } elseif ($user->rol_id == 'arbitro') {
            $datosAdicionales = \App\Models\Arbitros::where('user_id', $user->id)->first();
        }
        
        return view('perfil.show', compact('user', 'datosAdicionales'));
    }

    /**
     * Mostrar formulario de edición del perfil
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Obtener datos adicionales según el rol
        $datosAdicionales = null;
        
        if ($user->rol_id == 'entrenador') {
            $datosAdicionales = \App\Models\Entrenadores::where('user_id', $user->id)->first();
        } elseif ($user->rol_id == 'arbitro') {
            $datosAdicionales = \App\Models\Arbitros::where('user_id', $user->id)->first();
        }
        
        return view('perfil.edit', compact('user', 'datosAdicionales'));
    }

    /**
     * Actualizar el perfil del usuario
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validar datos básicos del usuario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Actualizar datos básicos del usuario
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Actualizar datos adicionales según el rol
        if ($user->rol_id == 'entrenador') {
            $this->updateEntrenador($user, $request);
        } elseif ($user->rol_id == 'arbitro') {
            $this->updateArbitro($user, $request);
        }

        return redirect()->route('perfil.show')->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Actualizar datos del entrenador
     */
    private function updateEntrenador($user, $request)
    {
        $entrenador = \App\Models\Entrenadores::where('user_id', $user->id)->first();
        
        if ($entrenador) {
            $request->validate([
                'telefono' => 'nullable|string|max:20',
                'direccion' => 'nullable|string|max:500',
            ]);

            $entrenador->update([
                'nombre' => $request->name,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);
        }
    }

    /**
     * Actualizar datos del árbitro
     */
    private function updateArbitro($user, $request)
    {
        $arbitro = \App\Models\Arbitros::where('user_id', $user->id)->first();
        
        if ($arbitro) {
            $request->validate([
                'telefono' => 'nullable|string|max:20',
                'direccion' => 'nullable|string|max:500',
            ]);

            $arbitro->update([
                'nombre' => $request->name,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ]);
        }
    }
}

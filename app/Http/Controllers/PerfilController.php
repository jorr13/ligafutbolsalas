<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
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
                'foto_carnet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'foto_cedula' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'archivo_cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            $entrenadorData = [
                'nombre' => $request->name,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ];

            // Manejar foto_carnet
            if ($request->hasFile('foto_carnet')) {
                // Eliminar archivo anterior si existe
                if ($entrenador->foto_carnet && Storage::disk('storage')->exists($entrenador->foto_carnet)) {
                    Storage::disk('storage')->delete($entrenador->foto_carnet);
                }
                $fotoCarnetPath = Storage::disk('storage')->putFile('entrenadores/fotos_carnet', $request->file('foto_carnet'));
                $entrenadorData['foto_carnet'] = $fotoCarnetPath;
            }

            // Manejar foto_cedula
            if ($request->hasFile('foto_cedula')) {
                // Eliminar archivo anterior si existe
                if ($entrenador->foto_cedula && Storage::disk('storage')->exists($entrenador->foto_cedula)) {
                    Storage::disk('storage')->delete($entrenador->foto_cedula);
                }
                $fotoCedulaPath = Storage::disk('storage')->putFile('entrenadores/fotos_cedula', $request->file('foto_cedula'));
                $entrenadorData['foto_cedula'] = $fotoCedulaPath;
            }

            // Manejar archivo_cv
            if ($request->hasFile('archivo_cv')) {
                // Eliminar archivo anterior si existe
                if ($entrenador->archivo_cv && Storage::disk('storage')->exists($entrenador->archivo_cv)) {
                    Storage::disk('storage')->delete($entrenador->archivo_cv);
                }
                $archivoCvPath = Storage::disk('storage')->putFile('entrenadores/archivos_cv', $request->file('archivo_cv'));
                $entrenadorData['archivo_cv'] = $archivoCvPath;
            }

            $entrenador->update($entrenadorData);
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
                'foto_carnet' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'foto_cedula' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'archivo_cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            $arbitroData = [
                'nombre' => $request->name,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
            ];

            // Manejar foto_carnet
            if ($request->hasFile('foto_carnet')) {
                // Eliminar archivo anterior si existe
                if ($arbitro->foto_carnet && Storage::disk('storage')->exists($arbitro->foto_carnet)) {
                    Storage::disk('storage')->delete($arbitro->foto_carnet);
                }
                $fotoCarnetPath = Storage::disk('storage')->putFile('arbitros/fotos_carnet', $request->file('foto_carnet'));
                $arbitroData['foto_carnet'] = $fotoCarnetPath;
            }

            // Manejar foto_cedula
            if ($request->hasFile('foto_cedula')) {
                // Eliminar archivo anterior si existe
                if ($arbitro->foto_cedula && Storage::disk('storage')->exists($arbitro->foto_cedula)) {
                    Storage::disk('storage')->delete($arbitro->foto_cedula);
                }
                $fotoCedulaPath = Storage::disk('storage')->putFile('arbitros/fotos_cedula', $request->file('foto_cedula'));
                $arbitroData['foto_cedula'] = $fotoCedulaPath;
            }

            // Manejar archivo_cv
            if ($request->hasFile('archivo_cv')) {
                // Eliminar archivo anterior si existe
                if ($arbitro->archivo_cv && Storage::disk('storage')->exists($arbitro->archivo_cv)) {
                    Storage::disk('storage')->delete($arbitro->archivo_cv);
                }
                $archivoCvPath = Storage::disk('storage')->putFile('arbitros/archivos_cv', $request->file('archivo_cv'));
                $arbitroData['archivo_cv'] = $archivoCvPath;
            }

            $arbitro->update($arbitroData);
        }
    }
}

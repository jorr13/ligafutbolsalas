<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Entrenadores;
use App\Models\Clubes;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Builder\Builder;
 use Endroid\QrCode\Writer\PngWriter;
use App\Models\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Support\CedulaNumero;

class EntrenadoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entrenadores = Entrenadores::leftJoin('clubes', 'entrenadores.club_id', '=', 'clubes.id')
            ->select('entrenadores.*', 'clubes.nombre as nombre_club')
            ->paginate(10); // Paginación de 10 entrenadores por página
        // dd($entrenadores);

        return view('entrenadores.index', compact('entrenadores'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        return view('entrenadores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge(['cedula' => CedulaNumero::soloDigitosMax8($request->cedula ?? '')]);
        $request->validate([
            'cedula' => 'required|regex:/^\d{1,8}$/',
            'estatus' => 'required|in:activo,inactivo,sancionado',
            'fecha_fin_sancion' => 'nullable|date|required_if:estatus,sancionado',
        ], [
            'cedula.regex' => 'La cédula debe tener como máximo 8 dígitos numéricos, sin puntos.',
            'fecha_fin_sancion.required_if' => 'Indique la fecha final de la sanción.',
        ]);
        if ($request->estatus !== 'sancionado') {
            $request->merge(['fecha_fin_sancion' => null]);
        }

        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'rol_id' => 'entrenador',
            'password' => Hash::make($request->pass),
            'status' => 1,
        ]);

        // Cédula: tipo de documento + número (ej. V-24042654)
        $cedulaCompleta = ($request->tipo_identificacion ?? 'V') . '-' . preg_replace('/^[VEFP]-?/i', '', $request->cedula ?? '');

        $entrenadorData = [
            'nombre' => $request->nombre,
            'cedula' => $cedulaCompleta,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'user_id' => $user->id,
            'estatus' => $request->estatus,
            'fecha_fin_sancion' => $request->estatus === 'sancionado' ? $request->fecha_fin_sancion : null,
        ];

        // Manejar foto_carnet
        if ($request->hasFile('foto_carnet')) {
            $fotoCarnetPath = Storage::disk('storage')->putFile('entrenadores/fotos_carnet', $request->file('foto_carnet'));
            $entrenadorData['foto_carnet'] = $fotoCarnetPath;
        }

        // Manejar foto_cedula
        if ($request->hasFile('foto_cedula')) {
            $fotoCedulaPath = Storage::disk('storage')->putFile('entrenadores/fotos_cedula', $request->file('foto_cedula'));
            $entrenadorData['foto_cedula'] = $fotoCedulaPath;
        }

        // Manejar archivo_cv
        if ($request->hasFile('archivo_cv')) {
            $archivoCvPath = Storage::disk('storage')->putFile('entrenadores/archivos_cv', $request->file('archivo_cv'));
            $entrenadorData['archivo_cv'] = $archivoCvPath;
        }

        $entrenador = Entrenadores::create($entrenadorData);
        $entrenador->generarQRCode();

        return redirect()->route('entrenadores.index')->with('success', 'Entrenador creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Entrenadores $entrenadores)
    {
        return view('entrenadores.show', compact('entrenadores'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrenadores $entrenadores, $id)
    {
   
        $entrenadores = Entrenadores::where('id', $id)->first();
            // dd($entrenadores->id);
        return view('entrenadores.edit', compact('entrenadores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrenadores $entrenadores, $id)
    {
        $entrenador = Entrenadores::where('id', $id)->first();
        $user = User::where('id', $entrenador->user_id)->first();

        $nombreAntes = $entrenador->nombre;

        $request->merge(['cedula' => CedulaNumero::soloDigitosMax8($request->cedula ?? '')]);
        $request->validate([
            'cedula' => 'required|regex:/^\d{1,8}$/',
            'estatus' => 'required|in:activo,inactivo,sancionado',
            'fecha_fin_sancion' => 'nullable|date|required_if:estatus,sancionado',
        ], [
            'cedula.regex' => 'La cédula debe tener como máximo 8 dígitos numéricos, sin puntos.',
            'fecha_fin_sancion.required_if' => 'Indique la fecha final de la sanción.',
        ]);
        if ($request->estatus !== 'sancionado') {
            $request->merge(['fecha_fin_sancion' => null]);
        }
        
        $user->update([
            'name' => $request->nombre,
            'email' => $request->email,
        ]);

        // Cédula: tipo de documento + número (ej. V-24042654)
        $cedulaCompleta = ($request->tipo_identificacion ?? 'V') . '-' . preg_replace('/^[VEFP]-?/i', '', $request->cedula ?? '');

        $entrenadorData = [
            'nombre' => $request->nombre,
            'cedula' => $cedulaCompleta,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'estatus' => $request->estatus,
            'fecha_fin_sancion' => $request->estatus === 'sancionado' ? $request->fecha_fin_sancion : null,
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
        $entrenador->refresh();

        $attrs = $entrenador->getAttributes();
        $sinQr = empty($attrs['qr_code_image'] ?? null);
        $necesitaQr = ($entrenador->nombre !== $nombreAntes) || $sinQr;
        if ($necesitaQr) {
            if ($entrenador->nombre !== $nombreAntes) {
                $entrenador->eliminarArchivoQrEnDisco($nombreAntes);
            }
            $entrenador->generarQRCode();
        }

        return redirect()->route('entrenadores.index')->with('success', 'Entrenador editado exitosamente.');
    }

    /**
     * Perfil público del entrenador (escaneo QR del carnet).
     */
    public function mostrarPublico($id)
    {
        $entrenador = Entrenadores::with(['club'])->find($id);

        if (! $entrenador) {
            abort(404, 'Entrenador no encontrado');
        }

        if (! $entrenador->qr_perfil_publico) {
            return view('jugadores.perfil-restringido');
        }

        return view('entrenadores.publico', compact('entrenador'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrenadores $entrenadores, $id)
    {
        $entrenador = Entrenadores::where('id', $id)->first();
        $user = User::where('id', $entrenador->user_id)->first();
        
        // Eliminar archivos asociados
        if ($entrenador->foto_carnet && Storage::disk('storage')->exists($entrenador->foto_carnet)) {
            Storage::disk('storage')->delete($entrenador->foto_carnet);
        }
        if ($entrenador->foto_cedula && Storage::disk('storage')->exists($entrenador->foto_cedula)) {
            Storage::disk('storage')->delete($entrenador->foto_cedula);
        }
        if ($entrenador->archivo_cv && Storage::disk('storage')->exists($entrenador->archivo_cv)) {
            Storage::disk('storage')->delete($entrenador->archivo_cv);
        }

        $entrenador->eliminarArchivoQrEnDisco();

        $entrenador->delete();
        $user->delete();
    
        return redirect()->route('entrenadores.index')->with('success', 'Entrenador eliminado exitosamente.');
    }
}

<?php

namespace App\Http\Controllers;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Jugadores;
use App\Models\Entrenadores;
use App\Models\Arbitros;
use App\Models\Clubes;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jugadores = Jugadores::GetjugadoresPendingCount();

        $statsAdmin = null;
        if (auth()->user()->rol_id === 'administrador') {
            $statsAdmin = [
                'jugadores' => Jugadores::count(),
                'entrenadores' => Entrenadores::count(),
                'arbitros' => Arbitros::count(),
                'clubes' => Clubes::count(),
            ];
        }

        return view('home', compact('jugadores', 'statsAdmin'));
    }
    public function registerAdmin()
    {
        return view('auth.registeradmin');
    }
    public function createUser(Request $request)
    {
        // dd($request->rol_id);
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
            'password' => Hash::make($request->password),
        ]);
    }
}

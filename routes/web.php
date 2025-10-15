<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    // Route::resource('exhibiciones', App\Http\Controllers\ExhibicionController::class);
    // Route::resource('contenidos', App\Http\Controllers\ContenidoController::class);
    Route::resource('usuarios', App\Http\Controllers\UsuarioController::class);
    Route::resource('clubes', App\Http\Controllers\ClubController::class);
    Route::resource('categorias', App\Http\Controllers\CategoriasController::class);
    Route::resource('jugadores', App\Http\Controllers\JugadoresController::class);
    Route::resource('entrenadores', App\Http\Controllers\EntrenadoresController::class);
    Route::get('jugadores-pendientes', [App\Http\Controllers\JugadoresController::class, 'indexAdmin'])->name('jugadores.indexpendientes');
    Route::post('aceptar-jugador/{id}', [App\Http\Controllers\JugadoresController::class, 'aceptarJugador'])->name('jugadores.aceptar');
    Route::get('club-jugadores/{id}', [App\Http\Controllers\ClubController::class, 'verJugadores'])->name('clubes.getjugadores');
    Route::resource('arbitros', App\Http\Controllers\ArbitrosController::class);
    
    // Rutas para perfil de usuario
    Route::get('perfil', [App\Http\Controllers\PerfilController::class, 'show'])->name('perfil.show');
    Route::get('perfil/edit', [App\Http\Controllers\PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('perfil', [App\Http\Controllers\PerfilController::class, 'update'])->name('perfil.update');

    
    // Rutas para entrenadores (solo lectura de otros clubes)  
    Route::get('ver-clubes', [App\Http\Controllers\JugadoresController::class, 'verClub'])->name('entrenador.clubes.index');
    Route::get('ver-clubes/{clubId}/jugadores', [App\Http\Controllers\JugadoresController::class, 'verJugadoresClub'])->name('entrenador.clubes.jugadores');

    // Rutas para transferencias de jugadores (solo administradores)
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('jugadores/{id}/transferir', [App\Http\Controllers\TransferenciaController::class, 'showTransferForm'])->name('admin.jugadores.transferir');
        Route::post('jugadores/{id}/transferir', [App\Http\Controllers\TransferenciaController::class, 'transferirJugador'])->name('admin.jugadores.transferir.store');
        Route::get('jugadores/{id}/historial', [App\Http\Controllers\TransferenciaController::class, 'mostrarHistorial'])->name('admin.jugadores.historial');
        
        // Rutas para sistema de carnets
        Route::get('jugadores/{id}/carnet', [App\Http\Controllers\CarnetController::class, 'generar'])->name('jugadores.carnet');
        Route::get('jugadores/{id}/carnet/preview', [App\Http\Controllers\CarnetController::class, 'vistaPrevia'])->name('jugadores.carnet.preview');
    });

    // Rutas para historial de clubes
    Route::get('clubes/{id}/historial', [App\Http\Controllers\HistorialClubController::class, 'mostrarHistorial'])->name('clubes.historial');
    Route::get('clubes/historial/general', [App\Http\Controllers\HistorialClubController::class, 'mostrarHistorialGeneral'])->name('clubes.historial.general');
    Route::get('clubes/{id}/historial/exportar', [App\Http\Controllers\HistorialClubController::class, 'exportarHistorial'])->name('clubes.historial.exportar');
    Route::get('api/clubes/{id}/historial', [App\Http\Controllers\HistorialClubController::class, 'apiHistorial'])->name('api.clubes.historial');

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('clubes/asing/{id}', [App\Http\Controllers\ClubController::class, 'asingCategoria'])->name('clubes.asignar');
Route::put('clubes/asing/{id}', [App\Http\Controllers\ClubController::class, 'asingClubCategoria'])->name('clubes.creasignar');
Route::post('clubes/delete', [App\Http\Controllers\ClubController::class, 'deleteClubCategoria'])->name('clubes.deleteasignar');
Route::post('get-info', [App\Http\Controllers\JugadoresController::class, 'getJugador'])->name('jugadores.infoJugador');
Route::post('get-info-mio', [App\Http\Controllers\JugadoresController::class, 'getJugadorMio'])->name('jugadores.infoJugadorMio');
Route::post('filtrar-jugadores', [App\Http\Controllers\JugadoresController::class, 'filtrarJugadores'])->name('jugadores.filtrar');

// Ruta pública para mostrar datos del jugador por QR
Route::get('jugador/{id}', [App\Http\Controllers\JugadoresController::class, 'mostrarJugadorPublico'])->name('jugador.publico');
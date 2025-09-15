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
    return view('welcome');
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

    // Rutas para transferencias de jugadores (solo administradores)
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('jugadores/{id}/transferir', [App\Http\Controllers\TransferenciaController::class, 'showTransferForm'])->name('admin.jugadores.transferir');
        Route::post('jugadores/{id}/transferir', [App\Http\Controllers\TransferenciaController::class, 'transferirJugador'])->name('admin.jugadores.transferir.store');
        Route::get('jugadores/{id}/historial', [App\Http\Controllers\TransferenciaController::class, 'mostrarHistorial'])->name('admin.jugadores.historial');
    });

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('clubes/asing/{id}', [App\Http\Controllers\ClubController::class, 'asingCategoria'])->name('clubes.asignar');
Route::put('clubes/asing/{id}', [App\Http\Controllers\ClubController::class, 'asingClubCategoria'])->name('clubes.creasignar');
Route::post('clubes/delete', [App\Http\Controllers\ClubController::class, 'deleteClubCategoria'])->name('clubes.deleteasignar');
Route::post('get-info', [App\Http\Controllers\JugadoresController::class, 'getJugador'])->name('jugadores.infoJugador');
Route::post('filtrar-jugadores', [App\Http\Controllers\JugadoresController::class, 'filtrarJugadores'])->name('jugadores.filtrar');
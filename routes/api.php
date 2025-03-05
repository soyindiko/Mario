<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AlimentoCineController;
use App\Http\Controllers\AlimentoController;
use App\Http\Controllers\AlimentoVentaController;
use App\Http\Controllers\CineController;
use App\Http\Controllers\CinePeliculaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\SesionVentaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;

Route::controller(AdministradorController::class)->prefix('administradores')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(AlimentoCineController::class)->prefix('alimentos_cines')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(AlimentoController::class)->prefix('alimentos')->group(function () {
    Route::post('/alimentos_cines', 'joinAlimentosCines');
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(AlimentoVentaController::class)->prefix('alimentos_ventas')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(CineController::class)->prefix('cines')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(CinePeliculaController::class)->prefix('cines_peliculas')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(ClienteController::class)->prefix('clientes')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(OpinionController::class)->prefix('opiniones')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(PeliculaController::class)->prefix('peliculas')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(SalaController::class)->prefix('salas')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(SesionController::class)->prefix('sesiones')->group(function () {
    Route::get('/salas', 'joinSalas');
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
    Route::post('/peliculas/cines/search', 'joinPeliculasCinesSearch');
});

Route::controller(SesionVentaController::class)->prefix('sesiones_ventas')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

Route::controller(UsuarioController::class)->prefix('usuarios')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
    Route::post('/authentication', 'authentication');
});

Route::controller(VentaController::class)->prefix('ventas')->group(function () {
    Route::get('/full_detail', 'fullDetail');
    Route::get('/', 'list');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
    Route::post('/search', 'search');
    Route::post('/free_search', 'freeSearch');
});

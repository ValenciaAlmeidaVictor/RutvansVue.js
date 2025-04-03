<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoTarifaController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

use App\Http\Controllers\RolesController;
Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');

use App\Http\Controllers\PuntoVentaController;

Route::get('/punto-venta', [PuntoVentaController::class, 'index'])->name('punto-venta.index');

use App\Http\Controllers\UnitsTableController;

Route::get('/unidades', [UnitsTableController::class, 'index'])->name('unitsTable.index');
// routes/web.php
Route::get('/units/create', [UnitsTableController::class, 'create'])->name('unitsTable.create');


use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesPermissionsController;

Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
Route::get('/roles-permissions', [RolesPermissionsController::class, 'index'])->name('roles-permissions.index');

use App\Livewire\UnidadComponent;

//Route::get('/unidades', function () {
   // return view('Unidades.unidades');
//})->name('unidades.index'); //

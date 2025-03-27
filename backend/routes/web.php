<?php

use App\Http\Controllers\EXCELController;
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
Route::get('/tipos-tarifas', [TipoTarifaController::class, 'index'])->name('tipos-tarifas.index');

use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesPermissionsController;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\LocExpController;
use App\Http\Controllers\PDFController;

Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
Route::get('/roles-permissions', [RolesPermissionsController::class, 'index'])->name('roles-permissions.index');
Route::resource('localidades', LocalidadesController::class);

Route::get('exports/pdf/localidades', [PDFController::class, 'expLocalidades'])->name('exports.pdf.localidades');
Route::get('exports/excel/localidades', [EXCELController::class, 'localidades'])->name('exports.excel.localidades');
// Ruta para mostrar la tabla de localidades
Route::get('/localidades-exp', [LocExpController::class, 'index'])->name('localidades-exp.index');
Route::post('/localidades-exp/data', [LocExpController::class, 'getLocalidades'])->name('localidades-exp.data');
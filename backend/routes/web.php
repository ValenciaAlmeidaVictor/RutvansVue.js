<?php

use Illuminate\Support\Facades\Route;

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



use App\Livewire\VentaComponent;
use App\Livewire\LocalidadComponent;
use App\Livewire\HorarioComponent;

Route::get('/ventas', function () {
    return view('Ventas.ventas');
})->name('ventas.index');

Route::get('/ventas/data', [VentaComponent::class, 'getVentas'])->name('ventas.data');

Route::get('/tipotarifa', [TipoTarifaController::class, 'index'])->name('tipotarifa.index');


Route::get('/localidades', function () {
    return view('Localidades.localidades');
})->name('localidades.index');

Route::get('/horarios', function () {
    return view('Horarios.horarios');
})->name('horarios.index');

// Ruta para la tabla con DataTables ServerSide
// Route::get('/ventas/data', [VentaController::class, 'getVentas'])->name('ventas.data');

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
use App\Livewire\EnvioComponent;
use App\Livewire\UnidadComponent;
use App\Livewire\ConductorComponent;


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

Route::get('/unidades', function () {
    return view('Unidades.unidades');
})->name('unidades.index');

Route::get('/envios', function () {
    return view('Envios.envios');
})->name('envios.index');

Route::get('/conductores', function () {
    return view('Conductores.conductores');
})->name('conductores.index');

// Ruta para la tabla con DataTables ServerSide
// Route::get('/ventas/data', [VentaController::class, 'getVentas'])->name('ventas.data');

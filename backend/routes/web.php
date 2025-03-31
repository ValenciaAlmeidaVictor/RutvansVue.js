<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Livewire\VentaComponent;
use App\Livewire\LocalidadComponent;
use App\Livewire\HorarioComponent;
use App\Livewire\EnvioComponent;
use App\Livewire\UnidadComponent;
use App\Livewire\ConductorComponent;
use App\Livewire\TipoTarifaComponent;
use App\Livewire\DestinoIntermedioComponent;
use App\Livewire\RutaComponent;

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación y Dashboard
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Rutas del Chatbot
|--------------------------------------------------------------------------
*/

Route::post('/chatbot', [ChatbotController::class, 'handle'])->name('chatbot.handle');

/*
|--------------------------------------------------------------------------
| Rutas de Ventas
|--------------------------------------------------------------------------
*/

Route::prefix('ventas')->group(function () {
    Route::get('/', function () {
        return view('Ventas.ventas');
    })->name('ventas.index');

    Route::get('/data', [VentaComponent::class, 'getVentas'])->name('ventas.data');
});

/*
|--------------------------------------------------------------------------
| Rutas de Gestión de Datos (Livewire)
|--------------------------------------------------------------------------
*/

Route::prefix('gestion')->group(function () {
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

    Route::get('/tipos-tarifas', function () {
        return view('tipoTarifas.tipoTarifas');
    })->name('tipotarifas.index');

    Route::get('/destino-intermedio', function () {
        return view('Destino_intermedio.destino_intermedio');
    })->name('destino-intermedio.index');

    Route::get('/ruta', function () {
        return view('Ruta.ruta');
    })->name('ruta.index');
});

/*
|--------------------------------------------------------------------------
| Rutas de Tipo de Tarifa (Controlador)
|--------------------------------------------------------------------------
*/

Route::get('/tipotarifa', [TipoTarifaController::class, 'index'])->name('tipotarifa.index');
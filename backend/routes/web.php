<?php

use App\Http\Controllers\EXCELController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HorarioUnidadController;
// Ruta de cierre de sesión

Route::get('/logout', function () {
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    auth()->logout();
    return redirect('/');
})->name('logout');


//chatbot
Route::post('/chatbot', [ChatbotController::class, 'handle'])->name('chatbot.handle');
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/', function () {
    return redirect()->route('login');
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
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesPermissionsController;
use App\Http\Controllers\LocalidadesController;
use App\Http\Controllers\LocExpController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\TipoTarifaController;

Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
Route::get('/roles-permissions', [RolesPermissionsController::class, 'index'])->name('roles-permissions.index');
Route::resource('localidades', LocalidadesController::class);

Route::get('exports/pdf/localidades', [PDFController::class, 'expLocalidades'])->name('exports.pdf.localidades');
Route::get('exports/excel/localidades', [EXCELController::class, 'localidades'])->name('exports.excel.localidades');
// Ruta para mostrar la tabla de localidades
Route::get('/localidades-exp', [LocExpController::class, 'index'])->name('localidades-exp.index');
Route::post('/localidades-exp/data', [LocExpController::class, 'getLocalidades'])->name('localidades-exp.data');
Route::get('/exports/excel/localidades', [ExcelController::class, 'expLocalidades'])->name('exports.excel.localidades');



use App\Livewire\VentaComponent;
use App\Livewire\LocalidadComponent;
use App\Livewire\HorarioComponent;
use App\Livewire\EnvioComponent;
use App\Livewire\UnidadComponent;
use App\Livewire\ConductorComponent;
use App\Livewire\TipoTarifaComponent;
use App\Livewire\DestinoIntermedioComponent;
use App\Livewire\RutaComponent;


Route::get('/ventas', function () {
    return view('Ventas.ventas');
})->name('ventas.index');

Route::get('/ventas/data', [VentaComponent::class, 'getVentas'])->name('ventas.data');

Route::get('/tipotarifa', [TipoTarifaController::class, 'index'])->name('tipotarifa.index');


Route::get('/horario', function () {
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
// Ruta para la tabla con DataTables ServerSide
// Route::get('/ventas/data', [VentaController::class, 'getVentas'])->name('ventas.data');
//Ruta Full calendar
Route::get('/get-selectors', [HorarioUnidadController::class, 'getSelectors']);
Route::get('/horarios', [HorarioUnidadController::class, 'index']);
Route::post('/horarios', [HorarioUnidadController::class, 'store']);
Route::delete('/horarios/{id}', [HorarioUnidadController::class, 'destroy'])->name('horarios.destroy');
Route::put('/horarios/{id}', [HorarioUnidadController::class, 'update']);

//Fin Rutas del calendar

Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');

use App\Http\Controllers\PuntoVentaController;

Route::get('/punto-venta', [PuntoVentaController::class, 'index'])->name('punto-venta.index');

use App\Http\Controllers\UnitsTableController;

Route::get('/unidades', [UnitsTableController::class, 'index'])->name('unitsTable.index');
// routes/web.php
Route::get('/units/create', [UnitsTableController::class, 'create'])->name('unitsTable.create');




Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');
Route::get('/roles-permissions', [RolesPermissionsController::class, 'index'])->name('roles-permissions.index');



//Route::get('/unidades', function () {
   // return view('Unidades.unidades');
//})->name('unidades.index'); //

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\DetallesBoletos;
use App\Controllers\UnitScheduleController;
use App\Livewire\Usuarios;
use App\Livewire\ViajeComponent;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ver-usuarios', [Usuarios::class, 'getUsuariosApi'])->name('ver-usuarios');

Route::middleware('api')->group(function () {
    Route::prefix('viajes')->group(function () {
        Route::get('/', [ViajeComponent::class, 'index']);
        Route::get('/asientos/{routeUnitId}', [ViajeComponent::class, 'asientos']);
        Route::get('/tipos-tarifas', [ViajeComponent::class, 'tiposTarifas']);
        Route::get('/info/{routeUnitId}', [ViajeComponent::class, 'getViajeInfo']);
        Route::post('/tickets', [ViajeComponent::class, 'getTicket']);
    });
});

use App\Http\Controllers\AuthController;

// Ruta para iniciar sesión
Route::post('/auth/login', [AuthController::class, 'login']);

// Ruta para cerrar sesión
Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/list_Calendar/{id?}', [\App\Http\Controllers\UnitScheduleController::class,'inicio'])->name('dashboard');
Route::get('/list_Calendar/{campo}/{valor?}', [\App\Http\Controllers\UnitScheduleController::class,'buscar'])->name('dashboard');




//Route::get('/ventas/ticket/{id}', [VentaController::class, 'generarTicketPDF']);  // Ruta para descargar el ticket
//Route::get('/api/ventas', [VentaController::class, 'index']);  // Ruta para obtener todas las ventas
// routes/web.php o routes/api.php
// Ruta para obtener todas las ventas
// routes/api.php

use App\Http\Controllers\VentaController;

Route::get('ventas', [VentaController::class, 'index']);
Route::get('ventas/{id}/ticket', [VentaController::class, 'generatePDF']);

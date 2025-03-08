<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Boletos;
use App\Livewire\Usuarios;

Route::view('/usuarios', 'Usuarios.usuarios')->name('usuarios');
Route::view('/boletos', 'Boletos.boletos')->name('boletos');






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

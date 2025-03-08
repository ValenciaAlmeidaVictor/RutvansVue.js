<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/mostrar-boletos', 
    [\App\Livewire\Boletos::class, 'index']
)->name('mostrar-boleto');

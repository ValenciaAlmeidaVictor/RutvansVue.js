<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PuntoVentaController extends Controller
{
    public function index()
    {
        // No es necesario cargar las rutas aquí
        return view('punto-venta.index');
    }
}


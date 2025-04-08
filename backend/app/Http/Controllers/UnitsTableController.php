<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitsTableController extends Controller
{
    public function index()
    {
        // No es necesario cargar las rutas aquí
        return view('Unidades.unidades');
    }
}

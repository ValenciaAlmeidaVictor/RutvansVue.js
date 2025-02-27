<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipoTarifaController extends Controller
{
    public function index()
    {
        return view('tipos-tarifa.index'); // Vista donde se mostrará el componente Livewire
    }
}

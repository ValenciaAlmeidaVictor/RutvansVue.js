<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalidadesController extends Controller
{
    public function index()
    {
        return view('localidades.index'); // Vista donde se mostrará el componente Livewire
    }
}

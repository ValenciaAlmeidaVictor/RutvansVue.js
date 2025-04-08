<?php

namespace App\Livewire;

use App\Models\Route;
use Livewire\Component;

class PuntoVenta extends Component
{
    public $rutas; // Variable para almacenar las rutas

    public function mount()
    {
        // Cargar rutas con las relaciones de localidades
        $this->rutas = Route::with(['originLocality', 'destinationLocality'])->get(); // Cargar las localidades asociadas
    }

    public function render()
    {
        return view('livewire.punto-venta', [
            'rutas' => $this->rutas,
        ]);
    }
}

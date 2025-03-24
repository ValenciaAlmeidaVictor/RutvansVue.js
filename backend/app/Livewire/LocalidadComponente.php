<?php

namespace App\Livewire;

use Livewire\Component;

class LocalidadComponente extends Component
{
    public $latitude;
    public $longitude;

    protected $listeners = ['updateLocation'];

    public function updateLocation($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        // Puedes realizar lógica adicional, como guardar en la base de datos
    }

    public function render()
    {
        return view('livewire.localidad-componente');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Localidad;

class LocalidadComponente extends Component
{
    public $longitude;
    public $latitude;
    public $locality;
    public $street;
    public $postal_code;

    // Método para guardar en la base de datos
    public function saveLocation()
    {
        Localidad::create([
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'locality' => $this->locality,
            'street' => $this->street,
            'postal_code' => $this->postal_code,
        ]);
    }
    public function render()
    {
        return view('livewire.localidad-componente');
    }
}

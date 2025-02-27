<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoTarifa;

class TipoTarifaComponent extends Component
{
    public $TipoTarifa, $idTipoTarifa, $nombreTarifa, $porcentajeTarifa, $descripcion;
    public $modal = false;

    protected $rules = [
        'nombreTarifa' => 'required|string|max:255',
        'porcentajeTarifa' => 'required|numeric|min:0|max:100',
        'descripcion' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadTarifas();
    }

    public function index()
    {
        $TipoTarifa = TipoTarifa::all();
        $data = [
            'TipoTarifa' => $TipoTarifa,
            'datos' => 200
        ];
        // Retorna la respuesta en formato JSON
        return response()->json($data, 200);
    }


    public function loadTarifas()
    {
        $this->TipoTarifa = TipoTarifa::all();
    }

    public function create()
    {
        $this->resetInput();
        $this->modal = true;
    }

    public function store()
    {
        $this->validate();
        TipoTarifa::create([
            'nombreTarifa' => $this->nombreTarifa,
            'porcentajeTarifa' => $this->porcentajeTarifa,
            'descripcion' => $this->descripcion,
        ]);
        $this->loadTarifas();
        $this->closeModal();
    }

    public function edit($id)
    {
        $TipoTarifa = TipoTarifa::findOrFail($id);
        $this->idTipoTarifa = $TipoTarifa->idTipoTarifa;
        $this->nombreTarifa = $TipoTarifa->nombreTarifa;
        $this->porcentajeTarifa = $TipoTarifa->porcentajeTarifa;
        $this->descripcion = $TipoTarifa->descripcion;
        $this->modal = true;
    }

    public function update()
    {
        $this->validate();
        TipoTarifa::where('idTipoTarifa', $this->idTipoTarifa)->update([
            'nombreTarifa' => $this->nombreTarifa,
            'porcentajeTarifa' => $this->porcentajeTarifa,
            'descripcion' => $this->descripcion,
        ]);
        $this->loadTarifas();
        $this->closeModal();
    }

    public function delete($id)
    {
        TipoTarifa::findOrFail($id)->delete();
        $this->loadTarifas();
    }

    private function resetInput()
    {
        $this->nombreTarifa = '';
        $this->porcentajeTarifa = '';
        $this->descripcion = '';
        $this->idTipoTarifa = null;
    }

    public function closeModal()
    {
        $this->modal = false;
    }
}

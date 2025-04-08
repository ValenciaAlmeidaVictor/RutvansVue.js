<?php

// app/Http/Livewire/CreateUnitForm.php
// app/Http/Livewire/CreateUnitForm.php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Unit;
use Livewire\WithFileUploads;

class CreateUnitForm extends Component
{
    use WithFileUploads;

    public $plate, $capacitance, $brand, $model, $year, $image;
    public $updateMode = false;
    public $unitId;

    public function mount($unitId = null)
    {
        if ($unitId) {
            $this->updateMode = true;
            $unit = Unit::find($unitId);
            $this->unitId = $unitId;
            $this->plate = $unit->plate;
            $this->capacitance = $unit->capacitance;
            $this->brand = $unit->brand;
            $this->model = $unit->model;
            $this->year = $unit->year;
            $this->image = $unit->image; // Cargar la imagen actual
        }
    }

    public function store()
    {
        $this->validate([
            'plate' => 'required|string|max:255',
            'capacitance' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'image' => 'nullable|image|max:5024',
        ]);

        $unit = Unit::create([
            'plate' => $this->plate,
            'capacitance' => $this->capacitance,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'image' => $this->image ? $this->image->store('images/units', 'public') : null,
 // Guardar imagen en la ruta correcta
        ]);

        session()->flash('message', 'Unit created successfully!');
        return redirect()->route('unitsTable.index');
    }

    public function update()
    {
        $this->validate([
            'plate' => 'required|string|max:255',
            'capacitance' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'image' => 'nullable|image|max:5024',
        ]);

        $unit = Unit::find($this->unitId);
        $unit->update([
            'plate' => $this->plate,
            'capacitance' => $this->capacitance,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'image' => $this->image ? $this->image->store('images/units') : $unit->image, // Si hay imagen, guarda en la ruta correcta
        ]);

        session()->flash('message', 'Unit updated successfully!');
        return redirect()->route('unitsTable.index');
    }


    public function cancelEdit()
    {
        return redirect()->route('unitsTable.index');
    }

    public function render()
    {
        return view('livewire.create-unit-form');
    }
}


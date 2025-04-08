<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unit;
use Livewire\WithFileUploads;

class UnitsTable extends Component
{
    use WithFileUploads;

    public $units;
    public $selectedUnitId;
    public $plate, $capacitance, $brand, $model, $year, $image;
    public $isModalOpen = false;
    public $imagePreview = null;
    public $isCreateModalOpen = false;

    public function render()
    {
        $this->units = Unit::all();
        return view('livewire.units-table');
    }

    public function openModal($id)
    {
        $this->selectedUnitId = $id;
        $this->loadUnit($id);
        $this->isModalOpen = true;
    }

    public function openCreateModal()
    {
        $this->resetFields();
        $this->isCreateModalOpen = true;
    }

    public function store()
    {
        $this->validate([
            'plate' => 'required',
            'capacitance' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'image' => 'nullable|image|max:5024',
        ]);

        $imagePath = $this->image ? $this->image->store('units', 'public') : null;

        Unit::create([
            'plate' => $this->plate,
            'capacitance' => $this->capacitance,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Unit added successfully.');

        $this->isCreateModalOpen = false;
        $this->resetFields();
        $this->dispatch('refreshTable'); // Reemplazo de emit()
    }

    private function resetFields()
    {
        $this->plate = '';
        $this->capacitance = '';
        $this->brand = '';
        $this->model = '';
        $this->year = '';
        $this->image = null;
    }

    public function loadUnit($id)
    {
        $unit = Unit::find($id);
        if ($unit) {
            $this->plate = $unit->plate;
            $this->capacitance = $unit->capacitance;
            $this->brand = $unit->brand;
            $this->model = $unit->model;
            $this->year = $unit->year;
            $this->image = $unit->image;
            $this->imagePreview = $unit->image ? asset('storage/' . $unit->image) : null;
        }
    }

    public function updateUnit()
    {
        $this->validate([
            'plate' => 'required',
            'capacitance' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'image' => 'nullable|image|max:5024',
        ]);

        $unit = Unit::find($this->selectedUnitId);

        if ($unit) {
            $imagePath = $this->image ? $this->image->store('units', 'public') : $unit->image;

            $unit->update([
                'plate' => $this->plate,
                'capacitance' => $this->capacitance,
                'brand' => $this->brand,
                'model' => $this->model,
                'year' => $this->year,
                'image' => $imagePath,
            ]);

            session()->flash('message', 'Unit updated successfully!');
            $this->isModalOpen = false;
            $this->imagePreview = asset('storage/' . $imagePath);
            $this->dispatch('refreshTable'); // Reemplazo de emit()
        }
    }

    public function cancelEdit()
    {
        $this->reset();
        $this->isModalOpen = false;
    }

    public function delete($id)
    {
        $unit = Unit::find($id);
        if ($unit) {
            $unit->delete();
            session()->flash('message', 'Unit deleted successfully!');
            $this->dispatch('refreshTable'); // Reemplazo de emit()
        }
    }

    public function updatedImage()
    {
        if ($this->image) {
            $this->imagePreview = $this->image->temporaryUrl();
        }
    }
}

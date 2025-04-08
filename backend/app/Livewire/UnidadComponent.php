<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Unit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UnidadComponent extends Component
{
    use WithFileUploads;

    public $id, $plate, $capacitance, $brand, $model, $year, $unit_image, $oldImage;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = [
        'openUnidadModal' => 'loadUnidad',
        'openShowUnidadModal' => 'openShowModal',
        'borrarRegistro',
        'deleteUnidad',
        'showConfirmSave',
        'saveUnidad' => 'save'
    ];

    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);
    }

    public function loadUnidad($id)
    {
        $this->resetForm();
        $unidad = Unit::find($id);

        if ($unidad) {
            $this->id = $unidad->id;
            $this->plate = $unidad->plate;
            $this->capacitance = $unidad->capacitance;
            $this->brand = $unidad->brand;
            $this->model = $unidad->model;
            $this->year = $unidad->year;
            $this->oldImage = $unidad->unit_image; // Guarda la imagen actual
            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($id)
    {
        $unidad = Unit::find($id);
        if ($unidad) {
            $this->id = $unidad->id;
            $this->plate = $unidad->plate;
            $this->capacitance = $unidad->capacitance;
            $this->brand = $unidad->brand;
            $this->model = $unidad->model;
            $this->year = $unidad->year;
            $this->oldImage = $unidad->unit_image;
            $this->isShowMode = true;
            $this->isEditMode = false;
        }
        $this->dispatch('show-bootstrap-modal');
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        $this->reset(['id', 'plate', 'capacitance', 'brand', 'model', 'year', 'unit_image', 'oldImage', 'isEditMode', 'isShowMode']);
    }

    public function save()
    {
        // Convierte el año a string, como en tu código original
        $this->year = (string) $this->year;

        // Validación de los campos
        $this->validate([
            'plate' => 'required|string|max:255',
            'capacitance' => 'required|numeric',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'unit_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        if ($this->unit_image) {
            // Generar un nombre único para la imagen con la fecha y hora actual y agregar el prefijo 'units/'
            $imageName = 'units/' . now()->format('Y_m_d_His') . '.jpg'; // Guarda con el prefijo 'units/'

            // Guardar la imagen en el directorio 'units' dentro del almacenamiento público
            $this->unit_image->storeAs('units', basename($imageName), 'public'); // Usamos basename() para asegurarnos de que solo el nombre de archivo se pase

            // Eliminar la imagen anterior si existe
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
        } else {
            $imageName = $this->oldImage; // Si no hay nueva imagen, mantener la anterior
        }

        // Guardar o actualizar la unidad
        if ($this->isEditMode) {
            $unidad = Unit::findOrFail($this->id);
            $unidad->update([
                'plate' => $this->plate,
                'capacitance' => $this->capacitance,
                'brand' => $this->brand,
                'model' => $this->model,
                'year' => $this->year,
                'unit_image' => $imageName, // Guardar el nombre completo con 'units/' en la base de datos
            ]);
        } else {
            Unit::create([
                'plate' => $this->plate,
                'capacitance' => $this->capacitance,
                'brand' => $this->brand,
                'model' => $this->model,
                'year' => $this->year,
                'unit_image' => $imageName ?? null, // Guardar el nombre completo con 'units/' en la base de datos
            ]);
        }

        $this->dispatch('swalSuccessSave');
        $this->closeModal();
        $this->dispatch('Refresh')->to('unidades-table');
    }




    public function openCreateModal()
    {
        $this->resetForm();
        $this->dispatch('show-bootstrap-modal');
    }

    public function borrarRegistro($id)
    {
        Log::info("ID recibido en borrarRegistro: " . $id);
        if ($id) {
            $this->dispatch('swalConfirmDelete', ['id' => $id]);
        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    public function deleteUnidad($id)
    {
        $unidad = Unit::find($id);
        if ($unidad) {
            if ($unidad->unit_image) {
                Storage::disk('public')->delete($unidad->unit_image);
            }
            $unidad->delete();
            $this->dispatch('Refresh')->to('unidades-table');
            $this->dispatch('swalSuccess');
        } else {
            session()->flash('error', 'Unidad no encontrada.');
        }
    }

    public function render()
    {
        return view('Modales.modal-unidades');
    }
}

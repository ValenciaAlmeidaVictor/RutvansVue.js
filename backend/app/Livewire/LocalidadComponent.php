<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Localidad;
use Illuminate\Support\Facades\Log;

class LocalidadComponent extends Component
{
    public $localidadId, $name;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = [
        'openLocalidadModal' => 'loadLocalidad',
        'openShowLocalidadModal' => 'openShowModal',
        'borrarRegistro',
        'deleteLocalidad',
        'showConfirmSave',
        'saveLocalidad' => 'save'
    ];

    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);
    }

    public function loadLocalidad($localidadId)
    {
        $this->resetForm();
        $localidad = Localidad::find($localidadId);

        if ($localidad) {
            $this->name = $localidad->name;
            $this->localidadId = $localidad->id;
            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($localidadId)
    {
        $this->localidadId = $localidadId;
        $localidad = Localidad::find($localidadId);

        if ($localidad) {
            $this->name = $localidad->name;
            $this->isShowMode = true;
            $this->isEditMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'name', 'localidadId']);
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->localidadId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        return view('Modales.modal-localidad');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->isEditMode) {
            $localidad = Localidad::find($this->localidadId);

            if ($localidad) {
                $localidad->name = $this->name;
                $localidad->save();
                $this->dispatch('swalSuccessSave');
            }
        } else {
            Localidad::create(['name' => $this->name]);
            $this->dispatch('swalSuccessSave');
        }

        $this->closeModal();
        session()->flash('message', $this->isEditMode 
            ? 'Localidad actualizada correctamente.' 
            : 'Localidad creada correctamente.');
        $this->dispatch('Refresh')->to('localidades-table');
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->dispatch('show-bootstrap-modal');
    }

    // Método corregido para almacenar el ID y manejar la eliminación
    public function borrarRegistro($localidadId)
    {
        Log::info("ID recibido en borrarRegistro: " . $localidadId);

        if ($localidadId) {
            $this->localidadId = $localidadId;  // Asigna el ID al atributo del componente
            $this->dispatch('swalConfirmDelete', ['id' => $localidadId]);  // Despacha el evento de confirmación
            Log::info("ID Enviado a swalConfirm: " . $localidadId);
        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    // Método corregido para eliminar la localidad
    public function deleteLocalidad()
    {
        Log::info("ID recibido para eliminar la localidad: " . $this->localidadId);

        $localidad = Localidad::find($this->localidadId);
        if ($localidad) {
            $localidad->delete();
            $this->dispatch('Refresh')->to('localidades-table'); // Refresca la tabla
            $this->dispatch('swalSuccess');  // Despacha evento de éxito
            session()->flash('message', 'Localidad eliminada correctamente.');
        } else {
            session()->flash('error', 'Localidad no encontrada.');
        }
    }    
    public function index()
    {
        return response()->json(Localidad::all());
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoTarifa;
use Illuminate\Support\Facades\Log;

class TipoTarifaComponent extends Component
{
    public $tipoTarifaId, $name, $percentage, $description;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = [
        'openTipoTarifaModal' => 'loadTipoTarifa',
        'openShowTipoTarifaModal' => 'openShowModal',
        'borrarRegistro',
        'deleteTipoTarifa',
        'showConfirmSave',
        'saveTipoTarifa' => 'save'
    ];

    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);
    }

    public function loadTipoTarifa($tipoTarifaId)
    {
        $this->resetForm();
        $tipoTarifa = TipoTarifa::find($tipoTarifaId);

        if ($tipoTarifa) {
            $this->name = $tipoTarifa->name;
            $this->percentage = $tipoTarifa->percentage;
            $this->description = $tipoTarifa->description;
            $this->tipoTarifaId = $tipoTarifa->id;
            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($tipoTarifaId)
    {
        $this->tipoTarifaId = $tipoTarifaId;
        $tipoTarifa = TipoTarifa::find($tipoTarifaId);

        if ($tipoTarifa) {
            $this->name = $tipoTarifa->name;
            $this->percentage = $tipoTarifa->percentage;
            $this->description = $tipoTarifa->description;
            $this->isShowMode = true;
            $this->isEditMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'name', 'percentage', 'description', 'tipoTarifaId']);
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->percentage = '';
        $this->description = '';
        $this->tipoTarifaId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        return view('Modales.modal-tipo-tarifa'); 
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        if ($this->isEditMode) {
            $tipoTarifa = TipoTarifa::find($this->tipoTarifaId);

            if ($tipoTarifa) {
                $tipoTarifa->name = $this->name;
                $tipoTarifa->percentage = $this->percentage;
                $tipoTarifa->description = $this->description;
                $tipoTarifa->save();
                $this->dispatch('swalSuccessSave');
            }
        } else {
            TipoTarifa::create([
                'name' => $this->name,
                'percentage' => $this->percentage,
                'description' => $this->description,
            ]);
            $this->dispatch('swalSuccessSave');
        }

        $this->closeModal();
        session()->flash('message', $this->isEditMode
            ? 'Tipo de tarifa actualizado correctamente.'
            : 'Tipo de tarifa creado correctamente.');
        $this->dispatch('Refresh')->to('tipo-tarifas-table'); 
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->dispatch('show-bootstrap-modal');
    }

    public function borrarRegistro($tipoTarifaId)
    {
        Log::info("ID recibido en borrarRegistro: " . $tipoTarifaId);

        if ($tipoTarifaId) {
            $this->tipoTarifaId = $tipoTarifaId;
            $this->dispatch('swalConfirmDelete', ['id' => $tipoTarifaId]);
            Log::info("ID Enviado a swalConfirm: " . $tipoTarifaId);
        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    public function deleteTipoTarifa()
    {
        Log::info("ID recibido para eliminar el tipo de tarifa: " . $this->tipoTarifaId);

        $tipoTarifa = TipoTarifa::find($this->tipoTarifaId);
        if ($tipoTarifa) {
            $tipoTarifa->delete();
            $this->dispatch('Refresh')->to('tipo-tarifas-table');
            $this->dispatch('swalSuccess');
            session()->flash('message', 'Tipo de tarifa eliminado correctamente.');
        } else {
            session()->flash('error', 'Tipo de tarifa no encontrado.');
        }
    }

    public function index()
    {
        return response()->json(TipoTarifa::all());
    }
}
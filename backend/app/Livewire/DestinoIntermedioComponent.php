<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DestinoIntermedio;
use App\Models\Ruta;
use Illuminate\Support\Facades\Log;

class DestinoIntermedioComponent extends Component
{
    public $destinoIntermedioId, $name, $route_id;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = [
        'openDestinoIntermedioModal' => 'loadDestinoIntermedio',
        'openShowDestinoIntermedioModal' => 'openShowModal',
        'borrarRegistro',
        'deleteDestinoIntermedio',
        'showConfirmSave',
        'saveDestinoIntermedio' => 'save'
    ];

    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);
    }

    public function loadDestinoIntermedio($destinoIntermedioId)
    {
        $this->resetForm();
        $destinoIntermedio = DestinoIntermedio::find($destinoIntermedioId);

        if ($destinoIntermedio) {
            $this->name = $destinoIntermedio->name;
            $this->route_id = $destinoIntermedio->route_id;
            $this->destinoIntermedioId = $destinoIntermedio->id;
            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($destinoIntermedioId)
    {
        $this->destinoIntermedioId = $destinoIntermedioId;
        $destinoIntermedio = DestinoIntermedio::find($destinoIntermedioId);

        if ($destinoIntermedio) {
            $this->name = $destinoIntermedio->name;
            $this->route_id = $destinoIntermedio->route_id;
            $this->isShowMode = true;
            $this->isEditMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'name', 'route_id', 'destinoIntermedioId']);
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->route_id = null;
        $this->destinoIntermedioId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        $rutas = Ruta::all();
        $this->dispatch('contentChanged'); // Corrected line
        return view('Modales.modal-destino-intermedio', compact('rutas'));
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'route_id' => 'required|integer',
        ]);

        if ($this->isEditMode) {
            $destinoIntermedio = DestinoIntermedio::find($this->destinoIntermedioId);

            if ($destinoIntermedio) {
                $destinoIntermedio->name = $this->name;
                $destinoIntermedio->route_id = $this->route_id;
                $destinoIntermedio->save();
                $this->dispatch('swalSuccessSave');
            }
        } else {
            DestinoIntermedio::create([
                'name' => $this->name,
                'route_id' => $this->route_id,
            ]);
            $this->dispatch('swalSuccessSave');
        }

        $this->closeModal();
        session()->flash('message', $this->isEditMode
            ? 'Destino Intermedio actualizado correctamente.'
            : 'Destino Intermedio creado correctamente.');
        $this->dispatch('Refresh')->to('destino-intermedio-table');
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->dispatch('show-bootstrap-modal');
    }

    public function borrarRegistro($destinoIntermedioId)
    {
        Log::info("ID recibido en borrarRegistro: " . $destinoIntermedioId);

        if ($destinoIntermedioId) {
            $this->destinoIntermedioId = $destinoIntermedioId;
            $this->dispatch('swalConfirmDelete', ['id' => $destinoIntermedioId]);
            Log::info("ID Enviado a swalConfirm: " . $destinoIntermedioId);
        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    public function deleteDestinoIntermedio()
    {
        Log::info("ID recibido para eliminar el destino intermedio: " . $this->destinoIntermedioId);

        $destinoIntermedio = DestinoIntermedio::find($this->destinoIntermedioId);
        if ($destinoIntermedio) {
            $destinoIntermedio->delete();
            $this->dispatch('Refresh')->to('destino-intermedio-table');
            $this->dispatch('swalSuccess');
            session()->flash('message', 'Destino Intermedio eliminado correctamente.');
        } else {
            session()->flash('error', 'Destino Intermedio no encontrado.');
        }
    }

    public function index()
    {
        return response()->json(DestinoIntermedio::all());
    }
}
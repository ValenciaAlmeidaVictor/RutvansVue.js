<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ruta;
use App\Models\Localidad; // Asegúrate de importar el modelo Localidad
use Illuminate\Support\Facades\Log;

class RutaComponent extends Component
{
    public $rutaId, $fare_id, $origin_locality_id, $destination_locality_id, $nombre; // Añadido $nombre
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = [
        'openRutaModal' => 'loadRuta',
        'openShowRutaModal' => 'openShowModal',
        'borrarRegistro',
        'deleteRuta',
        'showConfirmSave',
        'saveRuta' => 'save'
    ];

    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);
    }

    public function loadRuta($rutaId)
    {
        $this->resetForm();
        $ruta = Ruta::find($rutaId);

        if ($ruta) {
            $this->fare_id = $ruta->fare_id;
            $this->origin_locality_id = $ruta->origin_locality_id;
            $this->destination_locality_id = $ruta->destination_locality_id;
            $this->nombre = $ruta->nombre; // Añadido
            $this->rutaId = $ruta->id;
            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($rutaId)
    {
        $this->rutaId = $rutaId;
        $ruta = Ruta::find($rutaId);

        if ($ruta) {
            $this->fare_id = $ruta->fare_id;
            $this->origin_locality_id = $ruta->origin_locality_id;
            $this->destination_locality_id = $ruta->destination_locality_id;
            $this->nombre = $ruta->nombre; // Añadido
            $this->isShowMode = true;
            $this->isEditMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'fare_id', 'origin_locality_id', 'destination_locality_id', 'nombre', 'rutaId']); // Añadido 'nombre'
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        $this->fare_id = null;
        $this->origin_locality_id = null;
        $this->destination_locality_id = null;
        $this->nombre = ''; // Añadido
        $this->rutaId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        $localidades = Localidad::all(); // Cargar localidades para los selects
        return view('Modales.modal-ruta', compact('localidades'));
    }

    public function save()
    {
        $this->validate([
            'fare_id' => 'required|integer',
            'origin_locality_id' => 'required|integer',
            'destination_locality_id' => 'required|integer',
            'nombre' => 'required|string|max:255', // Añadido
        ]);

        if ($this->isEditMode) {
            $ruta = Ruta::find($this->rutaId);

            if ($ruta) {
                $ruta->fare_id = $this->fare_id;
                $ruta->origin_locality_id = $this->origin_locality_id;
                $ruta->destination_locality_id = $this->destination_locality_id;
                $ruta->nombre = $this->nombre; // Añadido
                $ruta->save();
                $this->dispatch('swalSuccessSave');
            }
        } else {
            Ruta::create([
                'fare_id' => $this->fare_id,
                'origin_locality_id' => $this->origin_locality_id,
                'destination_locality_id' => $this->destination_locality_id,
                'nombre' => $this->nombre, // Añadido
            ]);
            $this->dispatch('swalSuccessSave');
        }

        $this->closeModal();
        session()->flash('message', $this->isEditMode
            ? 'Ruta actualizada correctamente.'
            : 'Ruta creada correctamente.');
        $this->dispatch('Refresh')->to('rutas-table');
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->dispatch('show-bootstrap-modal');
    }

    public function borrarRegistro($rutaId)
    {
        Log::info("ID recibido en borrarRegistro: " . $rutaId);

        if ($rutaId) {
            $this->rutaId = $rutaId;
            $this->dispatch('swalConfirmDelete', ['id' => $rutaId]);
            Log::info("ID Enviado a swalConfirm: " . $rutaId);
        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    public function deleteRuta()
    {
        Log::info("ID recibido para eliminar la ruta: " . $this->rutaId);

        $ruta = Ruta::find($this->rutaId);
        if ($ruta) {
            $ruta->delete();
            $this->dispatch('Refresh')->to('rutas-table');
            $this->dispatch('swalSuccess');
            session()->flash('message', 'Ruta eliminada correctamente.');
        } else {
            session()->flash('error', 'Ruta no encontrada.');
        }
    }

    public function index()
    {
        return response()->json(Ruta::all());
    }
}
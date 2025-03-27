<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conductor;
use App\Models\Horario; // Modelo para los horarios
use App\Models\RutaUnidad; // Modelo para las rutas de unidades
use Illuminate\Support\Facades\Log;

class ConductorComponent extends Component
{
    public $id, $name, $id_RouteUnit, $id_Schedules;
    public $schedules, $routeUnits;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = ['openConductorModal' => 'loadConductor',
    'openShowConductorModal'=> 'openShowModal',
    'borrarRegistro',
    'deleteConductor',
    'showConfirmSave',
    'saveConductor' => 'save'];

    // Método para cargar los horarios y rutas de unidades
    public function mount()
    {
        // Cargar horarios y rutas de unidades desde la base de datos
        $this->schedules = Horario::all(); // Asumiendo que tienes un modelo Horario
        $this->routeUnits = RutaUnidad::all(); // Asumiendo que tienes un modelo RutaUnidad
    }

    // Métodos de componente (sin cambios)
    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);  // Disparamos el evento swalConfirm con el estado
    }

    public function loadConductor($id)
    {
        $this->resetForm();
        $conductor = Conductor::find($id);

        if ($conductor) {
            $this->name = $conductor->name;
            $this->id_RouteUnit = $conductor->id_RouteUnit;
            $this->id_Schedules = $conductor->id_Schedules;

            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        // Enviar evento a JavaScript para abrir el modal de Bootstrap
        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($id)
    {
        $this->id = $id;
        $conductor = Conductor::find($id); 
        $this->name = $conductor->name;
        $this->id_RouteUnit = $conductor->id_RouteUnit;
        $this->id_Schedules = $conductor->id_Schedules;
        
        $this->isShowMode = true; // Activa el modo de visualización
        $this->isEditMode = false; // Desactiva el modo de edición
        $this->dispatch('show-bootstrap-modal'); // Abre el modal
    }

    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'name', 'id_RouteUnit', 'id_Schedules', 'id']);
        // Enviar evento a JavaScript para cerrar el modal de Bootstrap
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->id_RouteUnit = '';
        $this->id_Schedules = '';
        $this->id = null;
        $this->isEditMode = false;
    }

    // Método para guardar o actualizar el conductor
    public function save()
    {
        // Validar los datos antes de guardarlos
        $this->validate([
            'name' => 'required|string|max:255',
            'id_RouteUnit' => 'required|numeric',
            'id_Schedules' => 'required|numeric',
        ]);

        if ($this->isEditMode) {
            $conductor = Conductor::find($this->id); // Usamos $this->id que se debe haber asignado previamente
            if ($conductor) {
                $conductor->name = $this->name;
                $conductor->id_RouteUnit = $this->id_RouteUnit;
                $conductor->id_Schedules = $this->id_Schedules;
                $conductor->save(); // Guarda los cambios
                $this->dispatch('swalSuccessSave');
            }
        } else {
            Conductor::create([
                'name' => $this->name,
                'id_RouteUnit' => $this->id_RouteUnit,
                'id_Schedules' => $this->id_Schedules,
            ]);
            $this->dispatch('swalSuccessSave');
        }

        // Cerrar el modal
        $this->closeModal();
        session()->flash('message', $this->isEditMode ? 'Conductor actualizado correctamente.' : 'Conductor creado correctamente.');
        $this->dispatch('Refresh')->to('conductores-table');
    }

    public function openCreateModal()
    {
        $this->resetForm(); // Resetea el formulario
        $this->isEditMode = false; // Establece el modo de creación
        $this->dispatch('show-bootstrap-modal'); // Muestra el modal
    }

    public function showModal($id): void
    {
        $conductor = Conductor::find($id);
        if ($conductor) {
            $this->dispatch('openShowConductorModal', $conductor);  // Dispatch para abrir un modal con detalles
        }
    }

    public function borrarRegistro($id)
    {
        Log::info("ID recibido en borrarRegistro: " . $id);  // Aquí recibimos el ID desde el array

        if ($id) {
            $this->dispatch('swalConfirmDelete', ['id' => $id]);
            Log::info("ID Enviado a swalConfirm: " . $id);
        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    public function deleteConductor($id)
    {
        $conductor = Conductor::find($id);
        if ($conductor) {
            $conductor->delete();
            $this->dispatch('Refresh')->to('conductores-table');
            $this->dispatch('swalSuccess');
            session()->flash('message', 'Conductor eliminado correctamente.');
        } else {
            session()->flash('error', 'Conductor no encontrado.');
        }
    }

    public function render()
    {
        return view('Modales.modal-conductores', [
            'schedules' => $this->schedules,
            'routeUnits' => $this->routeUnits
        ]);
    }
}

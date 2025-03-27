<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unidad;
use Illuminate\Support\Facades\Log;

class UnidadComponent extends Component
{

    public $id, $plate, $capacitance, $brand, $model, $year;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = ['openUnidadModal' => 'loadUnidad',
    'openShowUnidadModal'=> 'openShowModal',
    'borrarRegistro',
    'deleteUnidad',
    'showConfirmSave',
    'saveUnidad' => 'save'];

    //Metodos de componente

    //Modificaciones opcionales
    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);  // Disparamos el evento swalConfirm con el estado
    }


    public function loadUnidad($id)
    {
        $this->resetForm();
        $unidad = Unidad::find($id);

        if ($unidad) {
            $this->plate = $unidad->plate;
            $this->capacitance = $unidad->capacitance;
            $this->brand = $unidad->brand;
            $this->model = $unidad->model;
            $this->year = $unidad->year;
              
            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        // Enviar evento a JavaScript para abrir el modal de Bootstrap
        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($id)
    {
        $this->id = $id;
        $unidad = Unidad::find($id); 
        $this->plate = $unidad->plate;
        $this->capacitance = $unidad->capacitance;
        $this->brand = $unidad->brand;
        $this->model = $unidad->model;
        $this->year = $unidad->year;
        $this->isShowMode = true; // Activa el modo de visualización
        $this->isEditMode = false; // Desactiva el modo de edición
        $this->dispatch('show-bootstrap-modal'); // Abre el modal
    }


    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'plate', 'capacitance', 'brand', 'id', 'model', 'year']);
        // Enviar evento a JavaScript para cerrar el modal de Bootstrap
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {

        $this->plate = '';
        $this->capacitance = '';
        $this->brand = '';
        $this->model = '';
        $this->year = '';
        
        $this->id = null;
        $this->isEditMode = false;
    }

    //Modificaciones opcionales
    public function resetModalVariables()
    {
        $this->isEditMode = false;
        $this->isShowMode = false;
        $this->resetFields();
    }

        public function save()
        {
            // Validar los datos antes de guardarlos
            $this->validate([
                'plate' => 'required|string|max:255',
                'capacitance' => 'required|numeric',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'year'  => 'required|string|max:255',

                // Agregar las validaciones que necesites
            ]);


            if ($this->isEditMode) {
                $unidad = Unidad::find($this->id); // Usamos $this->id que se debe haber asignado previamente

                if ($unidad) {

                    $unidad->plate = $this->plate;
                    $unidad->capacitance = $this->capacitance;
                    $unidad->brand = $this->brand;
                    $unidad->model = $this->model; 
                    $unidad->year = $this->year; 
                    $unidad->save(); // Guarda los cambios

                    $this->dispatch('swalSuccessSave');
                }
            }  else {
                
                Unidad::create([
                    'plate' => $this->plate,
                    'capacitance' => $this->capacitance,
                    'brand' => $this->brand,
                    'model' => $this->model,
                    'year' => $this->year,
                    
                ]);

                $this->dispatch('swalSuccessSave');
            }

            // Cerrar el modal
            $this->closeModal();

            // Redirigir o actualizar la vista según sea necesario
            session()->flash('message', $this->isEditMode ? 'Unidad actualizada correctamente.' : 'Unidad creada correctamente.');
            $this->dispatch('Refresh')->to('unidades-table');
        }

        //Modificaciones opcionales
        public function openCreateModal()
        {
            $this->resetForm(); // Resetea el formulario
            $this->isEditMode = false; // Establece el modo de creación
            $this->dispatch('show-bootstrap-modal'); // Muestra el modal
        }


    public function showModal($id): void
    {
        
        $unidad = Unidad::find($id);
        if ($unidad) {
            // Aquí puedes enviar los detalles al modal o a donde lo necesites
            $this->dispatch('openShowUnidadModal', $unidad);  // Dispatch para abrir un modal con detalles
        }
    }

    //Modificaciones opcionales
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

    // Método para eliminar
    public function deleteUnidad($id)
    {
        // Log::info("ID recibido para eliminar la unidad: " . $id);

        $unidad = Unidad::find($id);
        if ($unidad) {
            $unidad->delete();
            $this->dispatch('Refresh')->to('unidades-table');
            $this->dispatch('swalSuccess');
            session()->flash('message', 'Unidad eliminada correctamente.');
        } else {
            session()->flash('error', 'Unidad no encontrada.');
        }
    }


    public function render()
    {
        return view('Modales.modal-unidades');
    }
}
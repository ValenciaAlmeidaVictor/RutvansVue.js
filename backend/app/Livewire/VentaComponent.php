<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Venta;
use Illuminate\Support\Facades\Log;

class VentaComponent extends Component
{
    public $id, $folio, $date, $cost, $user_id, $origin_id, $state_id, $method_id;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = ['openVentaModal' => 'loadVenta',
    'openShowVentaModal'=> 'openShowModal',
    'borrarRegistro',
    'deleteVenta',
    'showConfirmSave',
    'saveVenta' => 'save'];

        public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);  // Disparamos el evento swalConfirm con el estado
    }


    public function loadVenta($id)
    {
        $this->resetForm();
        $venta = Venta::find($id);

        if ($venta) {
            $this->folio = $venta->folio;
            $this->date = $venta->date;
            $this->cost = $venta->cost;
            $this->user_id = $venta->user_id;
            $this->origin_id = $venta->origin_id;
            $this->state_id = $venta->state_id;
            $this->method_id = $venta->method_id;
            $this->id = $venta->id;
            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        // Enviar evento a JavaScript para abrir el modal de Bootstrap
        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($id)
    {
        $this->id = $id;
        $venta = Venta::find($id); // Obtén los datos de la venta desde la base de datos
        $this->folio = $venta->folio;
        $this->date = $venta->date;
        $this->cost = $venta->cost;
        $this->user_id = $venta->user_id;
        $this->origin_id = $venta->origin_id;
        $this->state_id = $venta->state_id;
        $this->method_id = $venta->method_id;
        $this->isShowMode = true; // Activa el modo de visualización
        $this->isEditMode = false; // Desactiva el modo de edición
        $this->dispatch('show-bootstrap-modal'); // Abre el modal
    }


    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'folio', 'date', 'cost', 'id']);
        // Enviar evento a JavaScript para cerrar el modal de Bootstrap
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        $this->folio = '';
        $this->date = '';
        $this->cost = '';
        $this->user_id = '';
        $this->origin_id = '';
        $this->state_id = '';
        $this->method_id = '';
        $this->id = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        return view('Modales.modal-ventas');
    }

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
                'folio' => 'required|string|max:255',
                'date' => 'required|date',
                'cost' => 'required|numeric',
                // Agregar las validaciones que necesites
            ]);

            // Si es modo de edición, actualiza la venta existente
            if ($this->isEditMode) {
                $venta = Venta::find($this->id); // Usamos $this->id que se debe haber asignado previamente

                if ($venta) {
                    $venta->folio = $this->folio;
                    $venta->date = $this->date;
                    $venta->cost = $this->cost;
                    $venta->user_id = $this->user_id; // Asignamos el user_id correctamente
                    $venta->origin_id = $this->origin_id; // Asegúrate de que $origin_id esté definido
                    $venta->state_id = $this->state_id; // Asegúrate de que $state_id esté definido
                    $venta->method_id = $this->method_id;
                    $venta->save(); // Guarda los cambios

                    $this->dispatch('swalSuccessSave');
                }
            }  else {
                // Si no es modo de edición, crea una nueva venta
                Venta::create([
                    'folio' => $this->folio,
                    'date' => $this->date,
                    'cost' => $this->cost,
                    'user_id' => $this->user_id,
                    'origin_id' => $this->origin_id,
                    'state_id' => $this->state_id,
                    'method_id' => $this->method_id,
                ]);

                $this->dispatch('swalSuccessSave');
            }

            // Cerrar el modal
            $this->closeModal();

            // Redirigir o actualizar la vista según sea necesario
            session()->flash('message', $this->isEditMode 
            ? 'Venta actualizada correctamente.'
            : 'Venta creada correctamente.');
            $this->dispatch('Refresh')->to('ventas-table');
        }

        public function openCreateModal()
    {
        $this->resetForm(); // Resetea el formulario para una nueva venta
        $this->isEditMode = false; // Establece el modo de creación
        $this->dispatch('show-bootstrap-modal'); // Muestra el modal
    }


    public function showModal($id): void
    {
        // Lógica para obtener los detalles de la venta (puedes personalizar los detalles que deseas mostrar)
        $venta = Venta::find($id);
        if ($venta) {
            // Aquí puedes enviar los detalles al modal o a donde lo necesites
            $this->dispatch('openShowVentaModal', $venta);  // Dispatch para abrir un modal con detalles
        }
    }





             // Método para manejar el evento 'borrarRegistro'

                     // Método para manejar el evento 'borrarRegistro'
    public function borrarRegistro($id)
    {
        // Verificar si $data es un array y obtener el id
        // $id = isset($data['id']) ? $data['id'] : null;

        Log::info("ID recibido en borrarRegistro: " . $id);  // Aquí recibimos el ID desde el array

        // Luego, puedes proceder a realizar la lógica que deseas con el ID recibido
        // Por ejemplo, ejecutar el proceso de eliminación
        if ($id) {
            // $this->deleteVenta($id);
            // $this->dispatch('swalConfirm', $id);
            $this->dispatch('swalConfirmDelete', ['id' => $id]);
            Log::info("ID Enviado a swalConfirm: " . $id);

        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    // Método para eliminar la venta
    public function deleteVenta($id)
    {
        Log::info("ID recibido para eliminar la venta: " . $id);

        // Aquí va la lógica para eliminar la venta
        $venta = Venta::find($id);
        if ($venta) {
            $venta->delete();
            $this->dispatch('Refresh')->to('ventas-table');
            $this->dispatch('swalSuccess');
            session()->flash('message', 'Venta eliminada correctamente.');
        } else {
            session()->flash('error', 'Venta no encontrada.');
        }
    }

}
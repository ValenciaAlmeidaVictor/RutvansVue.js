<?php


namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Envio;

class EnvioComponent extends Component
{
    public $id, $sender_name, $receiver_name, $total, $photo, $description, $route_unit_id, $schedule_id, $route_id;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = ['openEnvioModal' => 'loadEnvio', 'openShowEnvioModal'=> 'openShowModal', 'borrarRegistro', 'deleteEnvio', 'showConfirmSave', 'saveEnvio' => 'save'];

    //Métodos de componente

    // Confirmar guardado
    public function showConfirmSave($isEditMode)
    {
        Log::info("showConfirmSave llamado. Modo de edición: " . ($isEditMode ? "Sí" : "No"));
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);  // Disparamos el evento swalConfirm con el estado
    }

    // Cargar envío
    public function loadEnvio($id)
    {
        Log::info("loadEnvio llamado con ID: " . $id);
        $this->resetForm();
        $envio = Envio::find($id);
        Log::info("Load del envio llamado con ID: " . $envio);

        if ($envio) {
            Log::info("Envio encontrado: " . $id);
            $this->id = $envio->id;
            $this->sender_name = $envio->sender_name;
            $this->receiver_name = $envio->receiver_name;
            $this->total = $envio->total;
            $this->photo = $envio->photo;
            $this->description = $envio->description;
            $this->route_unit_id = $envio->route_unit_id;
            $this->schedule_id = $envio->schedule_id;
            $this->route_id = $envio->route_id;

            $this->isEditMode = true;
            $this->isShowMode = false;
        } else {
            Log::warning("Envio no encontrado con ID: " . $id);
        }

        // Enviar evento a JavaScript para abrir el modal de Bootstrap
        $this->dispatch('show-bootstrap-modal');
    }

    // Abrir modal de detalles
    public function openShowModal($id)
    {
        Log::info("openShowModal llamado con ID: " . $id);
        $this->id = $id;
        $envio = Envio::find($id);

        if ($envio) {
            Log::info("Envio encontrado para mostrar: " . $id);
            $this->sender_name = $envio->sender_name;
            $this->receiver_name = $envio->receiver_name;
            $this->total = $envio->total;
            $this->photo = $envio->photo;
            $this->description = $envio->description;
            $this->route_unit_id = $envio->route_unit_id;
            $this->schedule_id = $envio->schedule_id;
            $this->route_id = $envio->route_id;

            $this->isShowMode = true; // Activa el modo de visualización
            $this->isEditMode = false; // Desactiva el modo de edición
            $this->dispatch('show-bootstrap-modal'); // Abre el modal
        } else {
            Log::warning("Envio no encontrado para mostrar: " . $id);
        }
    }

    // Cerrar modal
    public function closeModal()
    {
        Log::info("closeModal llamado, reseteando campos.");
        $this->reset(['isEditMode', 'isShowMode', 'id', 'sender_name', 'receiver_name', 'total', 'photo', 'description', 'route_unit_id', 'schedule_id', 'route_id']);
        // Enviar evento a JavaScript para cerrar el modal de Bootstrap
        $this->dispatch('hide-bootstrap-modal');
    }

    // Resetear formulario
    private function resetForm()
    {
        Log::info("resetForm llamado. Restableciendo todos los campos.");
        $this->id = null;
        $this->sender_name = '';
        $this->receiver_name = '';
        $this->total = '';
        $this->photo = '';
        $this->description = '';
        $this->route_unit_id = '';
        $this->schedule_id = '';
        $this->route_id = '';
        $this->isEditMode = false;
    }

    // Guardar Envio
    public function save()
    {
        Log::info("save llamado. Modo de edición: " . ($this->isEditMode ? "Sí" : "No"));

        // Validar los datos antes de guardarlos
        $this->validate([
            'sender_name'=> 'required|string|max:255',
            'receiver_name'=> 'required|string|max:255',
            'total'=> 'required|string|max:255',
            'photo'=> 'nullable|string|max:255',
            'description'=> 'required|string|max:255',
            // 'route_unit_id'=> 'required|string|max:255',
            // 'schedule_id'=> 'required|string|max:255',
            // 'route_id'=> 'required|string|max:255',
        ]);

        if ($this->isEditMode) {
            Log::info("Modo edición. Actualizando Envio con ID: " . $this->id);
            $envio = Envio::find($this->id);
            if ($envio) {
                $envio->sender_name = $this->sender_name;
                $envio->receiver_name = $this->receiver_name;
                $envio->total = $this->total;
                $envio->photo = $this->photo;
                $envio->description = $this->description;
                $envio->route_unit_id = $this->route_unit_id;
                $envio->schedule_id = $this->schedule_id;
                $envio->route_id = $this->route_id;

                $envio->save(); // Guarda los cambios
                Log::info("Envio actualizado con éxito. ID: " . $this->id);
                $this->dispatch('swalSuccessSave');
            } else {
                Log::error("No se encontró el Envio para editar. ID: " . $this->id);
            }
        } else {
            Log::info("Modo creación. Creando nuevo Envio.");
            Envio::create([
                'sender_name' => $this->sender_name,
                'receiver_name' => $this->receiver_name,
                'total' => $this->total,
                'photo' => $this->photo,
                'description' => $this->description,
                'route_unit_id' => $this->route_unit_id,
                'schedule_id' => $this->schedule_id,
                'route_id' => $this->route_id,
            ]);
            Log::info("Nuevo Envio creado con éxito.");
            $this->dispatch('swalSuccessSave');
        }

        // Cerrar el modal
        $this->closeModal();
        session()->flash('message', $this->isEditMode ? 'Envio actualizada correctamente.' : 'Envio creada correctamente.');
        $this->dispatch('Refresh')->to('envios-table');
    }

    // Abrir modal de creación
    public function openCreateModal()
    {
        Log::info("openCreateModal llamado. Reseteando formulario.");
        $this->resetForm(); // Resetea el formulario
        $this->isEditMode = false; // Establece el modo de creación
        $this->dispatch('show-bootstrap-modal'); // Muestra el modal
    }

    // Mostrar modal
    public function showModal($id): void
    {
        Log::info("showModal llamado con ID: " . $id);
        $envio = Envio::find($id);
        if ($envio) {
            $this->dispatch('openShowEnvioModal', $envio);  // Dispatch para abrir un modal con detalles
            Log::info("showModal llamado con ID: " . $envio);
        } else {
            Log::warning("Envio no encontrado para mostrar con ID: " . $id);
        }
    }

    // Borrar registro
    public function borrarRegistro($id)
    {
        Log::info("borrarRegistro llamado con ID: " . $id);
        if ($id) {
            $this->dispatch('swalConfirmDelete', ['id' => $id]);
        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    // Eliminar Envio
    public function deleteEnvio($id)
    {
        Log::info("deleteEnvio llamado con ID: " . $id);
        $envio = Envio::find($id);
        if ($envio) {
            $envio->delete();
            $this->dispatch('Refresh')->to('envios-table');
            $this->dispatch('swalSuccess');
            session()->flash('message', 'Envio eliminada correctamente.');
        } else {
            session()->flash('error', 'Envio no encontrada.');
        }
    }

    // Renderizar la vista
    public function render()
    {
        Log::info("render llamado.");
        return view('Modales.modal-envio');
    }
}
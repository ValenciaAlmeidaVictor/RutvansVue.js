<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Envio;

class EnvioComponent extends Component
{

    public $id, $sender_name,
    $receiver_name,
    $total,
    $photo,
    $description,
    $route_unit_id,
    $schedule_id,
    $route_id;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = ['openEnvioModal' => 'loadEnvio',
    'openShowEnvioModal'=> 'openShowModal',
    'borrarRegistro',
    'deleteEnvio',
    'showConfirmSave',
    'saveEnvio' => 'save'];

    //Metodos de componente

    //Modificaciones opcionales
    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);  // Disparamos el evento swalConfirm con el estado
    }


    public function loadEnvio($id)
    {
        $this->resetForm();
        $envio = Envio::find($id);

        if ($envio) {
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
        }

        // Enviar evento a JavaScript para abrir el modal de Bootstrap
        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($id)
    {
        $this->id = $id;
        $envio = Envio::find($id); 
        
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
    }


    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'id',      
        'sender_name',
        'receiver_name',
        'total',
        'photo',
        'description',
        'route_unit_id',
        'schedule_id',
        'route_id',]);
        // Enviar evento a JavaScript para cerrar el modal de Bootstrap
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        
       $this->sender_name = '';
       $this->receiver_name = '';
       $this->total = '';
       $this->photo = '';
       $this->description = '';
       $this->route_unit_id = '';
       $this->schedule_id = '';
       $this->route_id = '';


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

                'sender_name'=> 'required|string|max:255',
                'receiver_name'=> 'required|string|max:255',
                'total'=> 'required|string|max:255',
                'photo'=> 'null|string|max:255',
                'description'=> 'required|string|max:255',
                // 'route_unit_id'=> 'required|string|max:255',
                // 'schedule_id'=> 'required|string|max:255',
                // 'route_id'=> 'required|string|max:255',

                // Agregar las validaciones que necesites
            ]);


            if ($this->isEditMode) {
                $envio = Envio::find($this->id); // Usamos $this->id que se debe haber asignado previamente

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

                    $this->dispatch('swalSuccessSave');
                }
            }  else {
                
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

                $this->dispatch('swalSuccessSave');
            }

            // Cerrar el modal
            $this->closeModal();

            // Redirigir o actualizar la vista según sea necesario
            session()->flash('message', $this->isEditMode ? 'Envio actualizada correctamente.' : 'Envio creada correctamente.');
            $this->dispatch('Refresh')->to('envios-table');
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
        
        $envio = Envio::find($id);
        if ($envio) {
            // Aquí puedes enviar los detalles al modal o a donde lo necesites
            $this->dispatch('openShowEnvioModal', $envio);  // Dispatch para abrir un modal con detalles
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
    public function deleteEnvio($id)
    {
        // Log::info("ID recibido para eliminar la Envio: " . $id);

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




    public function render()
    {
        return view('Modales.modal-envio');
    }
}
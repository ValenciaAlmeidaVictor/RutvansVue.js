<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Horario;  // Usa el modelo Horario
use Illuminate\Support\Facades\Log;

class HorarioComponent extends Component
{
    public $horarioId, $departure_time, $arrival_time, $day;
    public $isEditMode = false;
    public $isShowMode = false;

    protected $listeners = [
        'openHorarioModal' => 'loadHorario',
        'openShowHorarioModal' => 'openShowModal',
        'borrarRegistro',
        'deleteHorario',
        'showConfirmSave',
        'saveHorario' => 'save'
    ];

    public function showConfirmSave($isEditMode)
    {
        $this->dispatch('swalConfirmSave', ['isEditMode' => $isEditMode]);
    }

    public function loadHorario($horarioId)
    {
        $this->resetForm();
        $horario = Horario::find($horarioId);

        if ($horario) {
            $this->departure_time = $horario->departure_time;
            $this->arrival_time = $horario->arrival_time;
            $this->day = $horario->day;
            $this->horarioId = $horario->id;
            $this->isEditMode = true;
            $this->isShowMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function openShowModal($horarioId)
    {
        $this->horarioId = $horarioId;
        $horario = Horario::find($horarioId);

        if ($horario) {
            $this->departure_time = $horario->departure_time;
            $this->arrival_time = $horario->arrival_time;
            $this->day = $horario->day;
            $this->isShowMode = true;
            $this->isEditMode = false;
        }

        $this->dispatch('show-bootstrap-modal');
    }

    public function closeModal()
    {
        $this->reset(['isEditMode', 'isShowMode', 'departure_time', 'arrival_time', 'day', 'horarioId']);
        $this->dispatch('hide-bootstrap-modal');
    }

    private function resetForm()
    {
        $this->departure_time = '';
        $this->arrival_time = '';
        $this->day = '';
        $this->horarioId = null;
        $this->isEditMode = false;
    }

    public function render()
    {
        return view('Modales.modal-horario');  // Vista que deberás crear
    }

    public function save()
    {
        $this->validate([
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i',
            'day' => 'required|string|max:255',
        ]);

        if ($this->isEditMode) {
            $horario = Horario::find($this->horarioId);

            if ($horario) {
                $horario->departure_time = $this->departure_time;
                $horario->arrival_time = $this->arrival_time;
                $horario->day = $this->day;
                $horario->save();
                $this->dispatch('swalSuccessSave');
            }
        } else {
            Horario::create([
                'departure_time' => $this->departure_time,
                'arrival_time' => $this->arrival_time,
                'day' => $this->day
            ]);
            $this->dispatch('swalSuccessSave');
        }

        $this->closeModal();
        session()->flash('message', $this->isEditMode
            ? 'Horario actualizado correctamente.'
            : 'Horario creado correctamente.');
        $this->dispatch('Refresh')->to('horarios-table');  // Asegúrate de que la tabla se refresque
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->dispatch('show-bootstrap-modal');
    }

    public function borrarRegistro($horarioId)
    {
        Log::info("ID recibido en borrarRegistro: " . $horarioId);

        if ($horarioId) {
            $this->horarioId = $horarioId;  // Asigna el ID al atributo del componente
            $this->dispatch('swalConfirmDelete', ['id' => $horarioId]);  // Despacha el evento de confirmación
            Log::info("ID Enviado a swalConfirm: " . $horarioId);
        } else {
            Log::error("ID no recibido correctamente.");
        }
    }

    public function deleteHorario()
    {
        Log::info("ID recibido para eliminar el horario: " . $this->horarioId);

        $horario = Horario::find($this->horarioId);
        if ($horario) {
            $horario->delete();
            $this->dispatch('Refresh')->to('horarios-table'); // Refresca la tabla
            $this->dispatch('swalSuccess');  // Despacha evento de éxito
            session()->flash('message', 'Horario eliminado correctamente.');
        } else {
            session()->flash('error', 'Horario no encontrado.');
        }
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Boleto;
use App\Models\Ruta;
use App\Models\Horario;
use App\Models\DestinoIntermedio;

class Boletos extends Component
{
    use WithPagination;

    public $boleto_id, $nombrePasajero, $total, $idRutaUnidad, $idHorario, $idRuta, $idDestinoIntermedio, $fecha;
    public $showModal = false;
    public $showDeleteModal = false;
    public $modalType = ''; 
    public $boletoSeleccionado;
    public $boletoAEliminar;

    public $rutas;
    public $horarios;
    public $destinosIntermedios;
    public $boletos;

    public function mount()
    {
        $this->rutas = Ruta::all();
        $this->horarios = Horario::all();
        $this->destinosIntermedios = DestinoIntermedio::all();
        $this->boletos = Boleto::with(['ruta', 'horario', 'destinoIntermedio'])->get();
    }

    public function openModal($type, $id = null)
    {
        $this->modalType = $type;

        if ($type === 'edit') {
            $this->boletoSeleccionado = Boleto::find($id);
            $this->nombrePasajero = $this->boletoSeleccionado->nombrePasajero;
            $this->total = $this->boletoSeleccionado->total;
            $this->idRutaUnidad = $this->boletoSeleccionado->idRutaUnidad;
            $this->idHorario = $this->boletoSeleccionado->idHorario;
            $this->idRuta = $this->boletoSeleccionado->idRuta;
            $this->idDestinoIntermedio = $this->boletoSeleccionado->idDestinoIntermedio;
            $this->fecha = $this->boletoSeleccionado->fecha;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->nombrePasajero = '';
        $this->total = '';
        $this->idRutaUnidad = null;
        $this->idHorario = null;
        $this->idRuta = null;
        $this->idDestinoIntermedio = null;
        $this->fecha = '';
        $this->boletoSeleccionado = null;
        $this->boletoAEliminar = null;
    }

    public function save()
    {
        $this->validate([
            'nombrePasajero' => 'required|string|max:255',
            'total' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        if ($this->modalType === 'create') {
            Boleto::create([
                'nombrePasajero' => $this->nombrePasajero,
                'total' => $this->total,
                'idRutaUnidad' => $this->idRutaUnidad,
                'idHorario' => $this->idHorario,
                'idRuta' => $this->idRuta,
                'idDestinoIntermedio' => $this->idDestinoIntermedio,
                'fecha' => $this->fecha,
            ]);
        } elseif ($this->modalType === 'edit') {
            $this->boletoSeleccionado->update([
                'nombrePasajero' => $this->nombrePasajero,
                'total' => $this->total,
                'idRutaUnidad' => $this->idRutaUnidad,
                'idHorario' => $this->idHorario,
                'idRuta' => $this->idRuta,
                'idDestinoIntermedio' => $this->idDestinoIntermedio,
                'fecha' => $this->fecha,
            ]);
        }

        $this->closeModal();
        $this->boletos = Boleto::with(['ruta', 'horario', 'destinoIntermedio'])->get();
    }

    public function confirmDelete($id)
    {
        $this->boletoAEliminar = Boleto::find($id);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->boletoAEliminar) {
            $this->boletoAEliminar->delete();
            $this->boletos = Boleto::with(['ruta', 'horario', 'destinoIntermedio'])->get();
        }
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.boletos');
    }
     // Método adicional si deseas obtener los boletos en formato JSON (usado si necesitas un API)
     public function index()
     {
         $boletos = Boleto::all();
         return response()->json(['boletos' => $boletos, 'status' => 200], 200);
     }
}

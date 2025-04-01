<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Usuario;
use App\Models\Rol;

class Usuarios extends Component
{
    public $nombreUsuario;
    public $password;
    public $idRol;

    public $showModal = false;
    public $showDeleteModal = false;
    public $modalType = ''; 
    public $usuarioSeleccionado;
    public $usuarioAEliminar;

    public $roles;
    public $usuarios;

    public function mount()
    {
        $this->roles = Rol::all();
        $this->usuarios = Usuario::with('rol')->get();
    }

    public function openModal($type, $id = null)
    {
        $this->modalType = $type;
        
        if ($type === 'edit') {
            $this->usuarioSeleccionado = Usuario::find($id);
            $this->nombreUsuario = $this->usuarioSeleccionado->nombreUsuario;
            $this->idRol = $this->usuarioSeleccionado->idRol;
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
        $this->nombreUsuario = '';
        $this->password = '';
        $this->idRol = '';
        $this->usuarioSeleccionado = null;
        $this->usuarioAEliminar = null;
    }

    public function save()
    {
        $this->validate([
            'nombreUsuario' => 'required',
            'password' => 'required|min:6',
            'idRol' => 'required|exists:roles,idRol',
        ]);

        if ($this->modalType === 'create') {
            Usuario::create([
                'nombreUsuario' => $this->nombreUsuario,
                'password' => bcrypt($this->password),
                'idRol' => $this->idRol,
            ]);
        } elseif ($this->modalType === 'edit') {
            $this->usuarioSeleccionado->update([
                'nombreUsuario' => $this->nombreUsuario,
                'password' => bcrypt($this->password),
                'idRol' => $this->idRol,
            ]);
        }

        $this->closeModal();
        $this->usuarios = Usuario::with('rol')->get();
    }

    public function confirmDelete($id)
    {
        $this->usuarioAEliminar = Usuario::find($id);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->usuarioAEliminar) {
            $this->usuarioAEliminar->delete();
            $this->usuarios = Usuario::with('rol')->get();
        }
        $this->closeModal();
    }

    public function getUsuariosApi()
    {
        $usuarios = Usuario::with('rol')->get();

        return response()->json([
            'usuarios' => $usuarios,
            'status' => 200,
        ]);
    }

    public function render()
    {
        return view('livewire.usuarios');
    }
}

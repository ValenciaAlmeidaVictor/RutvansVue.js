<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesComponente extends Component
{
    public $role; // Lista de roles
    public $roleId, $roleName; // Datos para edición y creación
    public $open = false; // Estado del modal de creación/edición
    public $creating = false; // Para diferenciar entre creación y edición

    protected $rules = [
        'roleName' => 'required|string|max:255', // Validación para nombre del permiso
    ];

    // Listener para actualizar la lista al guardar o eliminar
    protected $listeners = [
        'deleteConfirmed' => 'delete', // Escuchar evento con el parámetro
        'roleGuardado' => 'loadRole',
    ];


    public function mount()
    {
        $this->loadRole(); // Cargar todos los roles al montar el componente
    }

    public function loadRole()
    {
        $this->role = Role::all(); // Cargar los roles desde la base de datos
    }

    // Método para abrir el modal para creación
    public function create()
    {
        $this->resetInput(); // Limpiar campos
        $this->creating = true; // Activar modo creación
        $this->open = true; // Abrir modal
    }

    // Método para guardar un nuevo rol
    public function guardar()
    {
        $this->validate(); // Validar datos

        if ($this->roleId) {
            // Actualizar rol existente
            $role = Role::findOrFail($this->roleId);
            $role->update(['name' => $this->roleName]);
            $message = '¡El rol se ha actualizado exitosamente!';
        } else {
            // Crear un nuevo rol
            Role::create(['name' => $this->roleName]);
            $message = '¡El rol se ha creado exitosamente!';
        }

        // Emitir eventos para recargar tabla y mostrar alerta
        $this->dispatch('roleGuardado');
        $this->dispatch('alert', [
            'icon' => 'success',
            'message' => $message,
        ]);

        // Resetear campos y cerrar modal
        $this->resetInput();
        $this->closeModal();
    }

    // Método para editar un permiso
    public function edit($id)
    {
        $role = Role::findOrFail($id); // Buscar permiso por ID
        $this->roleId = $role->id;
        $this->roleName = $role->name;

        $this->creating = false; // Activar modo edición
        $this->open = true; // Abrir modal
    }

    // Método para actualizar un rol
    public function update()
    {
        $this->validate(); // Validar datos

        // Buscar y actualizar el rol
        Role::findOrFail($this->roleId)->update(['name' => $this->roleName]);

        // Emitir eventos
        $this->dispatch('roleGuardado');
        $this->dispatch('alert', [
            'icon' => 'success',
            'message' => '¡El rol se ha actualizado exitosamente!',
        ]);

        $this->resetInput();
        $this->closeModal();
    }

    public function delete($id)
    {
        // Buscar y eliminar el rol por ID
        Role::findOrFail($id)->delete();

        // Emitir eventos para recargar la tabla y mostrar alerta
        $this->dispatch('roleGuardado');
        $this->dispatch('alert', [
            'icon' => 'success',
            'message' => '¡El rol ha sido eliminado exitosamente!',
        ]);
    }
    // Método para cerrar el modal
    public function closeModal()
    {
        $this->open = false; // Cerrar modal
    }

    // Método para resetear los campos del formulario
    private function resetInput()
    {
        $this->roleName = '';
        $this->roleId = null;
    }

    public function render()
    {
        return view('livewire.roles-componente');
    }
}

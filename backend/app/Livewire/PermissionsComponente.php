<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsComponente extends Component
{
    public $permissions; // Lista de permisos
    public $permissionId, $permissionName; // Datos para edición y creación
    public $open = false; // Estado del modal de creación/edición
    public $creating = false; // Para diferenciar entre creación y edición
    protected $rules = [
        'permissionName' => 'required|string|max:255', // Validación para nombre del permiso
    ];
    // Listener para actualizar la lista al guardar o eliminar
    protected $listeners = [
        'deleteConfirmed' => 'delete', // Escuchar evento con el parámetro
        'permisoGuardado' => 'loadPermissions',
    ];

    public function mount()
    {
        $this->loadPermissions(); // Cargar todos los permisos al montar el componente
    }
    public function loadPermissions()
    {
        $this->permissions = Permission::all(); // Cargar los permisos desde la base de datos
    }
    // Método para abrir el modal para creación
    public function create()
    {
        $this->resetInput(); // Limpiar campos
        $this->creating = true; // Activar modo creación
        $this->open = true; // Abrir modal
    }
    // Método para guardar un nuevo permiso
    public function guardar()
    {
        $this->validate(); // Validar datos
        if ($this->permissionId) {
            // Actualizar permiso existente
            $permission = Permission::findOrFail($this->permissionId);
            $permission->update(['name' => $this->permissionName]);
            $message = '¡El permiso se ha actualizado exitosamente!';
        } else {
            // Crear un nuevo permiso
            Permission::create(['name' => $this->permissionName]);
            $message = '¡El permiso se ha creado exitosamente!';
        }
        // Emitir eventos para recargar tabla y mostrar alerta
        $this->dispatch('permisoGuardado');
        $this->dispatch(
            'alert',
            [
                'icon' => 'success',
                'message' => $message,
            ]
        );
        // Resetear campos y cerrar modal
        $this->resetInput();
        $this->closeModal();
    }
    // Método para editar un permiso
    public function edit($id)
    {
        $permission = Permission::findOrFail($id); // Buscar permiso por ID
        $this->permissionId = $permission->id;
        $this->permissionName = $permission->name;
        $this->creating = false; // Activar modo edición
        $this->open = true; // Abrir modal
    }

    // Método para actualizar un permiso
    public function update()
    {
        $this->validate(); // Validar datos
        // Buscar y actualizar el permiso
        Permission::findOrFail($this->permissionId)->update(['name' => $this->permissionName]);
        // Emitir eventos
        $this->dispatch('permisoGuardado');
        $this->dispatch(
            'alert',
            [
                'icon' => 'success',
                'message' => '¡El permiso se ha actualizado exitosamente!',
            ]
        );
        $this->resetInput();
        $this->closeModal();
    }
    public function delete($id)
    {
        // Buscar y eliminar el permiso por ID
        Permission::findOrFail($id)->delete();
        // Emitir eventos para recargar la tabla y mostrar alerta
        $this->dispatch('permisoGuardado');
        $this->dispatch(
            'alert',
            [
                'icon' => 'success',
                'message' => '¡El permiso ha sido eliminado exitosamente!',
            ]
        );
    }

    // Método para cerrar el modal
    public function closeModal()
    {
        $this->open = false; // Cerrar modal
    }

    // Método para resetear los campos del formulario
    private function resetInput()
    {
        $this->permissionName = '';
        $this->permissionId = null;
    }

    public function render()
    {
        return view('livewire.permissions-componente');
    }
}

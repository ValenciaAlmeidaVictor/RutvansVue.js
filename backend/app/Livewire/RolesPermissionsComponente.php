<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsComponente extends Component
{
    public $roles;
    public $permissions;
    public $rolePermissions = [];
    public $roleName;
    public $selectedRoleId;

    public function mount()
    {
        $this->loadRoles();
        $this->loadPermissions();
    }

    public function loadRoles()
    {
        $this->roles = Role::all();
    }

    public function loadPermissions()
    {
        $this->permissions = Permission::all();
    }

    // Método para abrir el modal y cargar los permisos del rol seleccionado
    public function viewPermissions($roleId)
    {
        $this->selectedRoleId = $roleId;
        $role = Role::findOrFail($roleId);
        $this->roleName = $role->name;

        // Cargar permisos asignados al rol
        $this->rolePermissions = $role->permissions->pluck('name')->toArray();
    }

    // Método para actualizar los permisos
    public function updatePermissions()
    {
        $role = Role::findOrFail($this->selectedRoleId);

        // Asignar los permisos seleccionados
        $role->syncPermissions($this->rolePermissions);

        // Emitir mensaje de éxito
        $this->dispatch('alert', [
            'icon' => 'success',
            'message' => '¡Permisos actualizados correctamente!',
        ]);

        // Resetear variables
        $this->resetPermissions();
    }
    // Resetear variables después de cerrar el modal
    private function resetPermissions()
    {
        $this->rolePermissions = [];
        $this->roleName = '';
        $this->selectedRoleId = null;
    }

    public function render()
    {
        return view('livewire.roles-permissions-componente', [
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ]);
    }
}

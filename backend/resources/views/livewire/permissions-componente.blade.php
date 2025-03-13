<div>
    <!-- Botón para abrir el modal de creación -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#permissionsModal">
        Agregar Permiso
    </button>
    <!-- Tabla de permisos -->
    <table id="permissionsTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre del Permiso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <button wire:click="edit({{ $permission->id }})" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editPermissionsModal">Editar</button>
                        <button wire:click="$dispatch('confirmDelete', { permissionId: {{ $permission->id }} })"
                            class="btn btn-danger">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Incluir los modales de edición y creación -->
    @include('livewire.edit-permissions-componente')
    @include('livewire.create-permissions-componente')
</div>

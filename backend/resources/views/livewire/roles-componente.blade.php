<div>
    <!-- Botón para abrir el modal de creación -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#roleModal">
        Agregar Rol
    </button>
    <!-- Tabla de roles -->
    <table id="roleTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre del Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($role as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>
                        <button wire:click="edit({{ $role->id }})" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editRolesModal">Editar</button>
                        <button wire:click="$dispatch('confirmDelete', { roleId: {{ $role->id }} })"
                            class="btn btn-danger">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Incluir los modales de edición y creación -->
    @include('livewire.edit-roles-componente')
    @include('livewire.create-roles-componente')
</div>

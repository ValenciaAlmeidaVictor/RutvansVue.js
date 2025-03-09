<div>
    <!-- Tabla de roles -->
    <table id="roleTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre del Rol</th>
                <th>Permisos Asignados</th> <!-- Nueva columna -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <!-- Nueva columna que muestra los permisos asignados -->
                    <td>
                        @if ($role->permissions->isEmpty())
                            <span class="text-warning">Este rol aún no tiene permisos asignados</span>
                        @else
                            <ul class="list-unstyled">
                                @foreach ($role->permissions as $permission)
                                    <li><span class="text-success">{{ $permission->name }}</span></li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <td>
                        <!-- Botón de "Ver" para mostrar permisos del rol -->
                        <button wire:click="viewPermissions({{ $role->id }})" class="btn btn-info"
                            data-bs-toggle="modal" data-bs-target="#permissionsModal">Ver</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('livewire.show-roles-permissions-componente')
</div>

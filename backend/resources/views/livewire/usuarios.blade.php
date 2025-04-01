
<div class="p-3 bg-light min-vh-100">
    <h1 class="h3 font-weight-bold text-dark mb-4">Usuarios</h1>

    <button wire:click="openModal('create')" class="btn btn-primary mb-4">
        Crear Usuario
    </button>

    <div class="bg-white p-3 rounded shadow">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Nombre</th>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Rol</th>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td class="p-3">{{ $usuario->nombreUsuario }}</td>
                        <td class="p-3">{{ $usuario->rol->nombreRol }}</td>
                        <td class="p-3">
                            <button wire:click="openModal('edit', {{ $usuario->idUsuario }})"
                                class="btn btn-sm btn-warning mr-2">Editar</button>
                            <button wire:click="confirmDelete({{ $usuario->idUsuario }})"
                                class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($showModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $modalType === 'create' ? 'Crear Usuario' : 'Editar Usuario' }}
                    </h5>
                    <button type="button" wire:click="closeModal" class="close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="form-group">
                            <label>Nombre de usuario</label>
                            <input type="text" wire:model="nombreUsuario" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" wire:model="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <select wire:model="idRol" class="form-control">
                                <option value="">Seleccionar Rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->idRol }}">{{ $rol->nombreRol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($showDeleteModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" wire:click="closeModal" class="close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar al usuario <strong>{{ $usuarioAEliminar->nombreUsuario ?? '' }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancelar</button>
                    <button type="button" wire:click="delete" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div>
    <!-- Modal para ver/editar permisos de rol -->
    <div wire:ignore.self class="modal fade" id="permissionsModal" tabindex="-1" aria-labelledby="permissionsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionsModalLabel">Asignar Permisos al Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" id="roleName" wire:model="roleName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="permissions" class="form-label">Seleccionar Permisos</label>
                        <div>
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $permission->name }}"
                                        wire:model="rolePermissions" id="permission-{{ $permission->id }}">
                                    <label class="form-check-label" for="permission-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="updatePermissions"
                        data-bs-dismiss="modal">Actualizar Permisos</button>
                </div>
            </div>
        </div>
    </div>
</div>

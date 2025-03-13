<div>
    <!-- Modal para editar permiso -->
    <div wire:ignore.self class="modal fade" id="editRolesModal" tabindex="-1" aria-labelledby="editRolesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRolesModalLabel">
                        Editar Rol
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editRoleName" class="form-label">Nombre del Permiso</label>
                        <input type="text" class="form-control" id="editRoleName"
                            placeholder="Ingrese el nombre del permiso" wire:model.defer="roleName">
                        @error('roleName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="update"
                        data-bs-dismiss="modal">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</div>

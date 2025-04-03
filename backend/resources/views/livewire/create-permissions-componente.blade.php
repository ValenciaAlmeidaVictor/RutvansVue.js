<div>
    <div wire:ignore.self class="modal fade" id="permissionsModal" tabindex="-1" aria-labelledby="permissionsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="permissionsModalLabel">Nuevo Permiso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="permissionName" class="form-label">Nombre del Permiso</label>
                        <input type="text" class="form-control" id="permissionName" wire:model.defer="permissionName"
                            placeholder="Ingrese el nombre del permiso">
                        @error('permissionName')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Pie del modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="guardar" data-bs-dismiss="modal">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

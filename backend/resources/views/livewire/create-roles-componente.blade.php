<div>
    <div wire:ignore.self class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Encabezado del modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalLabel">Nuevo Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <!-- Cuerpo del modal -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Nombre del Rol</label>
                        <input type="text" class="form-control" id="roleName" wire:model.defer="roleName"
                            placeholder="Ingrese el nombre del rol">
                        @error('roleName')
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

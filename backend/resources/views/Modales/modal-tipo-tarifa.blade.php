<div>
    <button type="button" class="btn mb-4" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="openCreateModal">
        <i class="fas fa-tags"></i> Crear Nuevo Tipo de Tarifa
    </button>

    <div class="modal fade" id="tipoTarifaModal" tabindex="-1" aria-labelledby="tipoTarifaModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #ff7f00; color: white;">
                    <h5 class="modal-title" id="tipoTarifaModalLabel">
                        @if($isEditMode)
                            <i class="fas fa-edit"></i> Editar Tipo de Tarifa
                        @elseif($isShowMode)
                            <i class="fas fa-info-circle"></i> Detalles del Tipo de Tarifa
                        @else
                            <i class="fas fa-plus-circle"></i> Crear Tipo de Tarifa
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" style="font-size: 1.5rem; background: none; border: none; color: white;">&times;</button>
                </div>

                <div class="modal-body">
                    @if($isShowMode)
                        <div style="max-width: 600px; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="color: #333; font-size: 1.6rem; font-weight: 600; letter-spacing: 0.5px;">Detalles del Tipo de Tarifa</h2>
                            </div>

                            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px;">
                                <div style="flex: 1 1 45%; min-width: 250px;">
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Nombre:</strong> <span style="font-weight: 400;">{{ $name }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Porcentaje:</strong> <span style="font-weight: 400;">{{ $percentage }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Descripción:</strong> <span style="font-weight: 400;">{{ $description }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Nombre del Tipo de Tarifa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                        <input type="text" wire:model="name" class="form-control" placeholder="Ingrese el nombre">
                                    </div>
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Porcentaje</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        <input type="number" wire:model="percentage" class="form-control" placeholder="Ingrese el porcentaje">
                                    </div>
                                    @error('percentage') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Descripción</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        <textarea wire:model="description" class="form-control" placeholder="Ingrese una descripción"></textarea>
                                    </div>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" wire:click="closeModal">Cerrar</button>
                                <button type="submit" class="btn" style="background-color: #ff7f00; border-color: #ff7f00; color: white;">
                                    @if($isEditMode)
                                        Actualizar
                                    @else
                                        Crear
                                    @endif
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
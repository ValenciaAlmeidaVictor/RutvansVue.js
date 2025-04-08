<div>
    <button type="button" class="btn mb-4" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="openCreateModal">
        <i class="fas fa-shuttle-van"></i> Crear Nueva Unidad
    </button>

    <div class="modal fade" id="UnidadModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #ff7f00; color: white;">
                    <h5 class="modal-title">
                        @if($isShowMode)
                            <i class="fas fa-info-circle"></i> Detalles de la Unidad
                        @elseif($isEditMode)
                            <i class="fas fa-edit"></i> Editar Unidad
                        @else
                            <i class="fas fa-plus-circle"></i> Crear Unidad
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" style="font-size: 1.5rem; background: none; border: none; color: white;">&times;</button>
                </div>

                <div class="modal-body">
                    @if($isShowMode)
                        <div style="max-width: 600px; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="color: #333; font-size: 1.6rem; font-weight: 600; letter-spacing: 0.5px;">Detalles de la Unidad</h2>
                            </div>

                            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px;">
                                <div style="flex: 1 1 45%; min-width: 250px;">
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Placa:</strong> <span style="font-weight: 400;">{{ $plate }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Capacidad:</strong> <span style="font-weight: 400;">{{ $capacitance }} Pasajeros</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Año:</strong> <span style="font-weight: 400;">{{ $year }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Modelo:</strong> <span style="font-weight: 400;">{{ $model }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Marca:</strong> <span style="font-weight: 400;">{{ $brand }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Placa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                        <input type="text" wire:model="plate" class="form-control" placeholder="Ejemplo: ABC-123">
                                    </div>
                                    @error('plate') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Capacidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                                        <input type="number" wire:model="capacitance" class="form-control" placeholder="Ejemplo: 45">
                                    </div>
                                    @error('capacitance') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Año</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" wire:model="year" class="form-control" placeholder="Ejemplo: 2024">
                                    </div>
                                    @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Modelo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-car"></i></span>
                                        <input type="text" wire:model="model" class="form-control" placeholder="Ejemplo: Sprinter">
                                    </div>
                                    @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Marca</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-industry"></i></span>
                                        <input type="text" wire:model="brand" class="form-control" placeholder="Ejemplo: Mercedes-Benz">
                                    </div>
                                    @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                                        <!-- Campo de imagen -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="unit_image" class="form-label">Imagen</label>
                                    <input type="file" id="image" wire:model="unit_image" class="form-control">
                                    @error('unit_image') <span class="text-danger">{{ $message }}</span> @enderror

                                    <!-- Previsualización de la imagen cargada -->
                                    @if($unit_image)
                                        <div class="mt-2">
                                            <img src="{{ $unit_image->temporaryUrl() }}" alt="Image Preview" class="img-thumbnail" width="100">
                                        </div>
                                    @elseif($isEditMode && $oldImage)
                                        <!-- Mostrar imagen actual si existe en el modo de edición -->
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $oldImage) }}" alt="Unit Image" class="img-thumbnail" width="100">
                                        </div>
                                    @endif
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

<div>
    <button type="button" class="btn mb-4" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="openCreateModal">
        <i class="fas fa-map-marked-alt"></i> Crear Nuevo Destino Intermedio
    </button>

    <div class="modal fade" id="localidadModal" tabindex="-1" aria-labelledby="localidadModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #ff7f00; color: white;">
                    <h5 class="modal-title" id="localidadModalLabel">
                        @if($isEditMode)
                            <i class="fas fa-edit"></i> Editar Destino Intermedio
                        @elseif($isShowMode)
                            <i class="fas fa-info-circle"></i> Detalles del Destino Intermedio
                        @else
                            <i class="fas fa-plus-circle"></i> Crear Destino Intermedio
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" style="font-size: 1.5rem; background: none; border: none; color: white;">&times;</button>
                </div>

                <div class="modal-body">
                    @if($isShowMode)
                        <div style="max-width: 600px; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="color: #333; font-size: 1.6rem; font-weight: 600; letter-spacing: 0.5px;">Detalles del Destino Intermedio</h2>
                            </div>

                            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px;">
                                <div style="flex: 1 1 45%; min-width: 250px;">
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Nombre:</strong> <span style="font-weight: 400;">{{ $name }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Ruta:</strong> <span style="font-weight: 400;">{{ $route_id }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Nombre del Destino Intermedio</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-route"></i></span>
                                        <input type="text" wire:model="name" class="form-control" placeholder="Ingrese el nombre del destino">
                                    </div>
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Ruta</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-signs"></i></span>
                                        <select wire:model="route_id" class="form-control">
                                            <option value="">Selecciona una ruta</option>
                                            @foreach($rutas as $ruta)
                                                <option value="{{ $ruta->id }}">
                                                    Origen: {{ $ruta->origin_locality_id }} - Destino: {{ $ruta->destination_locality_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('route_id') <span class="text-danger">{{ $message }}</span> @enderror
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
<div>
    <!-- Botón para crear un nuevo conductor -->
        <button type="button" class="btn mb-4" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="openCreateModal">
        <i class="fas fa-car-side"></i> Crear Nuevo Conductor
        </button>

    <!-- Modal de Bootstrap para Crear, Editar o Mostrar Conductor -->
    <div class="modal fade" id="ConductorModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #ff7f00; color: white;">
                    <h5 class="modal-title">
                        @if($isShowMode)
                            <i class="fas fa-info-circle"></i> Detalles del Conductor
                        @elseif($isEditMode)
                            <i class="fas fa-edit"></i> Editar Conductor
                        @else
                            <i class="fas fa-plus-circle"></i> Crear Conductor
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal" style="font-size: 1.5rem; background: none; border: none; color: white;">&times;</button>
                </div>

                <div class="modal-body">
                    @if($isShowMode)
                        <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa;">
                            <div style="text-align: center; margin-bottom: 20px;">
                                <h2 style="color: #333; font-size: 1.6rem; font-weight: 600;">Detalles del Conductor</h2>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <p><strong>Nombre:</strong> <span>{{ $name }}</span></p>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <p><strong>Horario:</strong> <span>{{ $id_Schedules }}</span></p>
                            </div>
                            <div style="margin-bottom: 15px;">
                                <p><strong>Ruta Unidad:</strong> <span>{{ $id_RouteUnit }}</span></p>
                            </div>
                        </div>
                    @else
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" wire:model="name" class="form-control" placeholder="Ingrese el nombre del conductor">
                                    </div>
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Horario</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" wire:model="id_Schedules" class="form-control" placeholder="Ingrese el horario del conductor">
                                    </div>
                                    @error('id_Schedules') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Ruta Unidad</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" wire:model="id_RouteUnit" class="form-control" placeholder="Ingrese la ruta de la unidad">
                                    </div>
                                    @error('id_RouteUnit') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" wire:click="closeModal">Cancelar</button>
                                <button type="submit" class="btn" style="background-color: #ff7f00; border-color: #ff7f00; color: white;">
                                    @if($isEditMode)
                                        Guardar Cambios
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

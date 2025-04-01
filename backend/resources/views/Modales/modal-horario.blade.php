<div>
    <!-- Botón para crear un nuevo horario -->
    <button type="button" class="btn mb-4" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="openCreateModal">
        <i class="fas fa-clock"></i> Crear Nuevo Horario
    </button>

    <!-- Modal de Bootstrap para Crear, Editar o Mostrar Horario -->
    <div class="modal fade" id="horarioModal" tabindex="-1" aria-labelledby="horarioModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #ff7f00; color: white;">
                    <h5 class="modal-title" id="horarioModalLabel">
                        @if($isEditMode)
                            <i class="fas fa-edit"></i> Editar Horario
                        @elseif($isShowMode)
                            <i class="fas fa-info-circle"></i> Detalles del Horario
                        @else
                            <i class="fas fa-plus-circle"></i> Crear Horario
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" style="font-size: 1.5rem; background: none; border: none; color: white;">&times;</button>
                </div>

                <div class="modal-body">
                    @if($isShowMode)
                        <!-- Detalles del Horario (Solo tres campos) -->
                        <div style="max-width: 600px; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa;">
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="color: #333; font-size: 1.6rem; font-weight: 600; letter-spacing: 0.5px;">Detalles del Horario</h2>
                            </div>

                            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px;">
                                <div style="flex: 1 1 45%; min-width: 250px;">
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Hora de Salida:</strong> <span style="font-weight: 400;">{{ $departure_time }} <span style="font-size: 0.9rem; color: #888;">HRS</span></span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Hora de Llegada:</strong> <span style="font-weight: 400;">{{ $arrival_time }} <span style="font-size: 0.9rem; color: #888;">HRS</span></span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Día:</strong> <span style="font-weight: 400;">{{ $day }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Formulario para Crear o Editar Horario -->
                        <form wire:submit.prevent="save">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Hora de Salida</label>
                                    <input type="time" wire:model="departure_time" class="form-control">
                                    @error('departure_time') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Hora de Llegada</label>
                                    <input type="time" wire:model="arrival_time" class="form-control">
                                    @error('arrival_time') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Día</label>
                                    <input type="text" wire:model="day" class="form-control" placeholder="Ej. Lunes, Martes, etc.">
                                    @error('day') <span class="text-danger">{{ $message }}</span> @enderror
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

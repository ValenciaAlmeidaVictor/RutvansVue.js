<div>
    <!-- Botón para crear un nuevo ticket -->
    <button type="button" class="btn mb-4" style="background-color: #007bff; border-color: #007bff; color: white;" wire:click="openCreateModal">
        <i class="fas fa-ticket-alt"></i> Crear Nuevo Ticket
    </button>

    <!-- Modal de Bootstrap para Crear, Editar o Mostrar Ticket -->
    <div class="modal fade" id="ticketModal" tabindex="-1" aria-labelledby="ticketModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #007bff; color: white;">
                    <h5 class="modal-title" id="ticketModalLabel">
                        @if($isEditMode)
                            <i class="fas fa-edit"></i> Editar Ticket
                        @elseif($isShowMode)
                            <i class="fas fa-info-circle"></i> Detalles del Ticket
                        @else
                            <i class="fas fa-plus-circle"></i> Crear Ticket
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" style="font-size: 1.5rem; background: none; border: none; color: white;">&times;</button>
                </div>

                <div class="modal-body">
                @if($isShowMode)
                        <div style="max-width: 600px; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa;">
                            <!-- Header -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="color: #333; font-size: 1.6rem; font-weight: 600; letter-spacing: 0.5px;">Detalles del Ticket</h2>
                            </div>

                            <!-- Información del Ticket -->
                            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px;">
                                <!-- Información izquierda -->
                                <div style="flex: 1 1 45%; min-width: 250px;">
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Folio:</strong> <span style="font-weight: 400;">{{ $folio }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Descripción:</strong> <span style="font-weight: 400;">{{ $description }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Fecha:</strong> <span style="font-weight: 400;">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
                                    </p>
                                </div>

                                <!-- Información derecha -->
                                <div style="flex: 1 1 45%; min-width: 250px;">
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Prioridad:</strong> <span style="font-weight: 400;">{{ $priority }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Estado:</strong> <span style="font-weight: 400;">{{ $state }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Usuario:</strong> <span style="font-weight: 400;">{{ optional(\App\Models\User::find($user_id))->name ?? 'N/A' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
<!-- Formulario para Crear o Editar -->
<form wire:submit.prevent="save">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Folio</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                <input type="text" wire:model="folio" class="form-control" placeholder="Ingresa el folio">
            </div>
            @error('folio') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Descripción</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-comment"></i></span>
                <input type="text" wire:model="description" class="form-control" placeholder="Ingresa la descripción">
            </div>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label">Fecha</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" wire:model="date" class="form-control" placeholder="Selecciona la fecha">
            </div>
            @error('date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Prioridad</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-exclamation-circle"></i></span>
                <select wire:model="priority" class="form-control">
                    <option value="">Seleccione la prioridad</option>
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>
            @error('priority') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Estado</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                <select wire:model="state" class="form-control">
                    <option value="">Seleccione el estado</option>
                    <option value="Abierto">Abierto</option>
                    <option value="Cerrado">Cerrado</option>
                    <option value="En Progreso">En Progreso</option>
                </select>
            </div>
            @error('state') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label">Usuario</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <select wire:model="user_id" class="form-control">
                    <option value="">Seleccione un usuario</option>
                    @foreach(App\Models\User::all() as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>

            </div>
            @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-dark" wire:click="closeModal">Cerrar</button>
        <button type="button" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;" wire:click="save">
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

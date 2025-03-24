<div>
    <!-- Botón para crear una nueva venta -->
    <button type="button" class="btn mb-4" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="openCreateModal">
        <i class="fas fa-plus-circle"></i> Crear Nueva Venta
    </button>

    <!-- Modal de Bootstrap para Crear, Editar o Mostrar Venta -->
    <div class="modal fade" id="ventaModal" tabindex="-1" aria-labelledby="ventaModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                <div class="modal-header" style="background-color: #ff7f00; color: white;">
                    <h5 class="modal-title" id="ventaModalLabel">
                        @if($isEditMode)
                            <i class="fas fa-edit"></i> Editar Venta
                        @elseif($isShowMode)
                            <i class="fas fa-info-circle"></i> Detalles de la Venta
                        @else
                            <i class="fas fa-plus-circle"></i> Crear Venta
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" style="font-size: 1.5rem; background: none; border: none; color: white;">&times;</button>
                </div>

                <div class="modal-body">
                @if($isShowMode)
                        <div style="max-width: 600px; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa;">
                            <!-- Header -->
                            <div style="text-align: center; margin-bottom: 30px;">
                                <h2 style="color: #333; font-size: 1.6rem; font-weight: 600; letter-spacing: 0.5px;">Detalles de la Transacción</h2>
                            </div>

                            <!-- Información de la Venta -->
                            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px;">
                                <!-- Información izquierda -->
                                <div style="flex: 1 1 45%; min-width: 250px;">
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Folio:</strong> <span style="font-weight: 400;">{{ $folio }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Costo:</strong> <span style="font-weight: 400;">${{ number_format($cost, 2) }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Fecha:</strong> <span style="font-weight: 400;">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
                                    </p>
                                </div>

                                <!-- Información derecha -->
                                <div style="flex: 1 1 45%; min-width: 250px;">
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Origen:</strong> <span style="font-weight: 400;">{{ $origin_id }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Método de Pago:</strong> <span style="font-weight: 400;">{{ $method_id }}</span>
                                    </p>
                                    <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                        <strong>Estado:</strong> <span style="font-weight: 400;">{{ $state_id }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Información de Usuario -->
                            <div style="text-align: center; padding-top: 20px; border-top: 1px solid #e0e0e0; margin-top: 25px;">
                                <p style="font-size: 1rem; font-weight: 600; color: #333;">Usuario:</p>
                                <p style="font-size: 1.1rem; color: #555; font-weight: 400;">
                                    {{ optional(\App\Models\User::find($user_id))->name ?? 'N/A' }}
                                </p>
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
                                        <input type="text" wire:model="folio" class="form-control">
                                    </div>
                                    @error('folio') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Costo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        <input type="number" step="0.01" min="0" wire:model="cost" class="form-control">
                                    </div>
                                    @error('cost') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Fecha</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" wire:model="date" class="form-control">
                                    </div>
                                    @error('date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Origen</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="number" wire:model="origin_id" class="form-control">
                                    </div>
                                    @error('origin_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Método de pago</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                        <input type="number" wire:model="method_id" class="form-control">
                                    </div>
                                    @error('method_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Estado</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                                        <input type="number" wire:model="state_id" class="form-control">
                                    </div>
                                    @error('state_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Usuario</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <select wire:model="user_id" class="form-control">
                                            <option value="">Seleccione un usuario</option>
                                            @foreach(App\Models\User::all() as $user)
                                                <option value="{{ $user->id }}" {{ $user->id == $user_id ? 'selected' : '' }}>
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
                                <button type="button" class="btn" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="save">
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

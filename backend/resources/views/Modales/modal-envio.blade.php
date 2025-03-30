<div>
        <div>
            <!-- Botón para crear un nuevo envío -->
            <button type="button" class="btn mb-4" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="openCreateModal">
                <i class="fas fa-truck"></i> Crear Nuevo Envío
            </button>


            <div>
            <div class="modal fade" id="EnvioModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                        <div class="modal-header" style="background-color: #ff7f00; color: white; position: relative;">
                            <h5 class="modal-title" id="envioModalLabel">
                                @if($isShowMode)
                                    Detalles del Envio
                                @elseif($isEditMode)
                                    Editar Envio
                                @else
                                    Crear Envio
                                @endif
                            </h5>
                            <button type="button" class="btn" style="color: white; font-size: 1.5rem; border: none; background: none; position: absolute; top: 0; right: 0; padding: 10px;" data-bs-dismiss="modal" wire:click="closeModal">
                                &times;
                            </button>
                        </div>

                            <div class="modal-body">
                            @if($isShowMode)
    <div style="max-width: 600px; padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="color: #333; font-size: 1.6rem; font-weight: 600; letter-spacing: 0.5px;">Detalles del Envío</h2>
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px;">
            <div style="flex: 1 1 45%; min-width: 250px;">
                <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                    <strong>Remitente:</strong> <span style="font-weight: 400;">{{ $sender_name }}</span>
                </p>
                <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                    <strong>Receptor:</strong> <span style="font-weight: 400;">{{ $receiver_name }}</span>
                </p>
                <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                    <strong>Total:</strong> <span style="font-weight: 400;">{{ $total }}</span>
                </p>
                <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                    <strong>Imagen:</strong> <span style="font-weight: 400;">{{ $photo }}</span>
                </p>
            </div>
            <div style="flex: 1 1 45%; min-width: 250px;">
                <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                    <strong>Descripción:</strong> <span style="font-weight: 400;">{{ $description }}</span>
                </p>
                <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                    <strong>Ruta Unidad:</strong> <span style="font-weight: 400;">{{ \App\Models\RutaUnidad::find($route_unit_id)->id ?? 'N/A' }}</span>
                </p>
                <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                    <strong>Horario:</strong> <span style="font-weight: 400;">{{ \App\Models\Horario::find($schedule_id)->day ?? 'N/A' }}</span>
                </p>
                <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                    <strong>Ruta:</strong> <span style="font-weight: 400;">{{ \App\Models\Ruta::find($route_id)->id ?? 'N/A' }}</span>
                </p>
            </div>
        </div>
    </div>

                                <!-- Modo Editar -->
                                @elseif($isEditMode)
                                    <form wire:submit.prevent="save">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Remitente</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                    <input type="text" wire:model="sender_name" class="form-control">
                                                </div>
                                                @error('sender_name') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Receptor</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                    <input type="text" wire:model="receiver_name" class="form-control">
                                                </div>
                                                @error('receiver_name') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    <input type="text" wire:model="total" class="form-control">
                                                </div>
                                                @error('total') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Imagen</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    <input type="text" wire:model="photo" class="form-control">
                                                </div>
                                                @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Descripcion</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                                    <input type="text" wire:model="description" class="form-control">
                                                </div>
                                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ruta Unidad</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <select wire:model="route_unit_id" class="form-control">
                                                    <option value="">Seleccione una Ruta Unidad</option>
                                                    @foreach(App\Models\RutaUnidad::all() as $route_unit)
                                                        <option value="{{ $route_unit->id }}" {{ $route_unit->id == $route_unit_id ? 'selected' : '' }}>
                                                            {{ $route_unit->id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('route_unit_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Horario</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <select wire:model="schedule_id" class="form-control">
                                                    <option value="">Seleccione un Horario</option>
                                                    @foreach(App\Models\Horario::all() as $schedule)
                                                        <option value="{{ $schedule->id }}" {{ $schedule->id == $schedule_id ? 'selected' : '' }}>
                                                            {{ $schedule->day }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('schedule_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ruta</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <select wire:model="route_id" class="form-control">
                                                    <option value="">Seleccione una Ruta</option>
                                                    @foreach(App\Models\Ruta::all() as $route)
                                                        <option value="{{ $route->id }}" {{ $route->id == $route_id ? 'selected' : '' }}>
                                                            {{ $route->id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('route_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal" wire:click="closeModal">Cancelar</button>
                                            {{-- <button type="submit" class="btn btn-success" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" >Guardar Cambios</button> --}}

                                            <button type="button" class="btn btn-success" style="background-color: #ff7f00; border-color: #ff7f00; color: white;"  wire:click="showConfirmSave(true)">
                                                Guardar Cambios
                                            </button>

                                        </div>
                                    </form>

                                <!-- Modo Crear -->
                                @else
                                    <form wire:submit.prevent="save">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Remitente</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                                                    <input type="text" wire:model="sender_name" class="form-control">
                                                </div>
                                                @error('sender_name') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Receptor</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                    <input type="text" wire:model="receiver_name" class="form-control">
                                                </div>
                                                @error('receiver_name') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Total</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                    <input type="text" wire:model="total" class="form-control">
                                                </div>
                                                @error('total') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Imagen</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    <input type="text" wire:model="photo" class="form-control">
                                                </div>
                                                @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Descripcion</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                                    <input type="text" wire:model="description" class="form-control">
                                                </div>
                                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ruta Unidad</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <select wire:model="route_unit_id" class="form-control">
                                                    <option value="">Seleccione un Ruta Unidad</option>
                                                    @foreach(App\Models\RutaUnidad::all() as $route_unit)
                                                        <option value="{{ $route_unit->id }}" {{ $route_unit->id == $route_unit_id ? 'selected' : '' }}>
                                                            {{ $route_unit->id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('route_unit_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Horario</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <select wire:model="schedule_id" class="form-control">
                                                    <option value="">Seleccione un Horario</option>
                                                    @foreach(App\Models\Horario::all() as $schedule)
                                                        <option value="{{ $schedule->id }}" {{ $schedule->id == $schedule_id ? 'selected' : '' }}>
                                                            {{ $schedule->day }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('schedule_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ruta</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <select wire:model="route_id" class="form-control">
                                                    <option value="">Seleccione un Ruta</option>
                                                    @foreach(App\Models\Ruta::all() as $route)
                                                        <option value="{{ $route->id }}" {{ $route->id == $route_id ? 'selected' : '' }}>
                                                            {{ $route->id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('route_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal" wire:click="closeModal">Cancelar</button>
                                            <button type="button" class="btn btn-success" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="showConfirmSave(false)">
                                                Crear
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
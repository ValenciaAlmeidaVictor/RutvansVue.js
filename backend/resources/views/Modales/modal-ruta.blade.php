<div>
    <button type="button" class="btn mb-4" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="openCreateModal">
        <i class="fas fa-route"></i> Crear Nueva Ruta
    </button>

    <div>
        <div class="modal fade" id="rutaModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 shadow-lg" style="background-color: #f8f9fa;">
                    <div class="modal-header" style="background-color: #ff7f00; color: white; position: relative;">
                        <h5 class="modal-title" id="rutaModalLabel">
                            @if($isShowMode)
                                Detalles de la Ruta
                            @elseif($isEditMode)
                                Editar Ruta
                            @else
                                Crear Ruta
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
                                    <h2 style="color: #333; font-size: 1.6rem; font-weight: 600; letter-spacing: 0.5px;">Detalles de la Ruta</h2>
                                </div>

                                <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px;">
                                    <div style="flex: 1 1 45%; min-width: 250px;">
                                        <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                            <strong>Fare ID:</strong> <span style="font-weight: 400;">{{ $fare_id }}</span>
                                        </p>
                                        <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                            <strong>Origen Localidad:</strong> <span style="font-weight: 400;">{{ \App\Models\Localidad::find($origin_locality_id)->name ?? 'N/A' }}</span>
                                        </p>
                                        <p style="margin: 8px 0; font-size: 1rem; color: #444;">
                                            <strong>Destino Localidad:</strong> <span style="font-weight: 400;">{{ \App\Models\Localidad::find($destination_locality_id)->name ?? 'N/A' }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($isEditMode)
                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Fare ID</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            <input type="number" wire:model="fare_id" class="form-control">
                                        </div>
                                        @error('fare_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Origen Localidad</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <select wire:model="origin_locality_id" class="form-control">
                                                <option value="">Selecciona una localidad</option>
                                                @foreach(\App\Models\Localidad::all() as $localidad)
                                                    <option value="{{ $localidad->id }}" {{ $localidad->id == $origin_locality_id ? 'selected' : '' }}>{{ $localidad->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('origin_locality_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Destino Localidad</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <select wire:model="destination_locality_id" class="form-control">
                                                <option value="">Selecciona una localidad</option>
                                                @foreach(\App\Models\Localidad::all() as $localidad)
                                                    <option value="{{ $localidad->id }}" {{ $localidad->id == $destination_locality_id ? 'selected' : '' }}>{{ $localidad->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('destination_locality_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" wire:click="closeModal">Cancelar</button>
                                    <button type="button" class="btn btn-success" style="background-color: #ff7f00; border-color: #ff7f00; color: white;" wire:click="showConfirmSave(true)">
                                        Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        @else
                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Fare ID</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            <input type="number" wire:model="fare_id" class="form-control">
                                        </div>
                                        @error('fare_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Origen Localidad</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <select wire:model="origin_locality_id" class="form-control">
                                                <option value="">Selecciona una localidad</option>
                                                @foreach(\App\Models\Localidad::all() as $localidad)
                                                    <option value="{{ $localidad->id }}">{{ $localidad->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('origin_locality_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Destino Localidad</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <select wire:model="destination_locality_id" class="form-control">
                                                <option value="">Selecciona una localidad</option>
                                                @foreach(\App\Models\Localidad::all() as $localidad)
                                                    <option value="{{ $localidad->id }}">{{ $localidad->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('destination_locality_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" wire:click="closeModal">Cancelar</button>
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
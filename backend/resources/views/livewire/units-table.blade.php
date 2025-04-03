<div class="p-3 bg-light min-vh-100">
    <h1 class="h3 font-weight-bold text-dark mb-4">Unidades</h1>

    <button wire:click="openCreateModal" class="btn btn-success mb-4">
        Agregar Nueva Unidad
    </button>

    <div class="bg-white p-3 rounded shadow">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-left text-uppercase font-weight-bold">Placa</th>
                        <th class="text-left text-uppercase font-weight-bold">Capacidad</th>
                        <th class="text-left text-uppercase font-weight-bold">Marca</th>
                        <th class="text-left text-uppercase font-weight-bold">Modelo</th>
                        <th class="text-left text-uppercase font-weight-bold">Año</th>
                        <th class="text-left text-uppercase font-weight-bold">Imagen</th>
                        <th class="text-left text-uppercase font-weight-bold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                        <tr>
                            <td class="p-3">{{ $unit->plate }}</td>
                            <td class="p-3">{{ $unit->capacitance }}</td>
                            <td class="p-3">{{ $unit->brand }}</td>
                            <td class="p-3">{{ $unit->model }}</td>
                            <td class="p-3">{{ $unit->year }}</td>
                            <td class="p-3">
                                @if($unit->image)
                                    <img src="{{ asset('storage/' . $unit->image) }}" alt="Unit Image" class="img-thumbnail" width="100">
                                @else
                                    <span>No image available</span>
                                @endif
                            </td>
                            <td class="p-3">
                                <button wire:click="openModal({{ $unit->id }})" class="btn btn-warning btn-sm mr-2">Editar</button>
                                <button wire:click="delete({{ $unit->id }})" onclick="return confirm('¿Estás seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de edición -->
    @if($isModalOpen)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-labelledby="unitModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="unitModalLabel">Editar Unidad</h5>
                        <button type="button" class="close" wire:click="$set('isModalOpen', false)" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateUnit">
                            <div class="form-group">
                                <label for="plate">Placa</label>
                                <input type="text" id="plate" class="form-control" wire:model="plate" required>
                                @error('plate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="capacitance">Capacidad</label>
                                <input type="text" id="capacitance" class="form-control" wire:model="capacitance" required>
                                @error('capacitance') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="brand">Marca</label>
                                <input type="text" id="brand" class="form-control" wire:model="brand" required>
                                @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="model">Modelo</label>
                                <input type="text" id="model" class="form-control" wire:model="model" required>
                                @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="year">Año</label>
                                <input type="number" id="year" class="form-control" wire:model="year" required>
                                @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Imagen</label>
                                <input type="file" id="image" class="form-control" wire:model="image">

                                <!-- Vista previa de la imagen -->
                                <div class="mt-2">
                                    <strong>Vista previa:</strong><br>
                                    @if($image)
                                        <img class="img-thumbnail" width="100" src="{{ $image->temporaryUrl() }}" alt="Preview Image">
                                    @elseif($unit->image)
                                        <img class="img-thumbnail" width="100" src="{{ asset('storage/' . $unit->image) }}" alt="Stored Image">
                                    @else
                                        <span>No image selected</span>
                                    @endif
                                </div>
                                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de creación -->
    @if($isCreateModalOpen)
        <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog" aria-labelledby="createUnitModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUnitModalLabel">Agregar Nueva Unidad</h5>
                        <button type="button" class="close" wire:click="$set('isCreateModalOpen', false)" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="store">
                            <div class="form-group">
                                <label for="plate">Placa</label>
                                <input type="text" id="plate" class="form-control" wire:model="plate" required>
                                @error('plate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="capacitance">Capacidad</label>
                                <input type="text" id="capacitance" class="form-control" wire:model="capacitance" required>
                                @error('capacitance') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="brand">Marca</label>
                                <input type="text" id="brand" class="form-control" wire:model="brand" required>
                                @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="model">Modelo</label>
                                <input type="text" id="model" class="form-control" wire:model="model" required>
                                @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="year">Año</label>
                                <input type="number" id="year" class="form-control" wire:model="year" required>
                                @error('year') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Imagen</label>
                                <input type="file" id="image" class="form-control" wire:model="image">

                                <!-- Vista previa de la imagen -->
                                <div class="mt-2">
                                    <strong>Vista previa:</strong><br>
                                    @if($image)
                                        <img class="img-thumbnail" width="100" src="{{ $image->temporaryUrl() }}" alt="Preview Image">
                                    @endif
                                </div>
                                @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Guardar Unidad</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="p-3 bg-light min-vh-100">
    <button wire:click="openModal('create')" class="btn btn-primary mb-4">
        Crear Boleto
    </button>

    <div class="bg-white p-3 rounded shadow">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Nombre del Pasajero</th>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Total</th>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Ruta</th>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Horario</th>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Destino Intermedio</th>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Fecha</th>
                    <th class="bg-light text-left text-uppercase font-weight-bold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($boletos as $boleto)
                    <tr>
                        <td class="p-3">{{ $boleto->nombrePasajero }}</td>
                        <td class="p-3">$ {{ $boleto->total }}</td>
                        <td class="p-3">{{ $boleto->ruta->idLocalidadOrigen }}</td>
                        <td class="p-3">{{ $boleto->horario->idHorario }}</td>
                        <td class="p-3">{{ $boleto->destinoIntermedio->localidadIntermedia }}</td>
                        <td class="p-3">{{ $boleto->fecha }}</td>
                        <td class="p-3">
                            <button wire:click="openModal('edit', {{ $boleto->idBoleto }})" class="btn btn-sm btn-warning mr-2">Editar</button>
                            <button wire:click="confirmDelete({{ $boleto->idBoleto }})" class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($showModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $modalType === 'create' ? 'Crear Boleto' : 'Editar Boleto' }}
                    </h5>
                    <button type="button" wire:click="closeModal" class="close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="form-group">
                            <label>Nombre del pasajero</label>
                            <input type="text" wire:model="nombrePasajero" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Total</label>
                            <input type="number" wire:model="total" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Ruta</label>
                            <select wire:model="idRuta" class="form-control">
                                <option value="">Seleccionar Ruta</option>
                                @foreach($rutas as $ruta)
                                    <option value="{{ $ruta->idRuta }}">{{ $ruta->idRuta }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Horario</label>
                            <select wire:model="idHorario" class="form-control">
                                <option value="">Seleccionar Horario</option>
                                @foreach($horarios as $horario)
                                    <option value="{{ $horario->idHorario }}">{{ $horario->idHorario }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Destino Intermedio</label>
                            <select wire:model="idDestinoIntermedio" class="form-control">
                                <option value="">Seleccionar Destino Intermedio</option>
                                @foreach($destinosIntermedios as $destino)
                                    <option value="{{ $destino->idDestinoIntermedio }}">{{ $destino->localidadIntermedia }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" wire:model="fecha" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ $modalType === 'create' ? 'Crear' : 'Guardar' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if ($showDeleteModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Boleto</h5>
                    <button type="button" wire:click="closeModal" class="close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este boleto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancelar</button>
                    <button type="button" wire:click="delete" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<<<<<<< HEAD
<div class="container mt-4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <button wire:click="create()" class="btn btn-primary mb-3">Nueva Tarifa</button>

    @if($modal)
        <div class="modal show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content p-4 rounded shadow">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $idTipoTarifa ? 'Editar Tarifa' : 'Nueva Tarifa' }}</h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" wire:model="nombreTarifa" class="form-control">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Porcentaje</label>
                            <input type="number" wire:model="porcentajeTarifa" step="0.01" min="0" max="100" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea wire:model="descripcion" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="{{ $idTipoTarifa ? 'update' : 'store' }}" class="btn btn-success">Guardar</button>
                        <button wire:click="closeModal" class="btn btn-secondary">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <table class="table table-bordered table-striped shadow">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Porcentaje</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($TipoTarifa as $tarifa)
                <tr>
                    <td>{{ $tarifa->idTipoTarifa }}</td>
                    <td>{{ $tarifa->nombreTarifa }}</td>
                    <td>{{ $tarifa->porcentajeTarifa }}%</td>
                    <td>{{ $tarifa->descripcion }}</td>
                    <td class="text-center">
                        <button wire:click="edit({{ $tarifa->idTipoTarifa }})" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="if(confirm('¿Estás seguro de eliminar esta tarifa?')) @this.call('delete', {{ $tarifa->idTipoTarifa }})">
                            <i class="fas fa-trash"></i>
                        </button>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
=======
<div>
    {{-- Success is as dangerous as failure. --}}
>>>>>>> 3e588dd204e12255f3b31d5a1b1b6ec3434c42ea
</div>

<div>
    <!-- Botón para abrir el modal de creación -->
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#permissionsModal">
        Agregar Permiso
    </button>
<<<<<<< HEAD
    <!-- Tabla de permisos -->
    <table id="permissionsTable" class="table table-striped table-bordered">
        <thead>
            <tr>
=======
    <table id="permissionsTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
>>>>>>> f2485ef2b7cf8fc7ec4a0d0b5d0fa317ef667723
                <th>Nombre del Permiso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
<<<<<<< HEAD
                    <td>{{ $permission->name }}</td>
                    <td>
                        <button wire:click="edit({{ $permission->id }})" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editPermissionsModal">Editar</button>
                        <button wire:click="$dispatch('confirmDelete', { permissionId: {{ $permission->id }} })"
                            class="btn btn-danger">Eliminar</button>
=======
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <button wire:click="edit({{ $permission->id }})" class="btn btn-sm btn-warning">Editar</button>
                        <button wire:click="delete({{ $permission->id }})" class="btn btn-sm btn-danger">Eliminar</button>
>>>>>>> f2485ef2b7cf8fc7ec4a0d0b5d0fa317ef667723
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<<<<<<< HEAD
=======


>>>>>>> f2485ef2b7cf8fc7ec4a0d0b5d0fa317ef667723
    <!-- Incluir los modales de edición y creación -->
    @include('livewire.edit-permissions-componente')
    @include('livewire.create-permissions-componente')
</div>
<<<<<<< HEAD
=======

@push('scripts')
<!-- DataTables CSS y JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let dataTable;

        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#permissionsTable')) {
                $('#permissionsTable').DataTable().destroy();
            }
            dataTable = $('#permissionsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 5,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-MX.json" // Traducción al español
                }
            });
        }

        initDataTable(); // Inicializa DataTable al cargar la página

        Livewire.on('permissionsUpdated', () => {
            setTimeout(() => {
                initDataTable(); // 🔄 Reinicializa DataTable después de actualizar Livewire
            }, 300);
        });

        Livewire.hook('message.processed', (message, component) => {
            setTimeout(() => {
                initDataTable(); // 🔄 Reaplica DataTable cada vez que Livewire re-renderiza la tabla
            }, 300);
        });
    });
</script>


@endpush
>>>>>>> f2485ef2b7cf8fc7ec4a0d0b5d0fa317ef667723

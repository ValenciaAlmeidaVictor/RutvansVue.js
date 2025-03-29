@extends('adminlte::page')

@section('title', 'RutVans | Rutas')

@section('content_header')
    <h1>Gestión de Rutas</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Rutas</h3>
        </div>

        <div class="card-body">
            @livewire('ruta-component') @livewire('ruta-table')     </div>
    </div>

    @rappasoftTableStyles
    @rappasoftTableThirdPartyStyles
    @rappasoftTableScripts
    @rappasoftTableThirdPartyScripts
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let modalElement = document.getElementById('rutaModal');
            let rutaModal = new bootstrap.Modal(modalElement);

            Livewire.on('show-bootstrap-modal', function () {
                rutaModal.show();  // Abre el modal
            });

            Livewire.on('hide-bootstrap-modal', function () {
                rutaModal.hide();  // Cierra el modal
            });

            // Evento para mostrar detalles de la ruta
            Livewire.on('openShowRutaModal', function (ruta) {
                // Llenar los campos con los datos de la ruta
                document.getElementById('detalleNombre').innerText = ruta.nombre;
                document.getElementById('detalleFareId').innerText = ruta.fare_id;
                document.getElementById('detalleOriginLocality').innerText = ruta.origin_locality_id;
                document.getElementById('detalleDestinationLocality').innerText = ruta.destination_locality_id;

                let rutaModal = new bootstrap.Modal(document.getElementById('rutaModal'));
                rutaModal.show();  // Muestra el modal con los detalles
            });
        });
    </script>

    <script>
        Livewire.on('message', message => {
            Swal.fire({
                icon: 'success',
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>

    <script>
        Livewire.on('error', errorMessage => {
            Swal.fire({
                icon: 'error',
                title: errorMessage,
                showConfirmButton: true
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('swalConfirmDelete', (data) => {
                let id = Array.isArray(data) ? data[0] : data.id; // Extraer correctamente

                if (!id) {
                    console.error("❌ Error: ID no recibido correctamente.");
                    return;
                }

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "No podrás revertir esto.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#000",
                    confirmButtonText: "Sí, eliminar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteRuta', id);
                    }
                });
            });

            Livewire.on('swalSuccess', () => {
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "La ruta ha sido eliminada.",
                    icon: "success",
                    confirmButtonColor: "#d33",
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Escuchar el evento swalConfirm para mostrar el SweetAlert de confirmación
            Livewire.on('swalConfirmSave', (data) => {
                const isEditMode = data.isEditMode;  // Obtenemos si estamos en modo editar

                let mensaje = isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas crear esta ruta?";

                Swal.fire({
                    title: mensaje,
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#000",
                    confirmButtonText: "Sí, guardar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Disparar el evento de guardado
                        Livewire.dispatch('saveRuta'); // Usamos dispatch para llamar al método 'save'
                    }
                });
            });

            // Evento de éxito después de guardar la ruta
            Livewire.on('swalSuccessSave', () => {
                Swal.fire({
                    title: "¡Guardado!",
                    text: "La ruta se ha guardado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#d33",
                });
            });
        });
    </script>
@endsection
@extends('adminlte::page')

@section('title', ' Destinos Intermedios')

@section('content_header')
    <h1>Gestión de Destinos Intermedios</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Destinos Intermedios</h3>
        </div>

        <div class="card-body">
            @livewire('destino-intermedio-component')
            @livewire('destino-intermedio-table')
        </div>
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
            let modalElement = document.getElementById('localidadModal'); // Usa el mismo ID del modal
            let destinoIntermedioModal = new bootstrap.Modal(modalElement);

            Livewire.on('show-bootstrap-modal', function () {
                destinoIntermedioModal.show();  // Abre el modal
            });

            Livewire.on('hide-bootstrap-modal', function () {
                destinoIntermedioModal.hide();  // Cierra el modal
            });

            // Evento para mostrar detalles del destino intermedio
            Livewire.on('openShowDestinoIntermedioModal', function (destinoIntermedio) {
                // Llenar los campos con los datos del destino intermedio
                document.getElementById('detalleNombre').innerText = destinoIntermedio.nombre;
                document.getElementById('detalleRouteId').innerText = destinoIntermedio.route_id;

                let destinoIntermedioModal = new bootstrap.Modal(document.getElementById('localidadModal')); // Usa el mismo ID del modal
                destinoIntermedioModal.show();  // Muestra el modal con los detalles
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
                        Livewire.dispatch('deleteDestinoIntermedio', id);
                    }
                });
            });

            Livewire.on('swalSuccess', () => {
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "El destino intermedio ha sido eliminado.",
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

                let mensaje = isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas crear este destino intermedio?";

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
                        Livewire.dispatch('saveDestinoIntermedio'); // Usamos dispatch para llamar al método 'save'
                    }
                });
            });

            // Evento de éxito después de guardar el destino intermedio
            Livewire.on('swalSuccessSave', () => {
                Swal.fire({
                    title: "¡Guardado!",
                    text: "El destino intermedio se ha guardado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#d33", 
                });
            });
        });
    </script>
@endsection
@extends('adminlte::page')

@section('title', 'RutVans | Unidades')

@section('content_header')
    <h1>Gestión de Unidades</h1>
@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Unidades</h3>
        </div>

        <div class="card-body">
            @livewire('unidad-component')  <!-- Carga el componente de gestión de unidades -->
            @livewire('unidades-table')    <!-- Carga la tabla con las unidades -->
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
            let modalElement = document.getElementById('UnidadModal');
            let unidadModal = new bootstrap.Modal(modalElement);

            Livewire.on('show-bootstrap-modal', function () {
                unidadModal.show();  // Abre el modal
            });

            Livewire.on('hide-bootstrap-modal', function () {
                unidadModal.hide();  // Cierra el modal
            });

            // Evento para mostrar detalles de la unidad
            Livewire.on('openShowUnidadModal', function (unidad) {
                document.getElementById('detallePlaca').innerText = unidad.placa;
                document.getElementById('detalleMarca').innerText = unidad.marca;
                document.getElementById('detalleAño').innerText = unidad.año;
                document.getElementById('detalleModelo').innerText = unidad.modelo;
                document.getElementById('detalleCapacidad').innerText = unidad.capacidad;

                let unidadModal = new bootstrap.Modal(document.getElementById('UnidadModal'));
                unidadModal.show();  // Muestra el modal con los detalles
            });
        });
    </script>

    <!-- Este script escucha el mensaje de éxito enviado desde Livewire -->
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

    <!-- Este script escucha los errores enviados desde Livewire -->
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
                        Livewire.dispatch('deleteUnidad', id);
                    }
                });
            });

            Livewire.on('swalSuccess', () => {
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "La unidad ha sido eliminada.",
                    icon: "success",
                    confirmButtonColor: "#d33"
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Escuchar el evento swalConfirm para mostrar el SweetAlert de confirmación
            Livewire.on('swalConfirmSave', (data) => {
                const isEditMode = data.isEditMode;  // Obtenemos si estamos en modo editar

                let mensaje = isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas crear esta unidad?";

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
                        Livewire.dispatch('saveUnidad');
                    }
                });
            });

            // Evento de éxito después de guardar la unidad
            Livewire.on('swalSuccessSave', () => {
                Swal.fire({
                    title: "¡Guardado!",
                    text: "La unidad se ha guardado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#d33"
                });
            });
        });
    </script>
@endsection

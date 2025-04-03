@extends('adminlte::page')

@section('title', 'Unidades')

@section('content_header')
    <h1>Gestión de Unidades</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Unidades</h3>
        </div>

        <div class="card-body">
            @livewire('units-table')   <!-- Carga la tabla con las ventas -->
        </div>
    </div>

    <!-- Carga los estilos y scripts de rappasoft/laravel-livewire-tables -->
    @rappasoftTableStyles
    @rappasoftTableThirdPartyStyles
    @rappasoftTableScripts
    @rappasoftTableThirdPartyScripts
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let modalElement = document.getElementById('ventaModal');
            let ventaModal = new bootstrap.Modal(modalElement);

            Livewire.on('show-bootstrap-modal', function () {
                ventaModal.show();  // Abre el modal
            });

            Livewire.on('hide-bootstrap-modal', function () {
                ventaModal.hide();  // Cierra el modal
            });

            // Evento para mostrar detalles de la venta
            Livewire.on('openShowVentaModal', function (venta) {
                // Llenar los campos con los datos de la venta
                document.getElementById('detalleFolio').innerText = venta.folio;
                document.getElementById('detalleFecha').innerText = venta.fecha;
                document.getElementById('detalleCosto').innerText = venta.costo;

                let ventaModal = new bootstrap.Modal(document.getElementById('ventaModal'));
                ventaModal.show();  // Muestra el modal con los detalles
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                        Livewire.dispatch('deleteVenta', id);
                    }
                });
            });

            Livewire.on('swalSuccess', () => {
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "La venta ha sido eliminada.",
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

                let mensaje = isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas crear esta venta?";

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
                        Livewire.dispatch('saveVenta'); // Usamos dispatch para llamar al método 'save'
                    }
                });
            });

            // Evento de éxito después de guardar la venta
            Livewire.on('swalSuccessSave', () => {
                Swal.fire({
                    title: "¡Guardado!",
                    text: "La venta se ha guardado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#d33"
                });
            });
        });
    </script>
@endsection

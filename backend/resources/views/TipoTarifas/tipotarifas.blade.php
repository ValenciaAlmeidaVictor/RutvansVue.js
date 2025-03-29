{{-- filepath: c:\xampp\htdocs\rutvans\backend\resources\views\TipoTarifas\tipotarifas.blade.php --}}

@extends('adminlte::page')

@section('title', 'RutVans | Tipos_Tarifas')

@section('content_header')
    <h1>Gestión de Tipos de Tarifas</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Tipos de Tarifas</h3>
        </div>

        <div class="card-body">
            @livewire('tipo-tarifa-component')  <!-- Carga el componente de gestión de tipos de tarifas -->
            @livewire('tipo-tarifas-table')    <!-- Carga la tabla con los tipos de tarifas -->
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
            let modalElement = document.getElementById('tipoTarifaModal');
            let tipoTarifaModal = new bootstrap.Modal(modalElement);

            Livewire.on('show-bootstrap-modal', function () {
                tipoTarifaModal.show();  // Abre el modal
            });

            Livewire.on('hide-bootstrap-modal', function () {
                tipoTarifaModal.hide();  // Cierra el modal
            });

            // Evento para mostrar detalles del tipo de tarifa
            Livewire.on('openShowTipoTarifaModal', function (tipoTarifa) {
                // Llenar los campos con los datos del tipo de tarifa
                document.getElementById('detalleNombre').innerText = tipoTarifa.name;
                document.getElementById('detallePercentage').innerText = tipoTarifa.percentage;
                document.getElementById('detalleDescripcion').innerText = tipoTarifa.description;

                let tipoTarifaModal = new bootstrap.Modal(document.getElementById('tipoTarifaModal'));
                tipoTarifaModal.show();  // Muestra el modal con los detalles
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
                        Livewire.dispatch('deleteTipoTarifa', id);
                    }
                });
            });

            Livewire.on('swalSuccess', () => {
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "El tipo de tarifa ha sido eliminado.",
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

                let mensaje = isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas crear este tipo de tarifa?";

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
                        Livewire.dispatch('saveTipoTarifa'); // Usamos dispatch para llamar al método 'save'
                    }
                });
            });

            // Evento de éxito después de guardar el tipo de tarifa
            Livewire.on('swalSuccessSave', () => {
                Swal.fire({
                    title: "¡Guardado!",
                    text: "El tipo de tarifa se ha guardado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#d33"
                });
            });
        });
    </script>
@endsection
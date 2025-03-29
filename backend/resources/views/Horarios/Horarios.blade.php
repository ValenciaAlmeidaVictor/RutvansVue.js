@extends('adminlte::page')

@section('title', 'RutVans | Horarios')

@section('content_header')
    <h1>Gestión de Horarios</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Horarios</h3>
        </div>

        <div class="card-body">
            @livewire('horario-component')  <!-- Carga el componente de gestión de horarios -->
            @livewire('horarios-table')    <!-- Carga la tabla con los horarios -->
        </div>
    </div>

    <!-- Carga los estilos y scripts de rappasoft/laravel-livewire-tables -->
    @rappasoftTableStyles
    @rappasoftTableThirdPartyStyles
    @rappasoftTableScripts
    @rappasoftTableThirdPartyScripts
@endsection

@section('js')
    <!-- Cargar SweetAlert2 (asegúrate de incluir este script antes que cualquier otro script que lo utilice) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let modalElement = document.getElementById('horarioModal');
            let horarioModal = new bootstrap.Modal(modalElement);

            Livewire.on('show-bootstrap-modal', function () {
                horarioModal.show();  // Abre el modal
            });

            Livewire.on('hide-bootstrap-modal', function () {
                horarioModal.hide();  // Cierra el modal
            });

            // Evento para mostrar detalles del horario
            Livewire.on('openShowHorarioModal', function (horario) {
                // Llenar los campos con los datos del horario
                document.getElementById('detalleDia').innerText = horario.dia;
                document.getElementById('detalleHora').innerText = horario.hora;
                document.getElementById('detalleDescripcion').innerText = horario.descripcion;

                let horarioModal = new bootstrap.Modal(document.getElementById('horarioModal'));
                horarioModal.show();  // Muestra el modal con los detalles
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
                        Livewire.dispatch('deleteHorario', id);
                    }
                });
            });

            Livewire.on('swalSuccess', () => {
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "El horario ha sido eliminado.",
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

                let mensaje = isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas crear este horario?";

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
                        Livewire.dispatch('saveHorario'); // Usamos dispatch para llamar al método 'save'
                    }
                });
            });

            // Evento de éxito después de guardar el horario
            Livewire.on('swalSuccessSave', () => {
                Swal.fire({
                    title: "¡Guardado!",
                    text: "El horario se ha guardado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#d33", 
                });
            });
        });
    </script>
@endsection

@extends('adminlte::page')

@section('title', 'Envios')

@section('content_header')
    <h1>Gestión de Envios</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Administrar Envios</h3>
        </div>
        <div class="card-body">
            @livewire('envio-component')
            @livewire('envios-table')
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
            let modalElement = document.getElementById('EnvioModal');
            let envioModal = new bootstrap.Modal(modalElement);

            Livewire.on('show-bootstrap-modal', function () {
                envioModal.show();
            });

            Livewire.on('hide-bootstrap-modal', function () {
                envioModal.hide();
            });

            Livewire.on('openShowEnvioModal', function (envio) {
                // Asegúrate de reemplazar estos ejemplos con los campos reales de tu objeto 'envio'
                document.getElementById('detalleHorario').innerText = envio.horario || 'No disponible';
                document.getElementById('detalleNombre').innerText = envio.nombre || 'No disponible';
                document.getElementById('detalleRutaUnidad').innerText = envio.rutaunidad || 'No disponible';

                envioModal.show();
            });

            Livewire.on('swalConfirmDelete', (data) => {
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
                        Livewire.dispatch('deleteEnvio', data);
                    }
                });
            });

            Livewire.on('swalSuccess', () => {
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "El Envio ha sido eliminado.",
                    icon: "success",
                    confirmButtonColor: "#d33",
                });
            });

            Livewire.on('swalConfirmSave', (data) => {
                Swal.fire({
                    title: data.isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas registrar este Envio?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#000",
                    confirmButtonText: "Sí, guardar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('saveEnvio');
                    }
                });
            });

            Livewire.on('swalSuccessSave', () => {
                Swal.fire({
                    title: "¡Guardado!",
                    text: "El Envio se ha guardado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#d33",
                });
            });

             Livewire.on('error', errorMessage => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                });
            });
        });
    </script>
@endsection
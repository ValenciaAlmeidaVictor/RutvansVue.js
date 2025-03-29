@extends('adminlte::page')

@section('title', 'RutVans | Envios')

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let modalElement = document.getElementById('EnvioModal');
        let envioModal = new bootstrap.Modal(modalElement);

        Livewire.on('show-bootstrap-modal', function () {
            envioModal.show();  // Abre el modal
        });

        Livewire.on('hide-bootstrap-modal', function () {
            envioModal.hide();  // Cierra el modal
        });

        Livewire.on('openShowEnvioModal', function (envio) {
            // Aquí puedes añadir los detalles específicos que quieres mostrar del 'envio'
            // document.getElementById('detalleHorario').innerText = envio.horario;
            // document.getElementById('detalleNombre').innerText = envio.nombre;
            // document.getElementById('detalleRutaUnidad').innerText = envio.rutaunidad;

            let envioModal = new bootstrap.Modal(document.getElementById('EnvioModal'));
            envioModal.show();  // Muestra el modal con los detalles
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                    Livewire.dispatch('deleteEnvio', id);
                }
            });
        });

        Livewire.on('swalSuccess', () => {
            Swal.fire({
                title: "¡Eliminado!",
                text: "El Envio ha sido eliminado.",
                icon: "success"
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

            let mensaje = isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas registrar este Envio?";

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
                    Livewire.dispatch('saveEnvio');
                }
            });
        });

        Livewire.on('swalSuccessSave', () => {
            Swal.fire({
                title: "¡Guardado!",
                text: "El Envio se ha guardado correctamente.",
                icon: "success"
                confirmButtonColor: "#d33", 
            });
        });
    });
</script>

@endsection

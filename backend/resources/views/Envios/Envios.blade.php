@extends('adminlte::page')

@section('title', 'Envios')

@section('content_header')
    <h1>Gestión de Envios</h1>

@endsection

@section('content')




    <div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Administrar Envios</h3>
            </div>
            <div class="card-body">
                @livewire('envio-component')



                @livewire('envios-table')  <!-- Asegúrate de que el componente exista -->
            </div>
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
            console.log('show-bootstrap-modal event triggered');
            envioModal.show();  // Muestra el modal
        });

        Livewire.on('hide-bootstrap-modal', function () {
            console.log('hide-bootstrap-modal event triggered');
            envioModal.hide();  // Cierra el modal
        });

        // ✅ Evento para abrir el modal y asignar datos correctamente
        Livewire.on('openShowEnvioModal', function (envio) {
            console.log('✅ Evento openShowEnvioModal recibido con data:', envio);  // Log para ver todos los datos

            // 🔹 Extraer correctamente el objeto si viene dentro de un array
            if (Array.isArray(envio)) {
                envio = envio[0];
            }

            if (!envio || typeof envio !== 'object') {
                console.error("❌ Error: Datos de envio no recibidos correctamente.");
                return;
            }

            console.log('📌 Datos extraídos:', envio);  // Muestra todos los datos

            // Asignar valores al modal
            document.getElementById('detalleHorario').innerText = envio.horario || 'No disponible';
            document.getElementById('detalleNombre').innerText = envio.nombre || 'No disponible';
            document.getElementById('detalleRutaUnidad').innerText = envio.rutaunidad || 'No disponible';

            // Si tienes más campos, puedes asignarlos aquí, por ejemplo:
            // document.getElementById('detalleOtroCampo').innerText = envio.otroCampo || 'No disponible';

            envioModal.show();  // ✅ Mostrar el modal con los detalles
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('swalConfirmDelete', (data) => {
            console.log('swalConfirmDelete event triggered with data:', data);

            // 🔹 Extraer correctamente el ID si viene dentro de un array
            if (Array.isArray(data)) {
                data = data[0];
            }

            let id = data?.id; // Extraer el id si está presente

            if (!id) {
                console.error("❌ Error: ID no recibido correctamente.");
                return;
            }

            console.log('🗑️ ID recibido para eliminación:', id);

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
            console.log('swalSuccess event triggered');
            Swal.fire({
                title: "¡Eliminado!",
                text: "El Envio ha sido eliminado.",
                icon: "success",
                confirmButtonColor: "#d33",
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('swalConfirmSave', (data) => {
            console.log('💾 Evento swalConfirmSave recibido con data:', data);

            // 🔹 Extraer correctamente el objeto si viene dentro de un array
            if (Array.isArray(data)) {
                data = data[0];
            }

            if (!data || typeof data !== 'object') {
                console.error("❌ Error: Datos no recibidos correctamente.");
                return;
            }

            console.log('📌 Datos extraídos:', data);

            Swal.fire({
                title: data.isEditMode ? "¿Deseas guardar los cambios?" : "¿Deseas registrar este Envio?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#d33", 
                cancelButtonColor: "#000", 
                confirmButtonText: "Sí, guardar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('saveEnvio', data);
                }
            });
        });

        Livewire.on('swalSuccessSave', () => {
            console.log('swalSuccessSave event triggered');
            Swal.fire({
                title: "¡Guardado!",
                text: "El Envio se ha guardado correctamente.",
                icon: "success",
                confirmButtonColor: "#d33",
            });
        });
    });
</script>

@endsection
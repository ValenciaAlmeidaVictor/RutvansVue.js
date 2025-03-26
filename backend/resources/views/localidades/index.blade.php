@extends('adminlte::page')

@section('title', 'Rutas')

@section('content_header')
    <h1>Rutas</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title m-0">Administra tus rutas</h3>
        </div>
        <div class="card-body">
            <!-- Contenedor del mapa -->
            <div id="map"
                style="width: 100%; height: 500px; position: relative; border: 2px solid #007BFF; border-radius: 10px;">
            </div>

            <!-- Incluir el formulario -->
            @include('localidades.create')
        </div>
    </div>
@endsection
@section('css')
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
    <style>
        .swal-toast {
            font-size: 14px;
            /* Tamaño de texto más pequeño */
            border-radius: 8px;
            /* Bordes redondeados */
            padding: 10px;
            /* Ajuste del relleno */
            background-color: #007BFF;
            /* Color de fondo */
            color: white;
            /* Color del texto */
        }
    </style>
@endsection

@section('js')
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            mapboxgl.accessToken =
                'pk.eyJ1IjoiYW5nZWwwNDE4IiwiYSI6ImNtOG5idHFybzBob3EyaW85NmkxYXZub3EifQ.m1qJwwbbT_wyOqPtDFGb7A';

            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [-89.5133, 20.9256],
                zoom: 8
            });

            let currentMarker = null;

            // Mostrar mensaje de éxito o error desde el controlador
            const successMessage = '{{ session('success') }}';
            const errorMessage = '{{ session('error') }}';

            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: successMessage,
                    toast: true,
                    position: 'bottom-end',
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: errorMessage,
                    toast: true,
                    position: 'bottom-end',
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            // Agregar marcadores para las localidades guardadas
            const savedLocations = @json($localidades);

            savedLocations.forEach(location => {
                const customMarker = document.createElement('div');
                customMarker.style.backgroundColor = '#FF5733';
                customMarker.style.width = '20px';
                customMarker.style.height = '20px';
                customMarker.style.borderRadius = '50%';

                const marker = new mapboxgl.Marker({
                        element: customMarker,
                        draggable: true // Hacer los marcadores guardados arrastrables
                    })
                    .setLngLat([location.longitude, location.latitude])
                    .setPopup(new mapboxgl.Popup().setText(
                        `${location.locality}, ${location.street}, ${location.postal_code}`
                    ))
                    .addTo(map);

                // Evento: Cuando el marcador deja de arrastrarse
                marker.on('dragend', async function() {
                    const newCoords = marker.getLngLat();
                    console.log(`Marcador movido. ID: ${location.id}, Nueva posición:`,
                        newCoords);

                    // Obtener datos nuevos para localidad
                    const url =
                        `https://api.mapbox.com/geocoding/v5/mapbox.places/${newCoords.lng},${newCoords.lat}.json?access_token=${mapboxgl.accessToken}`;
                    let updatedStreet = location.street;
                    let updatedLocality = location.locality;
                    let updatedPostalCode = location.postal_code;

                    try {
                        const response = await fetch(url);
                        const data = await response.json();
                        if (data.features.length > 0) {
                            const place = data.features[0];
                            updatedStreet = place.text || location.street;
                            updatedLocality = place.context?.find(c => c.id.includes('place'))
                                ?.text || location.locality;
                            updatedPostalCode = place.context?.find(c => c.id.includes(
                                'postcode'))?.text || location.postal_code;
                        }
                    } catch (error) {
                        console.error('Error obteniendo datos actualizados:', error);
                    }

                    // Mostrar la alerta de confirmación con los valores actuales y nuevos
                    Swal.fire({
                        title: '¿Estás seguro?',
                        html: `
                    <p><b>Localidad Actual:</b> ${location.locality}</p>
                    <p><b>Nueva Localidad:</b> ${updatedLocality}</p>
                    <p><b>Calle Actual:</b> ${location.street}</p>
                    <p><b>Calle Nueva:</b> ${updatedStreet}</p>
                    <p><b>Código Postal Actual:</b> ${location.postal_code}</p>
                    <p><b>Código Postal Nuevo:</b> ${updatedPostalCode}</p>
                `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, actualizar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Enviar los datos al servidor
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `{{ url('localidades') }}/${location.id}`;
                            form.innerHTML = `
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="longitude" value="${newCoords.lng}">
                        <input type="hidden" name="latitude" value="${newCoords.lat}">
                        <input type="hidden" name="locality" value="${updatedLocality}">
                        <input type="hidden" name="street" value="${updatedStreet}">
                        <input type="hidden" name="postal_code" value="${updatedPostalCode}">
                    `;
                            document.body.appendChild(form);
                            form.submit();
                        } else {
                            marker.setLngLat([location.longitude, location.latitude]);
                        }
                    });
                });
            });

            // Evento: Seleccionar una nueva ubicación en el mapa
            map.on('click', async function(e) {
                const coordinates = e.lngLat;

                // Eliminar marcador previo si existe
                if (currentMarker) {
                    currentMarker.remove();
                }

                // Crear un nuevo marcador en la nueva ubicación
                currentMarker = new mapboxgl.Marker({
                        color: '#007BFF'
                    })
                    .setLngLat(coordinates)
                    .addTo(map);

                const url =
                    `https://api.mapbox.com/geocoding/v5/mapbox.places/${coordinates.lng},${coordinates.lat}.json?access_token=${mapboxgl.accessToken}`;

                try {
                    const response = await fetch(url);
                    const data = await response.json();

                    if (data.features.length > 0) {
                        const place = data.features[0];
                        const street = place.text || 'N/A';
                        const locality = place.context?.find(c => c.id.includes('place'))?.text ||
                        'N/A';
                        const postalCode = place.context?.find(c => c.id.includes('postcode'))?.text ||
                            'N/A';

                        // Autollenar el formulario con los datos del marcador
                        document.getElementById('longitude').value = coordinates.lng;
                        document.getElementById('latitude').value = coordinates.lat;
                        document.getElementById('locality').value = locality;
                        document.getElementById('street').value = street;
                        document.getElementById('postal_code').value = postalCode;
                    }
                } catch (error) {
                    console.error('Error obteniendo la ubicación:', error);
                }
            });
        });
    </script>
@endsection

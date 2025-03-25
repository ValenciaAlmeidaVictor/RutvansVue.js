<div class="container">
    <!-- Contenedor del mapa -->
    <div id="map" class="map-container" wire:key="map"></div>

    <!-- Contenedor de los inputs -->
    <div class="form-container">
        <div class="form-column">
            <label for="longitude">Longitud:</label>
            <input type="text" id="longitude" wire:model="longitude" readonly>

            <label for="latitude">Latitud:</label>
            <input type="text" id="latitude" wire:model="latitude" readonly>

            <label for="locality">Localidad:</label>
            <input type="text" id="locality" wire:model="locality" readonly>
        </div>

        <div class="form-column">
            <label for="street">Calle:</label>
            <input type="text" id="street" wire:model="street" readonly>

            <label for="postal_code">Código Postal:</label>
            <input type="text" id="postal_code" wire:model="postal_code" readonly>

            <button id="save-location" wire:click="saveLocation">Guardar Ubicación</button>
        </div>
    </div>


<script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        mapboxgl.accessToken = 'pk.eyJ1IjoiYW5nZWwwNDE4IiwiYSI6ImNtOG5idHFybzBob3EyaW85NmkxYXZub3EifQ.m1qJwwbbT_wyOqPtDFGb7A';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-89.5133, 20.9256],  
            zoom: 8 
        });

        let marker = null;
        let coordinates = null;
        let locality = '';
        let street = '';
        let postalCode = '';

        map.on('click', async function(e) {
            coordinates = e.lngLat;

            if (marker) {
                marker.remove();
            }

            marker = new mapboxgl.Marker()
                .setLngLat(coordinates)
                .addTo(map);

            const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${coordinates.lng},${coordinates.lat}.json?access_token=${mapboxgl.accessToken}`;
            
            try {
                const response = await fetch(url);
                const data = await response.json();
                
                if (data.features.length > 0) {
                    const place = data.features[0];
                    street = place.text || 'N/A';
                    locality = place.context?.find(c => c.id.includes('place'))?.text || 'N/A';
                    postalCode = place.context?.find(c => c.id.includes('postcode'))?.text || 'N/A';

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

        document.getElementById("save-location").addEventListener('click', function() {
            if (coordinates) {
                @this.set('longitude', coordinates.lng);
                @this.set('latitude', coordinates.lat);
                @this.set('locality', locality);
                @this.set('street', street);
                @this.set('postal_code', postalCode);

                // Recargar la página después de guardar
                setTimeout(() => {
                    location.reload();
                }, 1000); // Espera 1 segundo antes de recargar
            }
        });
    });
</script>

<style>
    .container {
        display: flex;
        gap: 20px;
        align-items: flex-start;
        margin-top: 15px;
    }

    .map-container {
        width: 60%;
        height: 500px;
        border-radius: 8px;
    }

    .form-container {
        width: 35%;
        padding: 15px;
        border-radius: 8px;
        background: #f9f9f9;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .form-column {
        flex: 1;
        min-width: 150px;
    }

    label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
        font-size: 14px;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: #fff;
        font-size: 14px;
    }

    button {
        width: 100%;
        margin-top: 20px;
        padding: 10px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #0056b3;
    }
</style>
</div>
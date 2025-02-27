<template>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Tipos de Tarifa</h1>

        <!-- Spinner de carga -->
        <div v-if="loading" class="d-flex justify-content-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <!-- Vista con tarjetas en una sola fila -->
        <div v-else>
            <div v-if="tipoTarifa.length > 0" class="tarifas-container">
                <div v-for="tarifa in tipoTarifa" :key="tarifa.nombreTarifa" class="tarifa-card">
                    <div class="card-body">
                        <h5 class="card-title">{{ tarifa.nombreTarifa }}</h5>
                        <p class="card-text"><strong>Porcentaje:</strong> {{ tarifa.porcentajeTarifa }}%</p>
                        <p class="card-text"><strong>Descripción:</strong> {{ tarifa.descripcion }}</p>
                    </div>
                </div>
            </div>

            <!-- Mensaje si no hay datos -->
            <div v-else class="alert alert-warning text-center">
                <p>No se encontraron tarifas.</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            tipoTarifa: [],
            loading: true,
        };
    },
    mounted() {
        this.fetchTipoTarifa();
    },
    methods: {
        async fetchTipoTarifa() {
            try {
                const response = await axios.get("http://localhost:8000/api/tipo-oferta");

                if (response.data && response.data.datos === 200) {
                    this.tipoTarifa = response.data.TipoTarifa || [];
                } else {
                    console.error("Respuesta inesperada de la API:", response.data);
                }
            } catch (error) {
                console.error("Error al obtener los datos:", error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

<style scoped>
h1 {
    font-size: 1.8rem;
    font-weight: bold;
    color: #ffffff;
}

/* Contenedor para las tarjetas */
.tarifas-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px; /* Espacio entre tarjetas */
}

/* Estilización de las tarjetas */
.tarifa-card {
    width: 250px;
    border-radius: 12px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

    padding: 20px;
    text-align: center;
}

.tarifa-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.card-title {
    font-weight: bold;
    color: #007bff;
}
</style>

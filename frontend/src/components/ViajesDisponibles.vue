<template>
  <div class="viajes-disponibles">
    <h1>Viajes Disponibles</h1>
    
    <div v-if="loading" class="loading">Cargando viajes...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else-if="viajes.length === 0" class="no-viajes">
      No hay viajes disponibles para hoy
    </div>
    
    <div v-else class="tarjetas-container">
      <div v-for="(viaje, index) in viajes" :key="index" class="tarjeta-container">
        <div class="tarjeta">
          <img :src="viaje.imagen || 'https://images.sipse.com/-EdvJzm23lm24Bjc7YwYmuLK1OI=/724x500/smart/2021/08/29/1630260268379.jpg'" :alt="viaje.origen" class="viaje-imagen" />
          <div class="viaje-info">
            <div class="horario">
              <img src="https://www.ado.com.mx/images/distance-icon.svg" alt="Ruta" class="icono-ruta" />
              <div class="texto-horario">
                <p>{{ viaje.horaSalida }} - {{ viaje.origen }}</p>
                <p>{{ viaje.horaLlegada }} - {{ viaje.destino }}</p>
              </div>
            </div>
          </div>
          <div class="viaje-acciones">
            <button @click="() => irASeleccionAsiento(viaje)" class="btn-escoger">
              Escoger asiento
            </button>
            <span @click="toggleDetalles(index)" class="texto-detalles">
              {{ viaje.mostrarDetalles ? 'Ocultar detalles' : 'Ver detalles' }}
            </span>
          </div>
        </div>
        
        <div v-if="viaje.mostrarDetalles" class="detalles-panel">
          <div class="detalles-item">
            <strong>Conductor:</strong> {{ viaje.conductor }}
          </div>
          <div class="detalles-item">
            <strong>Modelo:</strong> {{ viaje.modeloUnidad }}
          </div>
          <div class="detalles-item">
            <strong>Placas:</strong> {{ viaje.placas }}
          </div>
          <div class="detalles-item">
            <strong>Capacidad:</strong> {{ viaje.capacidad }} asientos
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '@/api';

const router = useRouter();
const viajes = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchViajes = async () => {
  try {
    loading.value = true;
    const { data } = await api.get('/viajes');
    viajes.value = data.map(viaje => ({
      ...viaje,
      mostrarDetalles: false
    }));
  } catch (err) {
    error.value = 'Error al cargar los viajes disponibles';
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const irASeleccionAsiento = (viaje) => {
  router.push({ 
    name: 'VentaAsientos',
    query: {
      routeUnitId: viaje.id,
      origen: viaje.origen,
      destino: viaje.destino,
      fecha: viaje.fecha,
      hora_salida: viaje.horaSalida,
      imagen: viaje.imagen
    }
  });
};

const toggleDetalles = (index) => {
  viajes.value[index].mostrarDetalles = !viajes.value[index].mostrarDetalles;
};

onMounted(() => {
  fetchViajes();
});
</script>
<style scoped>
/* Estilos anteriores (sin cambios) */
.loading {
  padding: 20px;
  text-align: center;
  color: #666;
  font-style: italic;
}

.error {
  padding: 15px;
  text-align: center;
  background-color: #ffeeee;
  color: #f83030;
  border-radius: 5px;
  margin: 10px 0;
  font-weight: bold;
}

.viajes-disponibles {
  padding: 20px;
  background-color: white;
  min-height: 100vh;
  width: 100%;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 1.5rem;
  color: #f83030;
}

.tarjetas-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
}

.tarjeta-container {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.tarjeta {
  background-color: #ffffff;
  border-radius: 10px 10px 0 0;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 20px;
  min-height: 100px;
  

}

.viaje-imagen {
  width: 150px;
  height: 100px;
  border-radius: 8px;
  object-fit: cover;
}

.viaje-info {
  flex: 1;
}

.horario {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  justify-content: flex-start;
}

.icono-ruta {
  width: 15px;
  height: auto;
}

.texto-horario {
  display: flex;
  flex-direction: column;
  gap: 5px;
  text-align: left;
}

.texto-horario p {
  margin: 0;
  font-size: 1rem;
  color: #2c3e50;
  white-space: nowrap;
}

.viaje-acciones {
  display: flex;
  flex-direction: column;
  gap: 10px;
  align-items: flex-end;
  margin-top: 15px;
}

.btn-escoger {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 0.9rem;
  background-color: #f48530;
  color: white;
}

.btn-escoger:hover {
  background-color: #f8a830;
}

.texto-detalles {
  text-decoration: underline;
  color: #707374;
  cursor: pointer;
  font-size: 0.9rem;
  text-align: right;
}

.texto-detalles:hover {
  color: #020202;
}

/* Nuevos estilos para el panel de detalles */
.detalles-panel {
  width: 100%;
  padding: 15px 20px;
  background-color: #f59d54; /* Fondo más suave */
  border-radius: 0 0 10px 10px;
  font-size: 0.9rem;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-top: 1px solid #ddd;
  display: flex;
  flex-wrap: wrap; /* Permite que los elementos se envuelvan si no caben */
  gap: 15px; /* Espacio entre elementos */
}

.detalles-item {
  flex: 1; /* Distribuye el espacio uniformemente */
  min-width: 150px; /* Ancho mínimo para evitar que se compriman demasiado */
  color: #f9f9f9; /* Color de texto más suave */
}

.detalles-item strong {
  color: #020202; /* Color más oscuro para las etiquetas */
}

.no-viajes {
  padding: 20px;
  text-align: center;
  background-color: #fff3cd;
  color: #856404;
  border-radius: 5px;
  margin: 20px auto;
  max-width: 500px;
}
</style>
<template>
  <div class="available-tickets">
    <!-- Tarjeta horizontal -->
    <div class="ticket-card">
      <div class="ticket-image-container">
        <img :src="viajeInfo.imagen || 'https://cdn-icons-png.flaticon.com/512/75/75648.png'" alt="Asiento" class="ticket-image" />
      </div>
      <div class="separator"></div>
      <div class="ticket-info">
        <p class="passenger-label">Pasajero -</p>
        <select 
          v-model="selectedFareType" 
          class="passenger-select" 
          @change="handleFareTypeChange"
        >
          <option 
            v-for="tarifa in fareTypes" 
            :key="tarifa.id"
            :value="tarifa"
          >
            {{ tarifa.name }} ({{ tarifa.percentage }}%)
          </option>
        </select>
      </div>
      <div class="ticket-price-container">
        <p class="ticket-price">Precio ${{ currentPrice }} MXN</p>
        <p class="remaining-seats">Asientos restantes: {{ remainingSeats }}</p>
      </div>
    </div>

    <!-- Sección de asientos -->
    <div class="seat-layout">
      <h2>Selecciona tu asiento</h2>
      
      <div v-if="loading" class="loading">Cargando asientos disponibles...</div>
      <div v-else-if="error" class="error">{{ error }}</div>
      
      <div v-else class="seat-map">
        <div
          v-for="seat in seats"
          :key="seat.id"
          :class="['seat', seat.status, { selected: seat.selected }]"
          @click="selectSeat(seat)"
        >
          <span class="seat-number">{{ seat.seatNumber }}</span>
        </div>
      </div>

      <!-- Leyenda de asientos -->
      <div class="legend">
        <div class="legend-item">
          <div class="seat selected"></div>
          <span>Seleccionado</span>
        </div>
        <div class="legend-item">
          <div class="seat occupied"></div>
          <span>Ocupado</span>
        </div>
        <div class="legend-item">
          <div class="seat available"></div>
          <span>Disponible</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import api from '@/api';

const route = useRoute();
const emit = defineEmits(['fare-type-changed', 'seat-selected']);

// Estado del componente
const selectedFareType = ref(null);
const seats = ref([]);
const fareTypes = ref([]);
const loading = ref(false);
const error = ref(null);
const viajeInfo = ref({
  imagen: '',
  precio_base: 0,
  origen: '',
  destino: '',
  fecha: '',
  hora_salida: ''
});

const props = defineProps({
  viajeInfo: {
    type: Object,
    default: () => ({})
  }
});

// Obtener tipos de tarifas desde la API
const fetchFareTypes = async () => {
  try {
    const { data } = await api.get('/viajes/tipos-tarifas');
    fareTypes.value = data;
    if (data.length > 0) {
      selectedFareType.value = data[0];
    }
  } catch (err) {
    console.error('Error al obtener tipos de tarifas:', err);
    error.value = 'Error al cargar tipos de pasajeros';
  }
};

// Obtener asientos desde la API
const fetchAsientos = async (routeUnitId) => {
  try {
    loading.value = true;
    error.value = null;
    
    // Obtener asientos
    const { data: asientos } = await api.get(`/asientos/${routeUnitId}`);
    seats.value = asientos;
    
    // Obtener información del viaje
    const { data: info } = await api.get(`/viajes/info/${routeUnitId}`);
    viajeInfo.value = info;
    
  } catch (err) {
    console.error('Error al obtener asientos:', err);
    error.value = 'No se pudieron cargar los asientos disponibles';
    seats.value = [];
  } finally {
    loading.value = false;
  }
};

// Precio calculado según tipo de tarifa
const currentPrice = computed(() => {
  if (!selectedFareType.value || !viajeInfo.value.precio_base) return 0;
  
  return (viajeInfo.value.precio_base * (1 - selectedFareType.value.percentage / 100)).toFixed(2);
});

// Asientos restantes
const remainingSeats = computed(() => {
  return seats.value.filter(seat => seat.status === 'available').length;
});

// Seleccionar asiento
const selectSeat = (seat) => {
  if (seat.status === 'available') {
    // Deseleccionar todos los asientos primero
    seats.value.forEach(s => s.selected = false);
    // Seleccionar el asiento actual
    seat.selected = true;
    // Emitir evento con toda la información necesaria
    emit('seat-selected', {
      seat,
      fareType: selectedFareType.value,
      price: currentPrice.value,
      viajeInfo: viajeInfo.value
    });
  }
};

// Emitir cambio de tipo de tarifa
const handleFareTypeChange = () => {
  emit('fare-type-changed', {
    type: selectedFareType.value,
    price: currentPrice.value
  });
};

// Cargar datos al montar el componente
onMounted(() => {
  fetchFareTypes();
  if (route.query.routeUnitId) {
    fetchAsientos(route.query.routeUnitId);
  }
});
</script>

<style scoped>
/* Tus estilos existentes se mantienen igual */
.available-tickets {
  padding: 20px;
}

.ticket-card {
  display: flex;
  align-items: center;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 20px;
  gap: 20px;
}

.ticket-image-container {
  width: 150px;
  height: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f8f9fa;
  border-radius: 8px;
  overflow: hidden;
}

.ticket-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.separator {
  width: 1px;
  height: 80px;
  background-color: #ddd;
}

.ticket-info {
  display: flex;
  align-items: center;
  gap: 10px;
}

.passenger-label {
  font-size: 1rem;
  color: #2c3e50;
  margin: 0;
}

.passenger-select {
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
  color: #2c3e50;
  background-color: #fff;
  cursor: pointer;
  min-width: 150px;
}

.ticket-price-container {
  margin-left: auto;
  text-align: right;
}

.ticket-price {
  font-size: 1.25rem;
  font-weight: bold;
  color: #f39c12;
  margin: 0;
}

.remaining-seats {
  font-size: 0.9rem;
  color: #666;
  margin: 5px 0 0;
}

.seat-layout {
  margin-top: 30px;
  text-align: center;
}

.seat-map {
  display: grid;
  grid-template-columns: repeat(5, 50px);
  gap: 15px;
  justify-content: center;
  margin-top: 20px;
}

.seat {
  width: 50px;
  height: 50px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  cursor: pointer;
  border: 2px solid #ccc;
  transition: all 0.2s ease;
}

.available {
  background-color: #e0e0e0;
}

.available:hover {
  background-color: #d0d0d0;
}

.occupied {
  background-color: #9e9e9e;
  cursor: not-allowed;
}

.selected {
  background-color: #f39c12;
  color: white;
  border-color: #e67e22;
}

.legend {
  display: flex;
  justify-content: center;
  margin-top: 20px;
  gap: 15px;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 0.9rem;
}

.legend-item .seat {
  width: 20px;
  height: 20px;
}

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
</style>
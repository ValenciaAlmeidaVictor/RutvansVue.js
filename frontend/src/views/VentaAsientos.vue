<template>
  <div class="punto-venta">
    <div class="contenido-punto-venta">
      <div class="boletos-section">
        <AvailableTickets
          :viajeInfo="viajeInfo"
          @fare-type-changed="handleFareTypeChange"
          @seat-selected="handleSeatSelected"
        />
      </div>
      <div class="carrito-section">
        <ShoppingCart
          :selectedFareType="selectedFareType"
          :isSeatSelected="isSeatSelected"
          :selectedSeat="selectedSeat"
          :viajeInfo="viajeInfo"
        />
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import AvailableTickets from '@/components/AvailableTickets.vue';
import ShoppingCart from '@/components/ShoppingCart.vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const selectedFareType = ref(null);
const isSeatSelected = ref(false);
const selectedSeat = ref(null);
const viajeInfo = ref({
  origen: '',
  destino: '',
  fecha: '',
  hora_salida: '',
  precio_base: 0,
  imagen: ''
});

const handleFareTypeChange = ({ type, price }) => {
  selectedFareType.value = type;
};

const handleSeatSelected = ({ seat, fareType, viajeInfo: info }) => {
  isSeatSelected.value = true;
  selectedSeat.value = seat;
  selectedFareType.value = fareType;
  viajeInfo.value = info;
};

onMounted(() => {
  if (route.query.routeUnitId) {
    viajeInfo.value = {
      origen: route.query.origen || '',
      destino: route.query.destino || '',
      fecha: route.query.fecha || '',
      hora_salida: route.query.hora_salida || '',
      precio_base: Number(route.query.precio_base) || 0,
      imagen: route.query.imagen || ''
    };
  }
});
</script>
<style scoped>
  .punto-venta {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    color: #2c3e50;
    display: flex;
    flex-direction: column;
    padding: 20px;
    background-color: #f8f9fa;
    min-height: 100vh;
    width: 100%;
  }
  
  .contenido-punto-venta {
    display: flex;
    gap: 40px; /* Espacio entre las secciones de boletos y carrito */
    max-width: 1400px; /* Ancho máximo del contenedor */
    margin: 0 auto; /* Centrar el contenedor */
    width: 100%;
    padding: 0 20px; /* Añadir padding para equilibrar el espacio */
  }
  
  .boletos-section {
    flex: 3; /* Ocupa 3 partes del espacio disponible */
    max-width: 900px; /* Ancho máximo para la sección de boletos */
  }
  
  .carrito-section {
    flex: 1; /* Ocupa 1 parte del espacio disponible */
    max-width: 400px; /* Ancho máximo para la sección del carrito */
  }
  
  .titulo-boletos {
    text-align: left; /* Alinea el título a la izquierda */
    margin-bottom: 10px;
    font-size: 1.5rem;
    color: #2c3e50;
    text-transform: uppercase;
  }
  
  .separador {
    width: 100%;
    height: 2px;
    background-color: #f39c12; /* Color naranja para el separador */
    margin-bottom: 20px;
  }
</style>
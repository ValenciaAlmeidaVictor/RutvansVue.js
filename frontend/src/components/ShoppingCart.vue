<template>
  <div class="cart">
    <!-- Encabezado -->
    <div class="cart-header">
      <h2>Resumen de viaje</h2>
      <div class="header-content">
        <img :src="viajeInfo.imagen || 'https://images.sipse.com/-EdvJzm23lm24Bjc7YwYmuLK1OI=/724x500/smart/2021/08/29/1630260268379.jpg'" 
            alt="Viaje" class="header-image" />
        <div class="header-info">
          <p>{{ viajeInfo.fecha }} - {{ viajeInfo.hora_salida }}</p>
          <p><strong>Origen:</strong> {{ viajeInfo.origen }}</p>
          <p><strong>Destino:</strong> {{ viajeInfo.destino }}</p>
          <p v-if="selectedSeat"><strong>Asiento:</strong> {{ selectedSeat.seatNumber }}</p>
        </div>
      </div>
    </div>
    <div class="header-separator"></div>

    <!-- Cuerpo -->
    <div class="cart-body">
      <div class="cart-item">
        <p>Costo de viaje:</p>
        <p>${{ basePrice }} MXN</p>
      </div>
      <div class="cart-item">
        <p>Subtotal:</p>
        <p>${{ basePrice }} MXN</p>
      </div>
      <div class="cart-item">
        <p>Descuento:</p>
        <p>-${{ discount }} MXN</p>
      </div>
      <div class="body-separator"></div>
      <div class="cart-item total">
        <p>Total:</p>
        <p>${{ total }} MXN</p>
      </div>
    </div>

    <!-- Pie -->
    <div class="cart-footer">
      <button :disabled="!isSeatSelected" @click="irAFormTicket"  class="continue-btn">Continuar</button>
    </div>
  </div>
</template>
<script setup>
import { computed } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const props = defineProps({
  selectedFareType: Object,
  isSeatSelected: Boolean,
  selectedSeat: Object,
  viajeInfo: Object
});

const discount = computed(() => {
  if (!props.selectedFareType) return 0;
  return (props.viajeInfo.precio_base * (props.selectedFareType.percentage / 100)).toFixed(2);
});

const total = computed(() => {
  return (props.viajeInfo.precio_base - discount.value).toFixed(2);
});

const irAFormTicket = () => {
  router.push({
    name: 'FormTicket',
    query: {
      type: props.selectedFareType.name,
      price: total.value,
      discount: discount.value,
      seatSelected: props.isSeatSelected,
      seatNumber: props.selectedSeat.seatNumber,
      origen: props.viajeInfo.origen,
      destino: props.viajeInfo.destino,
      fecha: props.viajeInfo.fecha,
      hora: props.viajeInfo.hora_salida
    }
  });
};
</script>
<style scoped>
.cart {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  min-height: 600px;
  display: flex;
  flex-direction: column;
}

/* Encabezado */
.cart-header {
  background-color: #f8f9fa; /* Fondo ligeramente más oscuro */
  border-radius: 10px 10px 0 0; /* Bordes redondeados solo en la parte superior */
  padding: 15px; /* Espaciado interno */
  width: 100%; /* Ocupar todo el ancho disponible */
  box-sizing: border-box; /* Incluir el padding en el ancho total */
  margin: 0; /* Eliminar márgenes */
}

.cart-header h2 {
  text-align: left;
  margin-bottom: 15px;
  font-size: 1.5rem;
  color: #2c3e50;
}

.header-content {
  display: flex;
  align-items: center;
  gap: 20px;
  padding: 20px;
}

.header-image {
  width: 120px;
  height: 100px;
  border-radius: 10px;
  object-fit: cover;
}

.header-info {
  flex: 1;
}

.header-info p {
  margin: 5px 0;
  font-size: 0.9rem;
  color: #555;
}

.header-separator {
  width: 100%;
  height: 1px;
  background-color: #ddd;
  margin-bottom: 10px;
}

/* Cuerpo */
.cart-body {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 20px;
  gap: 15px;
}

.cart-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 0;
}

.cart-item p {
  margin: 0;
  font-size: 0.9rem;
  color: #020202;
}

.cart-item.total p {
  font-size: 1.1rem;
  font-weight: bold;
  color: #2c3e50;
}

.body-separator {
  width: 100%;
  height: 1px;
  background-color: #ddd;
  margin: 10px 0;
}

/* Pie */
.cart-footer {
  padding: 20px;
  text-align: center;
  margin-top: 20px;
}

.continue-btn {
  background-color: #f39c12;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s;
}

.continue-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.continue-btn:hover:not(:disabled) {
  background-color: #e67e22;
}
</style>
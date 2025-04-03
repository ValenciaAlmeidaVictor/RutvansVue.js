<template>
  <div class="form-ticket-container">
    <div class="ticket-form-section">
      <div class="passenger-card">
        <div class="passenger-info">
          <h3 class="passenger-title">Pasajero</h3>
          <p class="passenger-type">{{ passengerType }} (${{ total }} MXN)</p>
          <p v-if="seatNumber" class="passenger-seat">Asiento: {{ seatNumber }}</p>
          <div class="passenger-image">
            <img src="https://cdn-icons-png.flaticon.com/512/75/75648.png" alt="Pasajero" />
          </div>
        </div>
        
        <div class="separator-vertical"></div>
        
        <div class="passenger-form">
          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input 
              type="text" 
              id="nombre" 
              v-model="nombre" 
              placeholder="Ingrese su nombre"
              required
            >
          </div>
          <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input 
              type="text" 
              id="apellido" 
              v-model="apellido" 
              placeholder="Ingrese su apellido"
              required
            >
          </div>
        </div>
      </div>
    </div>
    
    <div class="cart-section">
      <div class="cart">
        <div class="cart-header">
          <h2>Resumen de viaje</h2>
          <div class="header-content">
            <img src="https://images.sipse.com/-EdvJzm23lm24Bjc7YwYmuLK1OI=/724x500/smart/2021/08/29/1630260268379.jpg" alt="Viaje" class="header-image" />
            <div class="header-info">
              <p>{{ fecha }} - {{ hora }}</p>
              <p><strong>Origen:</strong> {{ origen }}</p>
              <p><strong>Destino:</strong> {{ destino }}</p>
              <p v-if="seatNumber"><strong>Asiento:</strong> {{ seatNumber }}</p>
            </div>
          </div>
        </div>
        <div class="header-separator"></div>

        <div class="cart-body">
          <div class="cart-item">
            <p>Costo de viaje:</p>
            <p>${{ (total + discount).toFixed(2) }} MXN</p>
          </div>
          <div class="cart-item" v-if="discount > 0">
            <p>Descuento ({{ passengerType }}):</p>
            <p>-${{ discount.toFixed(2) }} MXN</p>
          </div>
          <div class="body-separator"></div>
          <div class="cart-item total">
            <p>Total:</p>
            <p>${{ total.toFixed(2) }} MXN</p>
          </div>
        </div>

        <div class="cart-footer">
          <button @click="imprimirTicket" class="print-btn">Imprimir Ticket</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '@/api';

const route = useRoute();
const router = useRouter();

// Datos del formulario
const nombre = ref('');
const apellido = ref('');

// Obtener parámetros de la ruta
const passengerType = ref(route.query.type || 'Adulto');
const total = ref(Number(route.query.price) || 0);
const discount = ref(Number(route.query.discount) || 0);
const seatNumber = ref(route.query.seatNumber || '');
const origen = ref(route.query.origen || '');
const destino = ref(route.query.destino || '');
const fecha = ref(route.query.fecha || '');
const hora = ref(route.query.hora || '');

const imprimirTicket = async () => {
  const ticketData = {
    passenger_name: `${nombre.value} ${apellido.value}`,
    fare_type: passengerType.value,
    seat_number: seatNumber.value,
    origin: origen.value,
    destination: destino.value,
    date: fecha.value,
    departure_time: hora.value,
    base_price: total.value + discount.value,
    discount: discount.value,
    total: total.value
  };

  try {
    // Enviar datos al backend
    const response = await api.post('/tickets', ticketData);
    
    console.log('Ticket creado:', response.data);
    alert(`Ticket impreso para ${nombre.value} ${apellido.value}`);
    router.push('/');
  } catch (error) {
    console.error('Error al crear ticket:', error);
    alert('Error al guardar el ticket. Por favor intente nuevamente.');
  }
};
</script>
<style scoped>
  .form-ticket-container {
    display: flex;
    padding: 30px;
    background-color: white;
    min-height: 100vh;
    width: 100%;
  }
  
  .ticket-form-section {
    flex: 2;
  }
  
  .cart-section {
    flex: 1;
  }
  
  .passenger-card {
    display: flex;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    gap: 20px;
  }
  
  .passenger-info {
    display: flex;
    flex-direction: column;
    min-width: 100px;
  }
  
  .passenger-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 5px;
    color: #2c3e50;
  }
  
  .passenger-type {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 15px;
  }
  
  .passenger-image img {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    object-fit: cover;
  }
  
  .separator-vertical {
    width: 1px;
    background-color: #ddd;
  }
  
  .passenger-form {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 15px;
  }
  
  .form-group {
    display: flex;
    flex-direction: column;
  }
  
  .form-group label {
    font-size: 0.9rem;
    margin-bottom: 5px;
    color: #555;
  }
  
  .form-group input {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
  }
  
  /* Estilos del carrito */
  .cart {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    min-height: 600px;
    display: flex;
    flex-direction: column;
  }
  
  .cart-header {
    background-color: #f8f9fa;
    border-radius: 10px 10px 0 0;
    padding: 15px;
    width: 100%;
    box-sizing: border-box;
    margin: 0;
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
  
  .cart-footer {
    padding: 20px;
    text-align: center;
    margin-top: 20px;
  }
  
  .print-btn {
    width: 100%;
    padding: 10px 20px;
    background-color: #f39c12;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .print-btn:hover {
    background-color: #e67e22;
  }
</style>
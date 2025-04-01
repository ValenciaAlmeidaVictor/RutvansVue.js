<template>
  <div class="boletos">
    <h1>Boletos Disponibles</h1>
    <div v-if="boletos.length > 0">
      <table>
        <thead>
          <tr>
            <th>Nombre del Pasajero</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Ruta</th>
            <th>Ruta Unidad</th>
            <th>Horario</th>
            <th>Destino Intermedio</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="boleto in boletos" :key="boleto.idBoleto">
            <td>{{ boleto.nombrePasajero }}</td>
            <td>${{ boleto.total }}</td>
            <td>{{ boleto.fecha }}</td>
            <td>{{ boleto.idRuta }}</td>
            <td>{{ boleto.idRutaUnidad }}</td>
            <td>{{ boleto.idHorario }}</td>
            <td>{{ boleto.idDestinoIntermedio }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <p>No boletos disponibles.</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      boletos: [], // Almacenamos los boletos que obtendremos de la API
    };
  },
  mounted() {
    // Hacemos la solicitud a la API cuando el componente se monta
    axios
      .get("http://127.0.0.1:8000/api/mostrar-boletos")
      .then((response) => {
        console.log(response.data.boletos); // Imprimir los datos recibidos para verificar
        // Asignamos los datos recibidos a la variable boletos
        this.boletos = response.data.boletos;
      })
      .catch((error) => {
        console.error("Error al cargar los boletos:", error);
      });
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  background-color: #2c3e50; 
  color: white;
  border: 2px solid #34495e;
  border-radius: 8px; 
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
}

th,
td {
  padding: 15px 20px; 
  text-align: left;
  border: 1px solid #34495e; 
  font-size: 16px; 
}

th {
  background-color: #42b983; 
  color: white;
  font-weight: bold; 
  text-transform: uppercase; 
}

td {
  background-color: #34495e; 
}

tr:nth-child(even) td {
  background-color: #3e4b59; 
}

tr:hover td {
  background-color: #16a085; 
}

p {
  text-align: center;
  color: #bdc3c7; 
  font-size: 18px;
}
</style>

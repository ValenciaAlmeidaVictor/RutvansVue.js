<template>
  <div class="ventas-container">
    <!-- Botón general para generar PDF, ahora en la parte superior -->
    <button class="btn-general" @click="generatePDF">Generar PDF General</button>
    
    <h2>Lista de Ventas</h2>
    <table class="ventas-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Fecha</th>
          <th>Folio</th>
          <th>Total</th>
          <th>Usuario</th>
          <th>Estado</th>
          <th>Método</th>
          <th>Origen</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sale in sales" :key="sale.id" :id="'sale-' + sale.id">
          <td>{{ sale.id }}</td>
          <td>{{ sale.date }}</td>
          <td>{{ sale.folio }}</td>
          <td>{{ sale.cost }}</td>
          <td>{{ sale.user.name }}</td>
          <td>{{ sale.state_id }}</td>
          <td>{{ sale.method_id }}</td>
          <td>{{ sale.origin_id }}</td>
          <td>
            <button class="btn-ticket" @click="generateSalePDF(sale)">Generar Ticket</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
import { jsPDF } from "jspdf";

export default {
  data() {
    return {
      sales: [],
    };
  },
  mounted() {
    this.fetchSales();
  },
  methods: {
    fetchSales() {
      axios.get('/ventas')
        .then(response => {
          this.sales = response.data;
        })
        .catch(error => {
          console.error('Hubo un error al obtener las ventas:', error);
        });
    },
    generatePDF() {
      const doc = new jsPDF();

      // Diseño del PDF general (similar al ticket)
      doc.setFont("helvetica", "bold");
      doc.text("Lista de Ventas", 105, 15, { align: 'center' });  // Título centrado

      // Recorrer todas las ventas y crear un "ticket" por venta
      let y = 30;
      this.sales.forEach(sale => {
        // Separar cada ticket con un espacio entre ellos
        doc.setFont("helvetica", "normal");
        doc.text(`Folio: ${sale.folio}`, 20, y);
        doc.text(`ID: ${sale.id}`, 20, y + 10);
        doc.text(`Fecha: ${sale.date}`, 20, y + 20);
        doc.text(`Total: $${sale.cost}`, 20, y + 30);
        doc.text(`Usuario: ${sale.user.name}`, 20, y + 40);
        doc.text(`Estado: ${sale.state_id}`, 20, y + 50);
        doc.text(`Método: ${sale.method_id}`, 20, y + 60);
        doc.text(`Origen: ${sale.origin_id}`, 20, y + 70);

        // Línea divisoria entre cada "ticket"
        doc.setLineWidth(0.5);
        doc.line(10, y + 80, 200, y + 80); // Línea horizontal al final de cada ticket
        y += 90; // Espacio entre los tickets

        // Limitar la cantidad de "tickets" por página
        if (y > 270) {
          doc.addPage(); // Crear una nueva página si se excede el límite de espacio
          y = 20; // Reiniciar la posición vertical para la nueva página
        }
      });

      // Descargar el PDF general
      doc.save("ventas_general.pdf");
    },
    generateSalePDF(sale) {
      const doc = new jsPDF();

      // Diseño de ticket individual, centrar los datos
      doc.setFont("helvetica", "bold");
      doc.text("Ticket de Venta", 105, 15, { align: 'center' });  // Título centrado
      doc.setFont("helvetica", "normal");

      // Centrado de los datos en el ticket
      doc.text(`Folio: ${sale.folio}`, 105, 30, { align: 'center' }); // Centrar el texto
      doc.text(`ID: ${sale.id}`, 105, 40, { align: 'center' });
      doc.text(`Fecha: ${sale.date}`, 105, 50, { align: 'center' });
      doc.text(`Total: $${sale.cost}`, 105, 60, { align: 'center' });
      doc.text(`Usuario: ${sale.user.name}`, 105, 70, { align: 'center' });
      doc.text(`Estado: ${sale.state_id}`, 105, 80, { align: 'center' });
      doc.text(`Método: ${sale.method_id}`, 105, 90, { align: 'center' });
      doc.text(`Origen: ${sale.origin_id}`, 105, 100, { align: 'center' });

      // Líneas divisorias para separar los campos
      doc.setLineWidth(0.5);
      doc.line(10, 110, 200, 110);  // Línea horizontal al final
      doc.setFont("helvetica", "italic");
      doc.text("Gracias por tu compra", 105, 110, { align: 'center' });

      // Estilo de ticket
      doc.setLineWidth(1);
      doc.rect(10, 10, 180, 120); // Rectángulo de borde de ticket

      doc.save(`venta_${sale.folio}.pdf`);
    }
  }
};
</script>

<style scoped>
.ventas-container {
  margin: 20px;
}

.ventas-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.ventas-table th, .ventas-table td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
}

.btn-general, .btn-ticket {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 20px;
}

.btn-general:hover, .btn-ticket:hover {
  background-color: #45a049;
}

.btn-ticket {
  background-color: #f39c12;
}

.btn-ticket:hover {
  background-color: #e67e22;
}
</style>

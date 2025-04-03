<template>
  <div class="home-container">
    <!-- Hero Image -->
    <div class="hero-image">
      <img src="@/assets/rvpanel.png" alt="RV Panel Principal" class="hero-img">
    </div>

    <!-- Cards Section -->
    <div class="cards-section">
      <h2 class="section-title">Nuestros Servicios</h2>
      <div class="uber-cards-grid">
        <!-- Card 1: Punto de Venta -->
        <router-link to="/punto-venta" class="uber-card" @click.native="trackClick('punto-venta')">
          <div class="uber-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
            </svg>
          </div>
          <div class="uber-card-content">
            <h3>Punto de Venta</h3>
            <p>Sistema completo para gestionar tus ventas</p>
            <div class="uber-card-action">
              <span>Ir al servicio</span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
              </svg>
            </div>
          </div>
        </router-link>

        <!-- Card 2: Envíos -->
        <div class="uber-card coming-soon">
          <div class="uber-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25zM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 116 0h3a.75.75 0 00.75-.75V15z" />
              <path d="M8.25 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0zM15.75 6.75a.75.75 0 00-.75.75v11.25c0 .087.015.17.042.248a3 3 0 015.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 00-3.732-10.104 1.837 1.837 0 00-1.47-.725H15.75z" />
              <path d="M19.5 19.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
            </svg>
          </div>
          <div class="uber-card-content">
            <h3>Envíos</h3>
            <p>Soluciones logísticas para tus productos</p>
            <div class="uber-card-badge">Próximamente</div>
          </div>
        </div>

        <!-- Card 3: Alquiler de Servicio -->
        <div class="uber-card coming-soon">
          <div class="uber-card-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 016.775-5.025.75.75 0 01.313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 011.248.313 5.25 5.25 0 01-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 112.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0112 6.75zM4.117 19.125a.75.75 0 01.75-.75h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75h-.008a.75.75 0 01-.75-.75v-.008z" clip-rule="evenodd" />
              <path d="M10.076 8.64l-2.201-2.2V4.874a.75.75 0 00-.364-.643l-3.75-2.25a.75.75 0 00-.916.113l-.75.75a.75.75 0 00-.113.916l2.25 3.75a.75.75 0 00.643.364h1.564l2.062 2.062 1.575-1.297z" />
              <path fill-rule="evenodd" d="M12.556 17.329l4.183 4.182a3.375 3.375 0 004.773-4.773l-3.306-3.305a6.803 6.803 0 01-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 00-.167.063l-3.086 3.748zm3.414-1.36a.75.75 0 011.06 0l1.875 1.876a.75.75 0 11-1.06 1.06L15.97 17.03a.75.75 0 010-1.06z" clip-rule="evenodd" />
            </svg>
          </div>
          <div class="uber-card-content">
            <h3>Alquiler de Servicio</h3>
            <p>Equipos especializados para tus necesidades</p>
            <div class="uber-card-badge">Próximamente</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HomeView',
  methods: {
    trackClick(service) {
      console.log(`Servicio seleccionado: ${service}`);
    }
  }
}
</script>

<style scoped>
.home-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 20px;
}

.hero-image {
  width: 100%;
  max-width: 400px;
  height: 290px;
  position: relative;
  overflow: hidden;
  border-radius: 12px;
  margin: 0 auto 0px;
 
}

.hero-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.section-title {
  text-align: center;
  margin-bottom: 40px;
  font-size: 2rem;
  color: #333;
  font-weight: 600;
}

/* Estilo Uber para las cards */
.uber-cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  margin-bottom: 60px;
}

.uber-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  border: 1px solid #f0f0f0;
  display: flex;
  flex-direction: column;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}

.uber-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
  border-color: #FF6B00;
}

.uber-card-icon {
  width: 48px;
  height: 48px;
  background: #FFF5F0;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FF6B00;
  margin-bottom: 20px;
}

.uber-card-icon svg {
  width: 24px;
  height: 24px;
}

.uber-card-content h3 {
  margin: 0 0 8px;
  font-size: 1.2rem;
  color: #333;
  font-weight: 600;
}

.uber-card-content p {
  color: #666;
  line-height: 1.5;
  margin-bottom: 20px;
  font-size: 0.95rem;
}

.uber-card-action {
  display: flex;
  align-items: center;
  color: #FF6B00;
  font-weight: 500;
  margin-top: auto;
}

.uber-card-action svg {
  width: 16px;
  height: 16px;
  margin-left: 6px;
  transition: transform 0.2s ease;
}

.uber-card:hover .uber-card-action svg {
  transform: translateX(3px);
}

.uber-card-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background: #333;
  color: white;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 500;
}

.coming-soon {
  opacity: 0.9;
}

.coming-soon .uber-card-icon {
  background: #f0f0f0;
  color: #999;
}

/* Responsive */
@media (max-width: 768px) {
  .uber-cards-grid {
    grid-template-columns: 1fr;
  }
  
  .hero-image {
    height: 300px;
  }
}
</style>
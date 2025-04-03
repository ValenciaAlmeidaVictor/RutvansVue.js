<template>
  <div id="app">
    <!-- Encabezado mejorado -->
    <header class="app-header" :class="{'scrolled-header': scrolled}" v-if="isAuthenticated">
      <div class="header-container">
        <div class="logo-container">
          <img src="./assets/LogoRutvans.png" alt="RUTVANS Logo" class="logo">
          <h1>RUTVANS</h1>
        </div>
        
        <nav class="main-nav">
          <router-link to="/">Inicio</router-link>
          <router-link to="/punto-venta">Punto de Venta</router-link>
          <router-link to="/envios">Envíos</router-link>
          <router-link to="/alquilar">Alquilar Servicio</router-link>
        </nav>
        
        <div class="user-actions">
          <button class="login-btn">
            <i class="fas fa-user"></i> {{ currentUser.name || 'Usuario' }}
          </button>
          <button class="register-btn" @click="logout">
            <i class="fas fa-sign-out-alt"></i> Salir
          </button>
        </div>
      </div>
    </header>




    
    <!-- Contenido principal -->
    <transition name="fade" mode="out-in">
      <div class="contenido">
        <router-view />
      </div>
    </transition>

    <!-- Pie de página mejorado -->
    <footer class="app-footer" v-if="isAuthenticated">
      <div class="footer-content">
        <div class="footer-section">
          <h3>RUTVANS</h3>
          <p>Tu solución de transporte confiable</p>
        </div>
        <div class="footer-section">
          <h3>Contacto</h3>
          <p><i class="fas fa-envelope"></i> info@rutvans.com</p>
          <p><i class="fas fa-phone"></i> +52 55 1234 5678</p>
        </div>
        <div class="footer-section">
          <h3>Redes Sociales</h3>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 RUTVANS. Todos los derechos reservados.</p>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      scrolled: false,
      isAuthenticated: false,
      currentUser: {}
    }
  },
  created() {
    this.checkAuth();
  },
  methods: {
    checkAuth() {
      const token = localStorage.getItem('token');
      const user = localStorage.getItem('user');
      
      if (token && user) {
        this.isAuthenticated = true;
        this.currentUser = JSON.parse(user);
      } else {
        // Redirigir a login si no está autenticado
        if (this.$route.path !== '/login') {
          this.$router.push('/login');
        }
      }
    },
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      this.isAuthenticated = false;
      this.$router.push('/login');
    },
    handleScroll() {
      this.scrolled = window.scrollY > 10;
    }
  },
  watch: {
    $route() {
      this.checkAuth();
    }
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll);
  }
}
</script>

<style>
/* Variables de color actualizadas */
:root {
  --primary-color: #e67e22;
  --secondary-color: #000000;
  --accent-color: #010101;
  --light-color: #f8f9fa;
  --dark-color: #343a40;
  --text-light: #ffffff;
  --text-dark: #333333;
  --hover-color: #d35400;
}

/* Estilos base */
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  margin: 0;
  color: var(--text-dark);
  background-color: #000;
}

/* Transiciones */
.app-header, .main-nav a, button, .social-icons a {
  transition: all 0.3s ease-in-out;
}

/* Header mejorado */
.app-header {
  position: sticky;
  top: 0;
  z-index: 1000;
  padding: 0.8rem 2rem;
  background-color: var(--primary-color);
  color: var(--text-light);
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.scrolled-header {
  padding: 0.3rem 2rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  background-color: rgba(230, 126, 34, 0.95);
}

.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
}

/* Logo */
.logo-container {
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo {
  height: 45px;
}

.logo:hover {
  animation: pulse 1.5s infinite;
}

.app-header h1 {
  font-size: 1.8rem;
  font-weight: 800;
  letter-spacing: 1px;
  margin: 0;
  color: var(--text-light);
  text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
}

/* Navegación */
.main-nav {
  display: flex;
  gap: 25px;
}

.main-nav a {
  font-weight: 600;
  font-size: 1.1rem;
  color: var(--text-light);
  text-decoration: none;
  padding: 10px 5px;
  position: relative;
}

.main-nav a:hover {
  color: var(--secondary-color);
  background: none !important
}

.main-nav a.router-link-exact-active {
  color: var(--secondary-color);
}

.main-nav a.router-link-exact-active::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background-color: var(--secondary-color);
}

/* Botones */
.user-actions {
  display: flex;
  gap: 12px;
}

button {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 20px;
  border-radius: 4px;
  font-weight: 600;
  cursor: pointer;
  border: none;
  font-size: 1rem;
}

.login-btn {
  background: transparent;
  color: var(--text-light);
  border: 2px solid var(--text-light);
}

.login-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.register-btn {
  background: var(--accent-color);
  color: var(--text-light);
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.register-btn:hover {
  background: var(--hover-color);
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

/* Contenido principal */
.contenido {
  flex: 1;
  width: 100%;
  background-color: white;
  padding: 30px;
  box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
}

/* Transición de vistas */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

/* Pie de página */
.app-footer {
  background: linear-gradient(to right, #2a2929, #0d0d0d);
  color: var(--text-light);
  padding: 2.5rem 0 0;
}

.footer-content {
  display: flex;
  justify-content: space-around;
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
}

.footer-section {
  flex: 1;
  margin: 0 1.5rem;
}

.footer-section h3 {
  font-size: 1.3rem;
  margin-bottom: 1.2rem;
  color: var(--text-light);
}

.footer-section p {
  margin: 0.8rem 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.social-icons {
  display: flex;
  gap: 15px;
}

.social-icons a {
  color: var(--text-light);
  font-size: 1.5rem;
}

.social-icons a:hover {
  color: var(--text-light);
  transform: translateY(-3px) scale(1.1);
}

.footer-bottom {
  text-align: center;
  padding: 1.2rem;
  margin-top: 2.5rem;
  background-color: rgba(0, 0, 0, 0.3);
}

.footer-bottom p {
  margin: 0;
  font-size: 0.95rem;
}

/* Animaciones */
@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}

/* Responsive */
@media (max-width: 992px) {
  .header-container {
    flex-direction: column;
    padding: 1rem 0;
  }
  
  .logo-container {
    margin-bottom: 1rem;
  }
  
  .main-nav {
    margin: 1rem 0;
  }
  
  .contenido {
    padding: 20px;
  }
}

@media (max-width: 768px) {
  .main-nav {
    flex-direction: column;
    gap: 10px;
    text-align: center;
  }
  
  .user-actions {
    flex-direction: column;
    width: 100%;
  }
  
  .login-btn, .register-btn {
    width: 100%;
    justify-content: center;
  }
  
  .footer-content {
    flex-direction: column;
    gap: 20px;
  }
  
  .footer-section {
    text-align: center;
    margin: 0.5rem 0;
  }
  
  .social-icons {
    justify-content: center;
  }
}

@media (max-width: 576px) {
  .app-header {
    padding: 0.5rem;
  }
  
  .contenido {
    padding: 15px;
  }
  
  .app-footer {
    padding: 1.5rem 0 0;
  }
  
  .footer-section h3 {
    font-size: 1.1rem;
  }
  
  button {
    padding: 8px 15px;
    font-size: 0.9rem;
  }
}
</style>
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import UsuarioView from "../views/UsuarioView.vue";
import PuntoVenta from '../views/PuntoVenta.vue';
import VentaAsientos from '@/views/VentaAsientos.vue';
import FormTicket from '@/views/FormTicket.vue';
import LoginView from '../views/LoginView.vue'
import Ventas from '@/views/Ventas.vue'; 

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: LoginView,
       // Ruta accesible sin autenticación
    },
    {
      path: '/',
      name: 'home',
      component: HomeView,
       // Requiere autenticación
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue'),
      meta: { requiresAuth: false }
    },
    {
      path: "/usuarios",
      name: "usuarios",
      component: UsuarioView,
      meta: { requiresAuth: false }
    },
    {
      path: '/ventas',
      name: 'Ventas',
      component: Ventas
    },
    {
      path: '/punto-venta',
      name: 'PuntoVenta',
      component: PuntoVenta,
      meta: { requiresAuth: false }
    },
    {
      path: '/venta-asientos',
      name: 'VentaAsientos',
      component: VentaAsientos,
      
    },
    {
      path: '/form-ticket',
      name: 'FormTicket',
      component: FormTicket,
      props: true,
      
    }
  ]
})

// Guardia de navegación global
/*router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('token')
  
  // Si la ruta requiere autenticación y el usuario no está autenticado
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login')
  } 
  // Si el usuario está autenticado pero intenta acceder al login
  else if (to.name === 'login' && isAuthenticated) {
    next('/') // Redirige al home
  } 
  // En cualquier otro caso, permite la navegación
  else {
    next()
  }
})*/

export default router
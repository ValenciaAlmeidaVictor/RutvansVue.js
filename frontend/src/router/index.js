<<<<<<< HEAD
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TipoTarifa from "@/views/TipoTarifa.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: "/Tipotarifa",
      name: "tipotarifa",
      component: TipoTarifa,
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue'),
    },
  ],
})
=======
import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import BoletosView from "../views/BoletosView.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/about",
    name: "about",
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/AboutView.vue"),
  },
  {
    path: "/boletos",
    name: "boletos",
    component: BoletosView,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});
>>>>>>> 3e588dd204e12255f3b31d5a1b1b6ec3434c42ea

export default router;

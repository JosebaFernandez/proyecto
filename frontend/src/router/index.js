import { createRouter, createWebHistory } from 'vue-router';
import InicioView from '../views/InicioView.vue';
import CrearActividadView from '../components/FormActividad.vue'; 

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'inicio',
      component: InicioView,
    },
    {
      path: '/crear-actividad',
      name: 'crearActividad',
      component: CrearActividadView, 
    },
  ],
});

export default router;

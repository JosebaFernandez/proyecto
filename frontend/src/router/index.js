import { createRouter, createWebHistory } from 'vue-router';
import InicioView from '../views/InicioView.vue';
import CrearActividadView from '../components/FormActividad.vue'; 
import ActividadShow from '@/components/ActividadShow.vue';
import ActividadEdit from '@/components/ActividadEdit.vue';

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
    {
      path: '/actividad/:id',
      name: 'ActividadShow',
      component: ActividadShow,
      props: true,
    },
    {
      path: '/actividades/:id/editar',
      name: 'editarActividad',
      component: ActividadEdit, // Asegúrate de que esto sea el componente correcto
    }
  ],
});

export default router;

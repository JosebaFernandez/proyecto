<!-- src/components/Header.vue -->
<template>
  <div class="header">
    <nav class="navbar bg-success" style="--bs-bg-opacity: .5;">
      <div class="container">
        <a class="navbar-brand" href="/">
          <img src="../assets/logo_grande.svg" alt="Bootstrap" width="250px">
        </a>
        <div class="d-flex">
          <!-- Botón para ir a /crear-actividad, solo visible si está autenticado -->
          <button v-if="isAuthenticated" class="btn btn-outline-light mr-2" type="button" @click="goToCrearActividad">
            Crear Actividad
          </button>
          <!-- Botón de Login -->
          <button v-if="!isAuthenticated" class="btn btn-outline-light mr-2" type="button" @click="openModal">
            Login
          </button>
          <!-- Botón de Logout con tooltip -->
          <button v-else class="btn btn-outline-danger" type="button" @click="logOut" data-bs-toggle="tooltip" title="Logout">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
              <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
            </svg>
          </button>
        </div>
      </div>
    </nav>
  </div>
  <div>
    
  </div>

  <!-- Componente del Modal de acceso -->
  <ModalAcceso @loginSuccess="handleLoginSuccess" />
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { Modal as bootstrapModal, Tooltip as bootstrapTooltip } from 'bootstrap';
import { useRouter } from 'vue-router';
import ModalAcceso from './ModalAcceso.vue';

export default defineComponent({
  components: {
    ModalAcceso,
  },
  setup() {
    const router = useRouter(); // Instancia de Vue Router
    let modalInstance;
    const isAuthenticated = ref(false); // Variable reactiva para controlar el estado de autenticación

    const openModal = () => {
      if (modalInstance) {
        modalInstance.show();
      }
    };

    const logOut = () => {
      localStorage.clear();
      isAuthenticated.value = false; // Actualiza el estado de autenticación
      router.push('/'); // Redirige a la página de inicio o cualquier otra página después de cerrar sesión
    };

    const goToCrearActividad = () => {
      router.push('/crear-actividad'); // Redirige a la página correspondiente
    };

    onMounted(() => {
      const modalElement = document.getElementById('bootstrapModal');
      if (modalElement) {
        modalInstance = new bootstrapModal(modalElement);
      } else {
        console.error("No se encontró el modal con el id 'bootstrapModal'");
      }

      // Inicializar tooltips
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map((tooltipTriggerEl) => new bootstrapTooltip(tooltipTriggerEl));

      // Comprobar el estado de autenticación en el localStorage
      const dni = localStorage.getItem('DNI');
      if (dni) {
        isAuthenticated.value = true;
      }
    });

    const handleLoginSuccess = () => {
      isAuthenticated.value = true; // Actualiza el estado de autenticación
      if (modalInstance) {
        modalInstance.hide(); // Cierra el modal
      }
    };

    return { openModal, logOut, goToCrearActividad, handleLoginSuccess, isAuthenticated };
  },
});
</script>

<style scoped>
/* Agregar margen entre los botones */
.mr-2 {
  margin-right: 10px;
}
</style>
<template>
  <div class="header">
    <nav class="navbar bg-success" style="--bs-bg-opacity: .5;">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="../assets/logo_grande.svg" alt="Bootstrap" width="250px">
        </a>
        <div class="d-flex">
          <!-- Botón para ir a /crear-actividad -->
          <button class="btn btn-outline-light mr-2" type="button" @click="goToCrearActividad">
            Crear Actividad
          </button>
          <!-- Botón de Login -->
          <button class="btn btn-outline-light" type="button" @click="openModal">
            Login
          </button>
        </div>
      </div>
    </nav>
  </div>

  <!-- Componente del Modal de acceso -->
  <ModalAcceso />
</template>

<script>
import { defineComponent, onMounted } from 'vue';
import { Modal as bootstrapModal } from 'bootstrap';
import { useRouter } from 'vue-router';
import ModalAcceso from './ModalAcceso.vue';

export default defineComponent({
  components: {
    ModalAcceso,
  },
  setup() {
    const router = useRouter(); // Instancia de Vue Router
    let modalInstance;

    // Función para abrir el modal
    const openModal = () => {
      if (modalInstance) {
        modalInstance.show();
      }
    };

    // Función para navegar a /crear-actividad
    const goToCrearActividad = () => {
      router.push('/crear-actividad'); // Redirige a la página correspondiente
    };

    // Inicializar el modal cuando el componente se monta
    onMounted(() => {
      const modalElement = document.getElementById('bootstrapModal');
      if (modalElement) {
        modalInstance = new bootstrapModal(modalElement);
      } else {
        console.error("No se encontró el modal con el id 'bootstrapModal'");
      }
    });

    return { openModal, goToCrearActividad };
  },
});
</script>

<style scoped>
/* Agregar margen entre los botones */
.mr-2 {
  margin-right: 10px;
}
</style>

<template>
    <div class="header">
      <nav class="navbar bg-success" style="--bs-bg-opacity: .5;">
        <div class="container">
          <a class="navbar-brand" href="#">
            <img src="../assets/logo_grande.svg" alt="Bootstrap" width="250px">
          </a>
          <div class="d-flex" role="login">
            <button class="btn btn-outline-light mr-10" type="button" @click="openModal">Login</button>
          </div>
        </div>
      </nav>
    </div>
    <ModalAcceso />
  </template>
  
  <script>
  import { defineComponent, onMounted } from 'vue';
  import { Modal as bootstrapModal } from 'bootstrap';
  import ModalAcceso from './ModalAcceso.vue';
 
  export default defineComponent({
    components: {
      ModalAcceso, // Registra el componente ModalLogin
    },
    setup() {
      let modalInstance;
  
      // Función para abrir el modal
      const openModal = () => {
        if (modalInstance) {
          modalInstance.show(); // Abre el modal cuando se hace clic en el botón
        }
      };
  
      // Inicialización del modal cuando el componente es montado
      onMounted(() => {
        const modalElement = document.getElementById('bootstrapModal');
        if (modalElement) {
          modalInstance = new bootstrapModal(modalElement);
        } else {
          console.error("No se encontró el modal con el id 'bootstrapModal'");
        }
      });
  
      return { openModal }; // Devuelve la función para que sea accesible en el template
    },
  });
  </script>
  
  <style scoped>
  /* Estilos para el header si es necesario */
  </style>
  
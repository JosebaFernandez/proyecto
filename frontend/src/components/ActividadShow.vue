<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3>{{ actividad.titulo }}</h3>
        <div>
          <button 
            v-if="userId && !actividad.isUserEnrolled" 
            class="btn btn-outline-success mr-2" style="height: 41px;"
            @click="apuntarse(actividad.id)">
            Apuntarse
          </button>
          <button v-if="rol == 'admin'" class="btn btn-outline-warning mr-2" type="button" @click="goToUpdate">
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="25" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
              <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
            </svg>  
          </button>
          <button v-if="rol == 'admin'" class="btn btn-outline-danger" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
              <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
            </svg>
          </button>
        </div>
      </div>
      <div class="card-body">
        <img :src="getImageUrl(actividad.imagen)" width="250" class="img-fluid mb-3" alt="imagen-actividad">
        <p>{{ actividad.descripcion }}</p>
        <p><strong>Fecha:</strong> {{ actividad.fecha }}</p>
        <p><strong>Lugar:</strong> {{ actividad.lugar }}</p>
      </div>
    </div>

    <!-- Toast de confirmación -->
    <div v-if="showToast" class="toast-container">
      Te has apuntado al curso con éxito
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
  name: 'ActividadShow',
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      actividad: {},
      userId: null,
      showToast: false,
      rol: localStorage.getItem('role'),
    };
  },
  mounted() {
    this.fetchActividad();
    this.loadUser();
  },
  methods: {
    // Obtener los detalles de la actividad
    async fetchActividad() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/actividades/show/${this.id}`);
        this.actividad = response.data;

        // Verificamos si el usuario está apuntado en la base de datos
        if (this.userId) {
          const enrollmentResponse = await axios.get(
            `http://127.0.0.1:8000/api/actividades/check-enrollment/${this.userId}/${this.actividad.id}`
          );
          this.actividad.isUserEnrolled = enrollmentResponse.data.isEnrolled;
        }
      } catch (error) {
        console.error('Error al obtener la actividad:', error);
      }
    },


    // Método para obtener la URL de la imagen
    getImageUrl(imagen) {
      return `http://localhost:8000/storage/${imagen}`;
    },

    // Cargar el objeto de usuario desde localStorage y obtener su ID
    loadUser() {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user) {
        this.userId = user.id; // Usamos el ID del objeto usuario almacenado
      }
    },

    goToUpdate() {
      this.$router.push(`/actividades/${this.actividad.id}/editar`);
    },

    // Método para apuntarse a la actividad
    async apuntarse(idActividad) {
      try {
        if (!idActividad || !this.userId) {
          console.error("Error: idActividad o userId son undefined.");
          return;
        }

        const response = await axios.post(
          `http://127.0.0.1:8000/api/actividades/asignar/${this.userId}`,
          { actividad_id: idActividad },
          { headers: { "Content-Type": "application/json" } }
        );

        // Actualizamos localmente el estado de la actividad
        if (this.actividad.id === idActividad) {
          this.actividad.isUserEnrolled = true;
        }

        this.showToast = true;
        setTimeout(() => {
          this.showToast = false;
        }, 3000);
      } catch (error) {
        console.error("Error al inscribirse:", error.response?.data || error);
      }
    }
  }
};
</script>

<style scoped>
.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  background-color: #28a745;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 1000;
}
.mr-2 {
  margin-right: 10px;
}
</style>

<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h3>{{ actividad.titulo }}</h3>
      </div>
      <div class="card-body">
        <img :src="getImageUrl(actividad.imagen)" width="100" class="img-fluid mb-3" alt="imagen-actividad">
        <p>{{ actividad.descripcion }}</p>
        <p><strong>Fecha:</strong> {{ actividad.fecha }}</p>
        <p><strong>Lugar:</strong> {{ actividad.lugar }}</p>

        <!-- Botón de apuntarse -->
        <button 
          v-if="userId && !actividad.isUserEnrolled" 
          class="btn btn-outline-success" 
          @click="apuntarse(actividad.id)">
          Apuntarse
        </button>
      </div>
    </div>

    <!-- Toast de confirmación -->
    <div v-if="showToast" class="toast-container">
      Te has apuntado al curso con éxito
    </div>
  </div>
</template>

<script>
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

        // Verificamos si el usuario está apuntado
        const actividadesApuntadas = JSON.parse(localStorage.getItem(`actividades_apuntadas_${this.userId}`)) || [];
        this.actividad.isUserEnrolled = actividadesApuntadas.includes(this.actividad.id);
      } catch (error) {
        console.error('Error al obtener la actividad:', error);
      }
    },

    // Método para obtener la URL de la imagen
    getImageUrl(imagen) {
      return `http://localhost:8000/storage/${imagen}`;
    },

    // Cargar el ID del usuario desde localStorage
    loadUser() {
      const id = JSON.parse(localStorage.getItem("id"));
      if (id) {
        this.userId = id;
      }
    },

    // Método para apuntarse a la actividad
    async apuntarse(idActividad) {
      try {
        if (!idActividad) {
          console.error("Error: idActividad es undefined.");
          return;
        }

        const response = await axios.post(
          `http://127.0.0.1:8000/api/actividades/asignar/${this.userId}`,
          { actividad_id: idActividad },
          { headers: { "Content-Type": "application/json" } }
        );

        // Guardar la actividad en localStorage para este usuario
        let actividadesUser = JSON.parse(localStorage.getItem(`actividades_apuntadas_${this.userId}`)) || [];
        if (!actividadesUser.includes(idActividad)) {
          actividadesUser.push(idActividad);
          localStorage.setItem(`actividades_apuntadas_${this.userId}`, JSON.stringify(actividadesUser));
        }

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
</style>
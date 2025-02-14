<template>
  <div class="container">
    <div class="row">
      <div v-if="actividades.length > 0">
        <div class="row">
          <div v-for="actividad in actividades" :key="actividad.idActividad" class="col-12 col-md-6 mb-4">
            <div class="card my-card h-100" @click="goToActividadShow(actividad.id)">
              <div class="row g-0">
                <div class="col-md-4 d-flex">
                  <img :src="getImageUrl(actividad.imagen)" class="img-fluid rounded-start flex-fill" alt="imagen-actividad">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title">{{ actividad.titulo }}</h5>
                    <p class="card-text">{{ actividad.descripcion }}</p>
                    <p class="card-text">
                      <small class="text-body-secondary">{{ actividad.fecha }}</small>
                    </p>
                    <p class="card-text">
                      <small class="text-body-secondary">{{ actividad.lugar }}</small>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-center text-muted">
        No hay actividades disponibles.
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ActividadList",
  props: {
    filtros: {
      type: Object,
      default: () => ({})
    },
    currentPage: {
      type: Number,
      required: true
    },
    itemsPerPage: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      actividades: [],
      totalPages: 1,
    };
  },
  watch: {
    filtros: {
      handler: "fetchActividades",
      deep: true
    },
    currentPage: "fetchActividades"
  },
  mounted() {
    this.fetchActividades();
  },
  methods: {
    async fetchActividades() {
      try {
        console.log("Cargando página ${this.currentPage} con ${this.itemsPerPage} actividades por página");

        const response = await axios.get("http://127.0.0.1:8000/api/actividades/index", {
          params: {
            ...this.filtros,
            page: this.currentPage,  
            per_page: this.itemsPerPage 
          }
        });

        console.log("Respuesta API:", response.data);
        this.actividades = response.data.data || response.data;

        // Calculamos el total de páginas
        this.totalPages = response.data.total_pages || Math.max(1, Math.ceil(response.data.total / this.itemsPerPage));

        // ✅ Emitimos el total de páginas al padre (InicioView)
        this.$emit("update-total-pages", this.totalPages);
      } catch (error) {
        console.error("Error al obtener actividades:", error);
      }
    },
    getImageUrl(imagen) {
      return `http://localhost:8000/storage/${imagen}`;
    },
    goToActividadShow(idActividad) {
      this.$router.push({ name: "ActividadShow", params: { id: idActividad } });
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
<template>
  <div class="container">
    <div class="row">
      <div v-if="actividades.length > 0">
        <div class="row">
          <div v-for="(actividad, index) in actividades.slice(0, 4)" :key="actividad.idActividad" class="col-12 col-md-6 col-lg-3 mb-4">
            <div class="card my-card h-100 shadow-sm" @click="goToActividadShow(actividad.id)">
              <img :src="getImageUrl(actividad.imagen)" class="card-img-top actividad-img" alt="imagen-actividad">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-black">{{ truncateText(actividad.titulo, 20) }}</h5>
                <p class="card-text text-muted flex-grow-1">{{ truncateText(actividad.descripcion, 20) }}</p>
                <hr />
                <p class="card-text d-flex justify-content-between">
                  <small class="text-secondary d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3 me-2" viewBox="0 0 16 16">
                      <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                      <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                    </svg>
                    {{ actividad.fecha }} 
                  </small>
                  <small class="text-secondary d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-map me-1" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8z"/>
                      <path fill-rule="evenodd" d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z"/>
                    </svg>
                    {{ truncateText(actividad.lugar, 14) }}
                  </small>
                </p>
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
        console.log(`Cargando página ${this.currentPage} con ${this.itemsPerPage} actividades por página`);

        const response = await axios.get("http://127.0.0.1:8000/api/actividades/index", {
          params: {
            ...this.filtros,
            page: this.currentPage,
            per_page: 4
          }
        });

        console.log("Respuesta API:", response.data);
        this.actividades = response.data.data || response.data;

        this.totalPages = response.data.total_pages || Math.max(1, Math.ceil(response.data.total / this.itemsPerPage));

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
    },
    truncateText(text, maxLength) {
      return text.length > maxLength ? text.substring(0, maxLength) + "..." : text;
    }
  }
};
</script>

<style scoped>
/* 🎨 Estilos mejorados */
.my-card {
  border-radius: 12px;
  overflow: hidden;
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  cursor: pointer;
}

.my-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.actividad-img {
  height: 270px;
  object-fit: cover;
}

</style>

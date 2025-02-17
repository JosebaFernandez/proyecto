<template>
  <div class="container">
    <div class="row">
      <div v-if="actividades.length > 0">
        <div class="row">
          <!-- 🔥 Solo mostramos las primeras 4 actividades -->
          <div v-for="(actividad, index) in actividades.slice(0, 4)" :key="actividad.idActividad" class="col-12 col-md-6 col-lg-3 mb-4">
            <div class="card my-card h-100 shadow-sm" @click="goToActividadShow(actividad.id)">
              <img :src="getImageUrl(actividad.imagen)" class="card-img-top actividad-img" alt="imagen-actividad">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-primary">{{ truncateText(actividad.titulo, 20) }}</h5>
                <p class="card-text text-muted flex-grow-1">{{ truncateText(actividad.descripcion, 20) }}</p>
                <hr />
                <p class="card-text d-flex justify-content-between">
                  <small class="text-secondary">
                    📅 {{ actividad.fecha }}
                  </small>
                  <small class="text-secondary">
                    📍 {{ truncateText(actividad.lugar, 14) }}
                  </small>
                </p>
                <button class="btn btn-success w-100 mt-2">Ver más</button>
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
            per_page: 4 // 🔥 Nos aseguramos de que el backend solo envíe 4 actividades
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
    // 🔥 Función para truncar texto con "..."
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

/* Imagen con tamaño fijo para mantener uniformidad */
.actividad-img {
  height: 180px;
  object-fit: cover;
}

/* Botón de "Ver más" con hover */
.btn-success {
  background-color: #28a745;
  border: none;
}

.btn-success:hover {
  background-color: #218838;
}
</style>

<template>
  <div class="container">
    <div class="row">
        <div v-for="actividad in actividades" :key="actividad.id" class="col-12 col-sm-6 mb-4">
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

                            <butto class="btn btn-outline-success">Apuntarse</butto>
                        </div>
                    </div>

      <div v-if="actividades.length > 0">
        <div class="row">
          <div v-for="actividad in actividades" :key="actividad.idActividad" class="col-12 col-md-6 mb-4">
            <div class="card my-card h-100">
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
                    <button v-if="userId && !actividad.isUserEnrolled" class="btn btn-outline-success" @click="apuntarse(actividad.id)">Apuntarse</button>
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

    <!-- Toast de confirmación -->
    <div v-if="showToast" class="toast-container">
      Te has apuntado al curso con éxito
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
      userId: null,
      showToast: false
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
    this.loadUser();
  },
  methods: {
    async fetchActividades() {
      try {
        console.log(`Cargando página ${this.currentPage} con ${this.itemsPerPage} actividades por página`);

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

        // Recuperamos las actividades a las que el usuario ya está apuntado
        const actividadesApuntadas = JSON.parse(localStorage.getItem(`actividades_apuntadas_${this.userId}`)) || [];

        // Marca si el usuario ya está apuntado a la actividad
        this.actividades.forEach(actividad => {
          actividad.isUserEnrolled = actividadesApuntadas.includes(actividad.id);
        });
      } catch (error) {
        console.error("Error al obtener actividades:", error);
      }
    },
    methods: {
        async fetchActividades() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/actividades/index", {
                    params: {
                        ...this.filtros,
                        page: this.currentPage,
                        per_page: this.itemsPerPage
                    }
                });
                this.actividades = response.data.data || response.data;
                this.totalPages = response.data.total_pages || Math.ceil(this.actividades.length / this.itemsPerPage);
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
    loadUser() {
      const id = JSON.parse(localStorage.getItem("id"));
      if (id) {
        this.userId = id;
      }
    },
    async apuntarse(idActividad) {
      try {
        if (!idActividad) {
          console.error("Error: idActividad es undefined.");
          return;
        }

        console.log('ID Actividad:', idActividad);
        console.log('ID Usuario:', this.userId);

        const response = await axios.post(
          `http://127.0.0.1:8000/api/actividades/asignar/${this.userId}`,
          { actividad_id: idActividad },
          { headers: { "Content-Type": "application/json" } }
        );

        console.log("Respuesta del servidor:", response.data);

        // Guardar la actividad en localStorage para este usuario
        let actividadesUser = JSON.parse(localStorage.getItem(`actividades_apuntadas_${this.userId}`)) || [];
        if (!actividadesUser.includes(idActividad)) {
          actividadesUser.push(idActividad);
          localStorage.setItem(`actividades_apuntadas_${this.userId}`, JSON.stringify(actividadesUser));
        }

        // Actualizamos localmente el estado de la actividad
        const actividad = this.actividades.find(a => a.id === idActividad);
        if (actividad) {
          actividad.isUserEnrolled = true;
        }

        this.showToast = true;
        setTimeout(() => {
          this.showToast = false;
        }, 3000);
      } catch (error) {
        console.error("Error al inscribirse:", error.response?.data || error);
      }
    },
    getImageUrl(imagen) {
      return `http://localhost:8000/storage/${imagen}`;
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

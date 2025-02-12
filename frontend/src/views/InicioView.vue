<template>
  <div class="container">
    <div class="row mt-5">
      <!-- Se pasa a ActividadList solo la parte de las actividades correspondiente a la página actual -->
      <div class="col-11">
        <!-- Pasamos los filtros como prop a ActividadList -->
        <ActividadList :filtros="filtros" />
      </div>
      <div class="col-1">
        <!-- Emitimos el evento aplicar-filtros para actualizar los filtros -->
        <Filtros @aplicar-filtros="actualizarFiltros" />
      </div>
      <div class="col-12 d-flex justify-content-center">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <!-- Botón "Anterior" -->
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link text-success" href="#" aria-label="Previous" @click.prevent="prevPage">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>

            <!-- Botones de página generados dinámicamente -->
            <li
              class="page-item"
              v-for="page in totalPages"
              :key="page"
              :class="{ active: currentPage === page }">
              <a class="page-link text-success" href="#" @click.prevent="goToPage(page)">
                {{ page }}
              </a>
            </li>

            <!-- Botón "Siguiente" -->
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a class="page-link text-success" href="#" aria-label="Next" @click.prevent="nextPage">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import Filtros from "../components/Filtros.vue";
import ActividadList from "../components/ActividadList.vue";

export default {
  name: "Inicio",
  components: {
    Filtros,
    ActividadList,
  },
  data() {
    return {
      actividades: [],
      currentPage: 1,
      itemsPerPage: 4,
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.actividades.length / this.itemsPerPage);
    },
    paginatedActividades() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.actividades.slice(start, start + this.itemsPerPage);
    },
  },
  methods: {
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
  },
  mounted() {
    axios
      .get("http://127.0.0.1:8000/api/actividades/index")
      .then((response) => {
        this.actividades = response.data;
      })
      .catch((error) => {
        console.error("Error al obtener actividades:", error);
      });
  },
  setup() {
    const filtros = ref({}); // Almacena los filtros actuales

    const actualizarFiltros = (nuevosFiltros) => {
      console.log("Nuevos filtros recibidos:", nuevosFiltros);
      filtros.value = { ...nuevosFiltros }; // Creamos una nueva referencia para asegurar la reactividad
    };

    return { filtros, actualizarFiltros };
  },
};
</script>

<style scoped>
/* Estilos específicos para esta vista si los necesitas */
</style>


<template>
  <div class="container">
    <div class="row mt-5">
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
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link text-success" href="#" aria-label="Previous" @click.prevent="prevPage">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>

            <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
              <a class="page-link text-success" href="#" @click.prevent="goToPage(page)">
                {{ page }}
              </a>
            </li>

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
      filtros: {}, // Almacena los filtros actuales
      totalPages: 1, // Controla la cantidad total de páginas
    };
  },
  methods: {
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
        this.fetchActividades();
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.fetchActividades();
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchActividades();
      }
    },
    fetchActividades() {
      axios
        .get("http://127.0.0.1:8000/api/actividades/index", { 
          params: { 
            ...this.filtros, 
            page: this.currentPage, 
            per_page: this.itemsPerPage 
          } 
        })
        .then((response) => {
          this.actividades = response.data.data || response.data; 
          this.totalPages = response.data.total_pages || Math.ceil(this.actividades.length / this.itemsPerPage);
        })
        .catch((error) => {
          console.error("Error al obtener actividades:", error);
        });
    },
    actualizarFiltros(nuevosFiltros) {
      console.log("Nuevos filtros recibidos:", nuevosFiltros);
      this.filtros = { ...nuevosFiltros };
      this.currentPage = 1; // Reiniciar a la primera página cuando se aplican filtros
      this.fetchActividades();
    },
  },
  mounted() {
    this.fetchActividades();
  },
};
</script>

<style scoped>
/* Estilos específicos para esta vista si los necesitas */
</style>

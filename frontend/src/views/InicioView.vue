<template>
  <div class="container">
    <div class="row mt-5">
      <!-- Se pasa a ActividadList solo la parte de las actividades correspondiente a la página actual -->
      <div class="col-11">
        <ActividadList :actividades="paginatedActividades" />
      </div>  
      <div class="col-1">
        <Filtros ref="filtros" />
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
      actividades: [],   // Aquí se guardarán todas las actividades
      currentPage: 1,
      itemsPerPage: 4,
    };
  },
  computed: {
    // Calcula el número total de páginas según la cantidad de actividades
    totalPages() {
      return Math.ceil(this.actividades.length / this.itemsPerPage);
    },
    // Extrae las actividades que corresponden a la página actual
    paginatedActividades() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      return this.actividades.slice(start, start + this.itemsPerPage);
    },
  },
  methods: {
    // Cambia a una página específica
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    // Avanza a la siguiente página
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    // Retrocede a la página anterior
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
  },
  mounted() {
    // Se obtiene la información de actividades desde Laravel
    axios
      .get("http://127.0.0.1:8000/api/actividades/index")
      .then((response) => {
        this.actividades = response.data;
      })
      .catch((error) => {
        console.error("Error al obtener actividades:", error);
      });
  },
};
</script>

<style scoped>
/* Cambia el color de fondo, borde y texto de la página activa */
.pagination .page-item.active .page-link {
  background-color: #28a745 !important; /* Verde */
  border-color: #28a745 !important;
  color: #fff !important;
}
</style>
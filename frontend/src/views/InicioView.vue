<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-11">
        <!-- Pasamos la paginación y los filtros -->
        <ActividadList 
          :filtros="filtros" 
          :current-page="currentPage" 
          :items-per-page="itemsPerPage" 
          @update-total-pages="setTotalPages" 
        />
      </div>
      <div class="col-1">
        <Filtros @aplicar-filtros="actualizarFiltros" />
      </div>

      <!-- PAGINACIÓN -->
      <div class="col-12 d-flex justify-content-center mt-4">
        <nav aria-label="Paginación">
          <ul class="pagination">
            <!-- Botón Anterior -->
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <button class="page-link text-success" @click="prevPage" :disabled="currentPage === 1">
                &laquo;
              </button>
            </li>

            <!-- Botones de Página -->
            <li 
              class="page-item" 
              v-for="page in totalPages" 
              :key="page" 
              :class="{ active: currentPage === page }"
            >
              <button class="page-link text-success" @click="goToPage(page)">
                {{ page }}
              </button>
            </li>

            <!-- Botón Siguiente -->
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <button class="page-link text-success" @click="nextPage" :disabled="currentPage === totalPages">
                &raquo;
              </button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
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
      filtros: {},
      currentPage: 1,
      itemsPerPage: 4,
      totalPages: 1, // Se actualizará desde ActividadList.vue
    };
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
    actualizarFiltros(nuevosFiltros) {
      this.filtros = { ...nuevosFiltros };
      this.currentPage = 1; // Reinicia la paginación al cambiar los filtros
    },
    setTotalPages(total) {
      console.log("Total de páginas recibido:", total); // Debug
      this.totalPages = total || 1; // Evita valores NaN o undefined
    }
  }
};
</script>

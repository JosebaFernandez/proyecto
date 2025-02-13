// InicioView.vue
<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-11">
        <ActividadList :filtros="filtros" :current-page="currentPage" :items-per-page="itemsPerPage" @update-total-pages="setTotalPages" />
      </div>
      <div class="col-1">
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
      totalPages: 1,
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
      this.currentPage = 1;
    },
    setTotalPages(total) {
      this.totalPages = total;
    }
  }
};
</script>
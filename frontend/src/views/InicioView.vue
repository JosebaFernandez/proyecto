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
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import Filtros from "../components/Filtros.vue";
import ActividadList from "../components/ActividadList.vue";

export default {
  name: "Inicio",
  components: {
    Filtros,
    ActividadList,
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

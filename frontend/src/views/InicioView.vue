<template>
  <div class="container main-container">
    <div class="row">
      <div class="col-6">
        <Filtros ref="filtros" />
      </div>
      <div class="col-6">
        <ActividadList ref="actividadlist" />
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
    ActividadList
  }
};
</script>

<style scoped>
/* Estilos específicos para esta vista si los necesitas */
</style>
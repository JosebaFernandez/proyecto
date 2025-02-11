<template>
  <div class="container">
    <div class="row">
      <div class="col-11">
        <ActividadList ref="actividadlist" />
      </div>  
      <div class="col-1">
        <Filtros ref="filtros" />
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
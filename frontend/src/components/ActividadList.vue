<template>
    <div class="row">
      <div v-for="actividad in actividades" :key="actividad.idActividad" class="col-12 col-sm-6 mb-4">
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
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </template>

  <script>
  export default {
    name: "ActividadList",
    props: {
      actividades: {
        type: Array,
        required: true,
      },
    },
    methods: {
      getImageUrl(imagen) {
        return `http://localhost:8000/storage/${imagen}`;
      },
    },
  };
  </script>

  <style scoped>
  </style>

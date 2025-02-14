<!-- src/views/ActividadDetalle.vue -->
<template>
    <div class="container mt-5">
      <div class="card">
        <div class="card-header">
          <h3>{{ actividad.titulo }}</h3>
        </div>
        <div class="card-body">
          <img :src="getImageUrl(actividad.imagen)" width="400" class="img-fluid mb-3" alt="imagen-actividad">
          <p>{{ actividad.descripcion }}</p>
          <p><strong>Fecha:</strong> {{ actividad.fecha }}</p>
          <p><strong>Lugar:</strong> {{ actividad.lugar }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'ActividadDetalle',
    props: {
      id: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        actividad: {},
      };
    },
    mounted() {
      this.fetchActividad();
    },
    methods: {
      async fetchActividad() {
        try {
          const response = await axios.get(`http://127.0.0.1:8000/api/actividades/show/${this.id}`);
          this.actividad = response.data;
        } catch (error) {
          console.error('Error al obtener la actividad:', error);
        }
      },
      getImageUrl(imagen) {
        return `http://localhost:8000/storage/${imagen}`;
      },
    },
  };
  </script>
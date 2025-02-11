<template>
    <div class="row ">
        <!-- Iterar sobre las actividades -->
        <div v-for="actividad in actividades" :key="actividad.idActividad" class="col-12 col-sm-6 mb-4">
            <div class="card my-card h-100 ">
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
import axios from "axios";

export default {

    name: "ActividadList",
    data() {
        return {
            actividades: [],
        };
    },
    created() {
        this.fetchActividades();
    },
    methods: {
        async fetchActividades() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/actividades/index"); 
                this.actividades = response.data;
            } catch (error) {
                console.error("Error al obtener actividades:", error);
            }
        },
        updateList(newActividad) {
            this.actividades.push(newActividad);
        },
        getImageUrl(imagen) {
            return `http://localhost:8000/storage/${imagen}`;
        }
    },
};
</script>

<style scoped>
.my-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease; /* Para suavizar la animación */
  cursor: pointer; /* Cambiar el cursor a mano */
}

.my-card:hover {
  transform: scale(1.03); /* Agrandar la tarjeta */
  box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); /* Agregar sombra para resaltar */
}

.my-card a {
  text-decoration: none; /* Elimina subrayado del enlace */
}
</style>
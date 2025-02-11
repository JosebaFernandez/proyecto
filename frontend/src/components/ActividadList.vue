<template>
    <div class="row">
        <!-- Iterar sobre las actividades -->
        <div v-for="actividad in actividades" :key="actividad.idActividad" class="col-12 col-sm-4 mb-3">
            <div class="card h-100">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="..." class="img-fluid rounded-start" alt="...">
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
        }
    },
};
</script>

<style scoped>
/* Estilos específicos para este componente si los necesitas */
</style>
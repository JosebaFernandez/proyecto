<template>
    <div class="row">
        <div v-for="actividad in actividades" :key="actividad.idActividad" class="col-12 col-sm-6 mb-4">
            <div class="card my-card h-100">
                <div class="row g-0">
                    <div class="col-md-4 d-flex">
                        <img :src="getImageUrl(actividad.imagen)" class="img-fluid rounded-start flex-fill"
                            alt="imagen-actividad">
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
    props: {
        
        filtros: {
            type: Object,
            default: () => ({}), // Asegura que los filtros sean un objeto vacío por defecto
        },
    },
    data() {
        return {
            actividades: [],
        };
    },
    watch: {
        // Reaccionamos cuando los filtros cambian
        filtros: "fetchActividades",
    },
    methods: {
       async fetchActividades() {
            try {
                // Si los filtros están vacíos, no los enviamos
                const response = await axios.get("http://127.0.0.1:8000/api/actividades/index", {
                    params: Object.keys(this.filtros).length ? this.filtros : {} // Enviamos filtros solo si existen
                });
                this.actividades = response.data;
            } catch (error) {
                console.error("Error al obtener actividades:", error);
            }
        },
        getImageUrl(imagen) {
            return `http://localhost:8000/storage/${imagen}`;
        },
    },
};
</script>

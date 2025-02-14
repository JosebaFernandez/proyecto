<template>
    <div class="row">
        <div v-for="actividad in actividades" :key="actividad.id" class="col-12 col-sm-6 mb-4">
            <div class="card my-card h-100" @click="goToActividadShow(actividad.id)">
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

                            <butto class="btn btn-outline-success">Apuntarse</butto>
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
            default: () => ({})
        },
        currentPage: {
            type: Number,
            required: true
        },
        itemsPerPage: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            actividades: [],
            totalPages: 1,
        };
    },
    watch: {
        filtros: {
            handler: "fetchActividades",
            deep: true
        },
        currentPage: "fetchActividades"
    },
    mounted() {
        this.fetchActividades();
    },
    methods: {
        async fetchActividades() {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/actividades/index", {
                    params: {
                        ...this.filtros,
                        page: this.currentPage,
                        per_page: this.itemsPerPage
                    }
                });
                this.actividades = response.data.data || response.data;
                this.totalPages = response.data.total_pages || Math.ceil(this.actividades.length / this.itemsPerPage);
                this.$emit("update-total-pages", this.totalPages);
            } catch (error) {
                console.error("Error al obtener actividades:", error);
            }
        },
        getImageUrl(imagen) {
            return `http://localhost:8000/storage/${imagen}`;
        },
        goToActividadShow(idActividad) {
            this.$router.push({ name: "ActividadShow", params: { id: idActividad } });
        }
    },
};
</script>
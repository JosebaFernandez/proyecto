<template>
    <button class="btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions"
        aria-controls="offcanvasWithBothOptions">Filtros</button>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Filtros</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form @submit.prevent="handleSubmit">
                <div class="row">
                    <div class="col-6">
                        <label for="fInicio">Desde:</label>
                        <input type="date" id="fInicio" name="fInicio" class="form-control" v-model="filtros.fInicio">
                    </div>
                    <div class="col-6">
                        <label for="fFin">Hasta:</label>
                        <input type="date" id="fFin" name="fFin" class="form-control" v-model="filtros.fFin">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="lugar">Lugar: </label>
                        <select class="form-select" v-model="filtros.lugar">
                            <option value="">Selecciona</option>
                            <option value="C.C. Abetxuko">C.C. Abetxuko</option>
                            <option value="C.C. Aldabe">C.C. Aldabe</option>
                            <option value="C.C. Arana">C.C. Arana</option>
                            <option value="C.C. Ariznabarra">C.C. Ariznabarra</option>
                            <option value="C.C. Arriaga">C.C. Arriaga</option>
                            <option value="C.C. El Campillo">C.C. El Campillo</option>
                            <option value="C.C. El Pilar">C.C. El Pilar</option>
                            <option value="C.C. Hegoalde">C.C. Hegoalde</option>
                            <option value="C.C. Ibaiondo">C.C. Ibaiondo</option>
                            <option value="C.C. Iparralde">C.C. Iparralde</option>
                            <option value="C.C. Judimendi">C.C. Judimendi</option>
                            <option value="C.C. Lakua">C.C. Lakua</option>
                            <option value="C.C. Salburua">C.C. Salburua</option>
                            <option value="C.C. Zabalgana">C.C. Zabalgana</option>

                        </select>
                    </div>
                    <div class="col-6">
                        <label for="idioma">Idioma: </label>
                        <select class="form-select" v-model="filtros.idioma">
                            <option value="">Selecciona</option>
                            <option value="Castellano">Castellano</option>
                            <option value="Euskera">Euskera</option>
                            <option value="Inglés">Inglés</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="edadMin">Edad mínima:</label>
                        <input type="number" id="edadMin" name="edadMin" class="form-control" min="0"
                            v-model="filtros.edad_minima">
                    </div>
                    <div class="col-6">
                        <label for="edadMax">Edad máxima:</label>
                        <input type="number" id="edadMax" name="edadMax" class="form-control" min="0"
                            v-model="filtros.edad_maxima">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="hInicio">Desde las:</label>
                        <input type="time" id="hInicio" name="hInicio" class="form-control" v-model="filtros.hInicio">
                    </div>
                    <div class="col-6">
                        <label for="hFin">Hasta las:</label>
                        <input type="time" id="hFin" name="hFin" class="form-control" v-model="filtros.hFin">
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-success m-2" @click="handleSubmit">
                        Filtrar
                    </button>
                    <button type="button" class="btn btn-outline-success m-2" @click="resetFilters">
                        Resetear Filtros
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const emit = defineEmits(["aplicar-filtros"]);

const filtros = ref({
    fInicio: "",
    fFin: "",
    lugar: "",
    idioma: "",
    edad_minima: "",
    edad_maxima: "",
    hInicio: "",
    hFin: ""
});

// Función para manejar el envío del formulario
const handleSubmit = () => {
    // Filtrar campos vacíos para no enviar filtros innecesarios
    const filtrosAplicados = Object.fromEntries(
        Object.entries(filtros.value).filter(([_, value]) => value !== "")
    );

    emit("aplicar-filtros", filtrosAplicados);
};

// Función para resetear los filtros
const resetFilters = () => {
    // Restaurar los valores a los predeterminados
    filtros.value = {
        fInicio: "",
        fFin: "",
        lugar: "",
        idioma: "",
        edad_minima: "",
        edad_maxima: "",
        hInicio: "",
        hFin: ""
    };

    // Emitir un evento con los filtros vacíos para recargar las actividades
    emit("aplicar-filtros", {});
};
</script>

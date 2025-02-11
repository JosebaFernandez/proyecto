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
            <form method="post" action="#" @submit.prevent="handleSubmit">
                <div>
                    <label for="fInicio">Desde:</label>
                    <input type="date" id="fInicio" name="fInicio" class="form-control">
                </div>
                <div>
                    <label for="fFin">Hasta:</label>
                    <input type="date" id="fFin" name="fFin" class="form-control">
                </div>
                <div>
                    <label for="lugar">Lugar: </label>
                    <select class="form-select" aria-label="lugar" name="lugar">
                        <option selected>Selecciona</option>
                        <option value="1">C.C. Hegoalde</option>
                        <option value="2">C.C. El Pilar</option>
                        <option value="3">C.C. Ibaiondo</option>
                    </select>
                </div>
                <div>
                    <label for="idioma">Idioma: </label>
                    <select class="form-select" aria-label="idioma" name="idioma">
                        <option selected>Selecciona</option>
                        <option value="1">Castellano</option>
                        <option value="2">Euskera</option>
                        <option value="3">Inglés</option>
                    </select>
                </div>
                <div>
                    <label for="edad">Edad:</label>
                    <input type="number" id="edad" name="edad" class="form-control" min="0">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

</template>


<script setup>
// Lógica del componente si es necesario
</script>

<style scoped>
/* Estilos específicos para este componente si los necesitas */
</style>
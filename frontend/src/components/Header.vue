<template>
    <div class="header">
        <nav class="navbar bg-success" style="--bs-bg-opacity: .5;">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="../assets/logo_grande.svg" alt="Bootstrap" width="250px">
                </a>
                <div class="d-flex">
                    <!-- Botón para ir al formulario -->
                    <router-link to="/crear-actividad" class="btn btn-outline-light me-2">
                        Crear Actividad
                    </router-link>
                    <!-- Botón de Login -->
                    <button class="btn btn-outline-light" type="button">Login</button>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
</script>

<style scoped></style>

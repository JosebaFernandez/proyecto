<!-- src/components/ModalLogin.vue -->
<template>
    <div class="modal fade" id="bootstrapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ isLogin ? 'Iniciar sesión' : 'Registrarse' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="validarEnvio">

                        <div v-if="!isLogin" class="mb-4">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" v-model="nombre" required/>
                        </div>

                        <div v-if="!isLogin" class="mb-4">
                            <label for="apellido1" class="form-label">Primer apellido:</label>
                            <input type="text" class="form-control" id="apellido1" v-model="apellido1" required/>
                        </div>

                        <div v-if="!isLogin" class="mb-4">
                            <label for="apellido2" class="form-label">Segundo apellido:</label>
                            <input type="text" class="form-control" id="apellido2" v-model="apellido2" required/>
                        </div>

                        <div class="mb-4">
                            <label for="dni" class="form-label">DNI:</label>
                            <input type="text" class="form-control" id="dni" v-model="dni" required/>
                        </div>

                        <div v-if="!isLogin" class="mb-4">
                            <label for="fechaNacimiento" class="form-label">Fecha de nacimiento:</label>
                            <input type="date" class="form-control" id="fechaNacimiento" v-model="fechaNacimiento" required/>
                        </div>

                        <hr v-if="!isLogin">
                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="password" v-model="password" required/>
                        </div>

                        <div v-if="!isLogin" class="mb-4">
                            <label for="confirmPassword" class="form-label">Confirmar contraseña:</label>
                            <input type="password" class="form-control" id="confirmPassword" v-model="confirmPassword" required/>
                        </div>
                    </form>

                    <div class="mt-3">
                        <p class="text-center">
                            {{ isLogin ? "¿No tienes cuenta?" : "¿Ya tienes cuenta?" }}
                            <a href="#" @click.prevent="toggleForm">{{ isLogin ? 'Regístrate aquí' : 'Inicia sesión aquí' }}</a>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="validarEnvio">{{ isLogin ? 'Iniciar sesión' : 'Registrarse' }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast de Bootstrap -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ errorMessage }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const nombre = ref('');
const apellido1 = ref('');
const apellido2 = ref('');
const dni = ref('');
const fechaNacimiento = ref('');
const password = ref('');
const confirmPassword = ref('');
const errorMessage = ref('');
const isLogin = ref(true);

const validarEnvio = () => {
    const dniRegex = /^[0-9]{8}[A-Za-z]$/;

    if (isLogin.value) {
        if (!dni.value || !password.value) {
            errorMessage.value = 'Por favor, ingresa ambos campos.';
            mostrarToast();
            return;
        }

        if (!dniRegex.test(dni.value)) {
            errorMessage.value = 'El DNI no tiene un formato válido.';
            mostrarToast();
            return;
        }


    }

    if (!isLogin.value) {
        if (!nombre.value || !apellido1.value || !apellido2.value || !fechaNacimiento.value) {
            errorMessage.value = 'Por favor, completa todos los campos.';
            mostrarToast();
            return;
        }

        if (!dniRegex.test(dni.value)) {
            errorMessage.value = 'El DNI no tiene un formato válido.';
            mostrarToast();
            return;
        }

        if (password.value !== confirmPassword.value) {
            errorMessage.value = 'Las contraseñas no coinciden.';
            mostrarToast();
            return;
        }
        
    }

    nombre.value = '';
    apellido1.value = '';
    apellido2.value = '';
    dni.value = '';
    fechaNacimiento.value = '';
    password.value = '';
    confirmPassword.value = '';
    errorMessage.value = '';

    const modalElement = document.getElementById('bootstrapModal');
    const modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.hide();
};

const toggleForm = () => {
    isLogin.value = !isLogin.value;
};

const mostrarToast = () => {
    const toastElement = document.getElementById('errorToast');
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
};
</script>
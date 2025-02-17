<template>
    <div class="modal fade" id="bootstrapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!--Operador ternario para determinar el titulo-->
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

                    <!--Enlace para cambiar entre el formulario de inicio de sesión y el de registro-->
                    <div class="mt-3">
                        <p class="text-center">
                            {{ isLogin ? "¿No tienes cuenta?" : "¿Ya tienes cuenta?" }}
                            <a href="#" @click.prevent="toggleForm">{{ isLogin ? 'Regístrate aquí' : 'Inicia sesión aquí' }}</a>
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" @click="validarEnvio">{{ isLogin ? 'Iniciar sesión' : 'Registrarse' }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toasts para mostrar mensajes de error y éxito -->
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

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ successMessage }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';
import axios from 'axios';

// Variables reactivas para almacenar los datos del formulario
const nombre = ref('');
const apellido1 = ref('');
const apellido2 = ref('');
const dni = ref('');
const fechaNacimiento = ref('');
const password = ref('');
const confirmPassword = ref('');
const errorMessage = ref('');
const successMessage = ref('');
const isLogin = ref(true);

// Define los eventos que el componente puede emitir
const emit = defineEmits(['loginSuccess']);

//Función para validar los datos antes de enviar la solicitud al servidor
const validarEnvio = async () => {

    //Regex DNI (8 números seguidos de una letra mayúscula)
    const dniRegex = /^[0-9]{8}[A-Z]$/;

    //Comprueba si es login y valida los campos
    if (isLogin.value) {
        if (!dni.value || !password.value) {
            errorMessage.value = 'Por favor, ingresa ambos campos.';
            mostrarToast('error');
            return;
        }

        if (!dniRegex.test(dni.value)) {
            errorMessage.value = 'El DNI no tiene un formato válido.';
            mostrarToast('error');
            return;
        }
    }

    //Valida el registro
    if (!isLogin.value) {
        if (!nombre.value || !apellido1.value || !apellido2.value || !fechaNacimiento.value) {
            errorMessage.value = 'Por favor, completa todos los campos.';
            mostrarToast('error');
            return;
        }

        //Valida que la fecha no pueda ser mayor a la fecha actual
        if(fechaNacimiento.value > new Date().toISOString().split('T')[0]) {
            errorMessage.value = 'La fecha de nacimiento no puede ser mayor a la fecha actual.';
            mostrarToast('error');
            return;
        }

        if (!dniRegex.test(dni.value)) {
            errorMessage.value = 'El DNI no tiene un formato válido.';
            mostrarToast('error');
            return;
        }

        if (password.value !== confirmPassword.value) {
            errorMessage.value = 'Las contraseñas no coinciden.';
            mostrarToast('error');
            return;
        }
    }

    //Envía la solicitud al servidor
    try {

        //Genera la URL de la solicitud con un operador ternario
        const url = isLogin.value ? 'http://localhost:8000/api/auth/login' : 'http://localhost:8000/api/usuarios/register';

        //Crea un objeto con los datos del formulario. En función de si es login o registro mandará unos datos u otros
        const data = isLogin.value
            ? { dni: dni.value, password: password.value }
            : {
                  nombre: nombre.value,
                  apellido1: apellido1.value,
                  apellido2: apellido2.value,
                  dni: dni.value,
                  fecha_nacimiento: fechaNacimiento.value,
                  password: password.value,
                  confirm_password: confirmPassword.value
              };

        const response = await axios.post(url, data);

        //Comprueba la respuesta del servidor y realiza las acciones consecuentes
        if (response.status === 200 || response.status === 201) {
            //Si es login guarda los datos en LocalStorage y emite el evento
            if (isLogin.value) {
                localStorage.setItem('user', JSON.stringify(response.data.user));
                localStorage.setItem('role', response.data.role);
                successMessage.value = `Bienvenido, ${response.data.user.nombre}.`;

                emit('loginSuccess');
            }
            else {
                successMessage.value = 'Registro exitoso.';
                isLogin.value = true;
            }
            mostrarToast('success');
        } 
        else {
            errorMessage.value = 'Ocurrió un error. Por favor, inténtalo de nuevo.';
            mostrarToast('error');
        }
    } 
    catch (error) {
        errorMessage.value = 'Ocurrió un error. Por favor, inténtalo de nuevo.';
        mostrarToast('error');
    }

    //Limpia los campos del formulario
    nombre.value = '';
    apellido1.value = '';
    apellido2.value = '';
    dni.value = '';
    fechaNacimiento.value = '';
    password.value = '';
    confirmPassword.value = '';
    errorMessage.value = '';

    //Oculta el modal
    const modalElement = document.getElementById('bootstrapModal');
    const modalInstance = new bootstrap.Modal(modalElement);
    modalInstance.hide();
};

const toggleForm = () => {
    isLogin.value = !isLogin.value;
};

const mostrarToast = (type) => {
    const toastElement = document.getElementById(type === 'error' ? 'errorToast' : 'successToast');
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
};

</script>
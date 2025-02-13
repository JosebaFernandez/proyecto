<template>
    <div class="container">
      <div class="row mt-5">
        <div class="col-8 m-auto">
          <h2 class="mb-4 text-success">Crear Nueva Actividad</h2>
  
          <!-- Formulario sin VeeValidate -->
          <form @submit.prevent="submitForm">
            <!-- Título -->
            <div class="mb-3">
              <label class="form-label">Título</label>
              <input v-model="form.titulo" class="form-control" />
              <span class="text-danger">{{ errors.titulo }}</span>
            </div>
  
            <!-- Descripción -->
            <div class="mb-3">
              <label class="form-label">Descripción</label>
              <textarea v-model="form.descripcion" class="form-control"></textarea>
              <span class="text-danger">{{ errors.descripcion }}</span>
            </div>
  
            <!-- Lugar -->
            <div class="mb-3">
              <label class="form-label">Lugar</label>
              <input v-model="form.lugar" class="form-control" />
              <span class="text-danger">{{ errors.lugar }}</span>
            </div>
  
            <!-- Edad Mínima -->
            <div class="mb-3">
              <label class="form-label">Edad Mínima</label>
              <input v-model="form.edadMinima" type="number" class="form-control" />
              <span class="text-danger">{{ errors.edadMinima }}</span>
            </div>
  
            <!-- Edad Máxima -->
            <div class="mb-3">
              <label class="form-label">Edad Máxima</label>
              <input v-model="form.edadMaxima" type="number" class="form-control" />
              <span class="text-danger">{{ errors.edadMaxima }}</span>
            </div>
  
            <!-- Fecha -->
            <div class="mb-3">
              <label class="form-label">Fecha</label>
              <input v-model="form.fecha" type="date" class="form-control" />
              <span class="text-danger">{{ errors.fecha }}</span>
            </div>
  
            <!-- Hora -->
            <div class="mb-3">
              <label class="form-label">Hora</label>
              <input v-model="form.hora" type="time" class="form-control" />
              <span class="text-danger">{{ errors.hora }}</span>
            </div>
  
            <!-- Idioma -->
            <div class="mb-3">
              <label class="form-label">Idioma</label>
              <select v-model="form.idioma" class="form-control">
                <option value="">Seleccione un idioma</option>
                <option value="español">Español</option>
                <option value="ingles">Inglés</option>
                <option value="frances">Francés</option>
                <option value="aleman">Alemán</option>
              </select>
              <span class="text-danger">{{ errors.idioma }}</span>
            </div>
  
            <!-- Imagen -->
            <div class="mb-3">
              <label class="form-label">Imagen</label>
              <input type="file" class="form-control" @change="handleImageUpload" />
              <span class="text-danger">{{ errors.imagen }}</span>
              <div v-if="previewImage" class="mt-2">
                <img :src="previewImage" alt="Vista previa" class="img-thumbnail" style="max-width: 200px;">
              </div>
            </div>
  
            <!-- Botones -->
            <div class="d-flex gap-2 mb-3">
              <button type="submit" class="btn btn-success">Crear Actividad</button>
              <button type="button" class="btn btn-outline-secondary" @click="volverInicio">Volver</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Field, Form } from "vee-validate";
  import * as yup from "yup";
  import axios from "axios";
  import { useRouter } from "vue-router";
  
  export default {
    setup() {
      const router = useRouter();
  
      const volverInicio = () => {
        router.push("/");
      };
  
      return { volverInicio };
    },
    data() {
      return {
        form: {
          titulo: "",
          descripcion: "",
          lugar: "",
          edadMinima: null,
          edadMaxima: null,
          fecha: "",
          hora: "",
          idioma: "",
          imagen: null,
        },
        previewImage: null,
        errors: {},
      };
    },
    methods: {
      validateForm() {
        this.errors = {};
  
        // Validaciones
        if (!this.form.titulo || this.form.titulo.length < 3) {
          this.errors.titulo = "El título es obligatorio y debe tener al menos 3 caracteres";
        }
        if (!this.form.descripcion || this.form.descripcion.length < 10) {
          this.errors.descripcion = "La descripción es obligatoria y debe ser más detallada";
        }
        if (!this.form.lugar || this.form.lugar.length < 2) {
          this.errors.lugar = "El lugar es obligatorio y debe ser más específico";
        }
        if (this.form.edadMinima <= 0 || !Number.isInteger(this.form.edadMinima)) {
          this.errors.edadMinima = "La edad mínima es obligatoria y debe ser un número entero positivo";
        }
        if (this.form.edadMaxima <= 0 || !Number.isInteger(this.form.edadMaxima) || this.form.edadMaxima < this.form.edadMinima) {
          this.errors.edadMaxima = "La edad máxima debe ser un número mayor o igual a la edad mínima";
        }
        if (!this.form.fecha || new Date(this.form.fecha) <= new Date()) {
          this.errors.fecha = "La fecha debe ser en el futuro";
        }
        if (!this.form.hora) {
          this.errors.hora = "La hora es obligatoria";
        }
        if (!this.form.idioma) {
          this.errors.idioma = "Debe seleccionar un idioma";
        }
        if (this.form.imagen && this.form.imagen.size > 2097152) {
          this.errors.imagen = "La imagen debe ser menor de 2MB";
        }
  
        return Object.keys(this.errors).length === 0;
      },
      async submitForm() {
        if (this.validateForm()) {
          try {
            let formData = new FormData();
            formData.append("titulo", this.form.titulo);
            formData.append("descripcion", this.form.descripcion);
            formData.append("lugar", this.form.lugar);
            formData.append("edad_minima", this.form.edadMinima || '');
            formData.append("edad_maxima", this.form.edadMaxima || '');
            formData.append("fecha", this.form.fecha);
            formData.append("hora", this.form.hora);
            formData.append("idioma", this.form.idioma);
  
            // Solo se agrega imagen si está seleccionada
            if (this.form.imagen) {
              formData.append("imagen", this.form.imagen);
            }
  
            const response = await axios.post("http://127.0.0.1:8000/api/actividades/store", formData, {
              headers: { "Content-Type": "multipart/form-data" },
            });
            
            // Redirigir a la página de inicio
            this.$router.push("/");
            console.log(response.data);
          } catch (error) {
            console.error("Error al crear actividad:", error);
          }
        }
      },
      handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
          this.form.imagen = file;
          const reader = new FileReader();
          reader.onload = (e) => {
            this.previewImage = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      },
    },
  };
  </script>
  
  <style scoped>
    .container {
    max-width: 900px;
    }
  </style>
  
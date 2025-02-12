<template>
    <div class="container">
      <div class="row mt-5">
        <div class="col-8">
          <h2 class="mb-4 text-success">Crear Nueva Actividad</h2>

          <!-- Formulario con VeeValidate -->
          <Form @submit="submitForm" :validation-schema="schema" v-slot="{ errors }">
            <!-- Título -->
            <div class="mb-3">
              <label class="form-label">Título</label>
              <Field name="titulo" v-model="form.titulo" class="form-control" />
              <span class="text-danger">{{ errors.titulo }}</span>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
              <label class="form-label">Descripción</label>
              <Field name="descripcion" v-model="form.descripcion" as="textarea" class="form-control" />
              <span class="text-danger">{{ errors.descripcion }}</span>
            </div>

            <!-- Lugar -->
            <div class="mb-3">
              <label class="form-label">Lugar</label>
              <Field name="lugar" v-model="form.lugar" class="form-control" />
              <span class="text-danger">{{ errors.lugar }}</span>
            </div>

            <!-- Edad Mínima -->
            <div class="mb-3">
              <label class="form-label">Edad Mínima</label>
              <Field name="edadMinima" v-model="form.edadMinima" type="number" class="form-control" />
              <span class="text-danger">{{ errors.edadMinima }}</span>
            </div>

            <!-- Edad Máxima -->
            <div class="mb-3">
              <label class="form-label">Edad Máxima</label>
              <Field name="edadMaxima" v-model="form.edadMaxima" type="number" class="form-control" />
              <span class="text-danger">{{ errors.edadMaxima }}</span>
            </div>

            <!-- Fecha -->
            <div class="mb-3">
              <label class="form-label">Fecha</label>
              <Field name="fecha" v-model="form.fecha" type="date" class="form-control" />
              <span class="text-danger">{{ errors.fecha }}</span>
            </div>

            <!-- Hora -->
            <div class="mb-3">
              <label class="form-label">Hora</label>
              <Field name="hora" v-model="form.hora" type="time" class="form-control" />
              <span class="text-danger">{{ errors.hora }}</span>
            </div>

            <!-- Idioma -->
            <div class="mb-3">
              <label class="form-label">Idioma</label>
              <Field name="idioma" v-model="form.idioma" as="select" class="form-control">
                <option value="">Seleccione un idioma</option>
                <option value="español">Español</option>
                <option value="ingles">Inglés</option>
                <option value="frances">Francés</option>
                <option value="alemán">Alemán</option>
              </Field>
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
          </Form>
        </div>

        <!-- Espacio para filtros u otra funcionalidad -->
        <div class="col-4">
          <Filtros ref="filtros" />
        </div>
      </div>
    </div>
  </template>

  <script>
  import { Field, Form } from "vue-validate";
  import * as yup from "yup";
  import axios from "axios";
  import { useRouter } from "vue-router";
  import Filtros from "../components/Filtros.vue";

  export default {
    components: { Field, Form, Filtros },
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
        // 📌 Validaciones con Yup
        schema: yup.object().shape({
          titulo: yup.string().required("El título es obligatorio").min(3, "Debe tener al menos 3 caracteres"),
          descripcion: yup.string().required("La descripción es obligatoria").min(10, "Debe ser más detallada"),
          lugar: yup.string().required("El lugar es obligatorio").min(2, "Debe ser más específico"),
          edadMinima: yup
            .number()
            .required("La edad mínima es obligatoria")
            .positive("Debe ser un número positivo")
            .integer("Debe ser un número entero"),
          edadMaxima: yup
            .number()
            .required("La edad máxima es obligatoria")
            .positive("Debe ser un número positivo")
            .integer("Debe ser un número entero")
            .min(yup.ref("edadMinima"), "Debe ser mayor o igual a la edad mínima"),
          fecha: yup.date().required("La fecha es obligatoria").min(new Date(), "La fecha debe ser en el futuro"),
          hora: yup.string().required("La hora es obligatoria"),
          idioma: yup.string().required("Debe seleccionar un idioma"),
          imagen: yup.mixed().test("fileSize", "La imagen debe ser menor de 2MB", (file) => {
            return !file || file.size <= 2097152;
          }),
        }),
      };
    },
    methods: {
      async submitForm() {
        try {
          let formData = new FormData();
          formData.append("titulo", this.form.titulo);
          formData.append("descripcion", this.form.descripcion);
          formData.append("lugar", this.form.lugar);
          formData.append("edadMinima", this.form.edadMinima);
          formData.append("edadMaxima", this.form.edadMaxima);
          formData.append("fecha", this.form.fecha);
          formData.append("hora", this.form.hora);
          formData.append("idioma", this.form.idioma);
          if (this.form.imagen) {
            formData.append("imagen", this.form.imagen);
          }

          const response = await axios.post("http://127.0.0.1:8000/api/actividades/store", formData, {
            headers: { "Content-Type": "multipart/form-data" },
          });

          alert("Actividad creada con éxito 🎉");
          console.log(response.data);
        } catch (error) {
          console.error("Error al crear actividad:", error);
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

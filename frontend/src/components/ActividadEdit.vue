<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-8 m-auto">
        <h2 class="mb-4 text-success">Editar Actividad</h2>

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
            <select v-model="form.lugar" class="form-control">
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
            <button type="submit" class="btn btn-success">Actualizar Actividad</button>
            <button type="button" class="btn btn-outline-secondary" @click="volverInicio">Volver</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { useRouter, useRoute } from "vue-router";

export default {
  setup() {
    const router = useRouter();
    const route = useRoute();

    const volverInicio = () => {
      router.push("/");
    };

    return { volverInicio, route };
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
  created() {
    this.fetchActividadData();
  },
  methods: {
    // Método para obtener los datos de la actividad
    async fetchActividadData() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/actividades/show/${this.$route.params.id}`);
        const actividad = response.data;

        // Asignar los valores al formulario
        this.form.titulo = actividad.titulo;
        this.form.descripcion = actividad.descripcion;
        this.form.lugar = actividad.lugar;
        this.form.edadMinima = actividad.edad_minima;
        this.form.edadMaxima = actividad.edad_maxima;
        this.form.fecha = actividad.fecha;
        this.form.hora = actividad.hora;
        this.form.idioma = actividad.idioma;

        // Asignar imagen si existe
        if (actividad.imagen) {
          this.previewImage = `http://127.0.0.1:8000/storage/${actividad.imagen}`;
          this.form.imagen = actividad.imagen;  // Conservar la imagen si ya está presente
        }
      } catch (error) {
        console.error("Error al obtener la actividad:", error);
      }
    },

    // Método para validar los datos del formulario
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

      // Validación solo si la imagen se cambia
      if (this.form.imagen && this.form.imagen.size > 2097152) {
        this.errors.imagen = "La imagen debe ser menor de 2MB";
      }

      return Object.keys(this.errors).length === 0;
    },

    // Método para enviar los datos del formulario
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

          // Se debe utilizar la ruta para actualizar la actividad
          const response = await axios.post(`http://127.0.0.1:8000/api/actividades/update/${this.$route.params.id}`, formData, {
            headers: { "Content-Type": "multipart/form-data" },
          });

          // Redirigir a la página de inicio
          this.$router.push("/");
          console.log(response.data);
        } catch (error) {
          console.error("Error al actualizar actividad:", error);
        }
      }
    },

    // Método para manejar la carga de la imagen
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
      // Si no se carga ninguna imagen, se muestra la imagen previa de la actividad
      else {
        this.previewImage = this.form.imagen ? `http://127.0.0.1:8000/storage/${this.form.imagen}` : null;
      }
    },
  },
};
</script>

<style scoped>
/* Aquí puedes agregar tus estilos personalizados */
</style>

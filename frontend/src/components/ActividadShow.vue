<!-- filepath: /c:/Users/1gdaw01/Desktop/proyecto/frontend/src/components/ActividadShow.vue -->
  <template>
    <div class="container mt-5">
      <div class="card custom-card">
        <div class="card-body d-flex">
          <div class="image-container">
            <img :src="getImageUrl(actividad.imagen)" class="img-fluid" alt="imagen-actividad">
          </div>
          <div class="content-container">
            <div class="d-flex justify-content-between align-items-start">
              <h3 class="actividad-titulo">{{ actividad.titulo }}</h3>
              <div>
                <button 
                  v-if="userId && !actividad.isUserEnrolled" 
                  class="btn btn-outline-success mr-2"
                  @click="apuntarse(actividad.id)">
                  Apuntarse
                </button>
                <button v-if="rol == 'admin'" class="btn btn-outline-warning mr-2" type="button" @click="goToUpdate()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="21" height="25" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                  </svg>  
                </button>   
                <button v-if="rol == 'admin'" class="btn btn-outline-danger" type="button" @click="openDeleteModal(actividad.id)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                  </svg>
                </button>
              </div>
            </div>
            <p class="actividad-descripcion">{{ actividad.descripcion }}</p>
            <p class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3 me-2" viewBox="0 0 16 16">
                <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
              </svg>
              {{ actividad.fecha }}
            </p>
            <p class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-map me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8z"/>
                <path fill-rule="evenodd" d="M8 1a3 3 0 1 0 0 6 3 3 0 0 0 0-6M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z"/>
              </svg>
              {{ actividad.lugar }}
            </p>
            <p class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-translate me-2" viewBox="0 0 16 16">
                <path d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286zm1.634-.736L5.5 3.956h-.049l-.679 2.022z"/>
                <path d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm7.138 9.995q.289.451.63.846c-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6 6 0 0 1-.415-.492 2 2 0 0 1-.94.31"/>
              </svg>
              {{ actividad.idioma }}
            </p>
            <p class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock me-2" viewBox="0 0 16 16">
                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
              </svg>
              {{ formatHora(actividad.hora) }}
            </p>
            <p class="d-flex align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
              </svg>
              Entre {{ actividad.edad_minima }} y {{ actividad.edad_maxima }} años
            </p>
          </div>
        </div>
      </div>

      <!-- Toast de confirmación -->
      <div v-if="showToast" class="toast-container">
        Te has apuntado al curso con éxito
      </div>

      <!-- Modal de confirmación de borrado -->
      <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Confirmar Borrado</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              ¿Estás seguro de que deseas borrar esta actividad?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-danger" @click="confirmDelete">Borrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  import { Modal } from 'bootstrap';

  export default {
    name: 'ActividadShow',
    props: {
      id: {
        type: String,
        required: true,
      },
    },
    data() {
      return {
        actividad: {},
        userId: null,
        showToast: false,
        rol: localStorage.getItem('role'),
        deleteModal: null,
        actividadIdToDelete: null,
      };
    },
    mounted() {
      this.fetchActividad();
      this.loadUser();
      this.deleteModal = new Modal(document.getElementById('deleteModal'));
    },
    methods: {
      // Obtener los detalles de la actividad
      async fetchActividad() {
        try {
          const response = await axios.get(`http://127.0.0.1:8000/api/actividades/show/${this.id}`);
          this.actividad = response.data;

          // Verificamos si el usuario está apuntado en la base de datos
          if (this.userId) {
            const enrollmentResponse = await axios.get(
              `http://127.0.0.1:8000/api/actividades/check-enrollment/${this.userId}/${this.actividad.id}`
            );
            this.actividad.isUserEnrolled = enrollmentResponse.data.isEnrolled;
          }
        } catch (error) {
          console.error('Error al obtener la actividad:', error);
        }
      },
    goToUpdate() {
      this.$router.push(`/actividades/${this.actividad.id}/editar`);
    },

    // Método para apuntarse a la actividad
    async apuntarse(idActividad) {
      try {
        if (!idActividad || !this.userId) {
          console.error("Error: idActividad o userId son undefined.");
          return;
        }
      } catch (error) {
        console.error("Error al inscribirse:", error.response?.data || error);
      }
    },
      formatHora(hora) {
      if (!hora) return ""; // Si no hay hora, devolver vacío
      return hora.slice(0, 5); // Toma solo "HH:mm"
      }, 

      // Método para obtener la URL de la imagen
      getImageUrl(imagen) {
        return `http://localhost:8000/storage/${imagen}`;
      },

      // Cargar el objeto de usuario desde localStorage y obtener su ID
      loadUser() {
        const user = JSON.parse(localStorage.getItem("user"));
        if (user) {
          this.userId = user.id; // Usamos el ID del objeto usuario almacenado
        }
      },

      // Método para apuntarse a la actividad
      async apuntarse(idActividad) {
        try {
          if (!idActividad || !this.userId) {
            console.error("Error: idActividad o userId son undefined.");
            return;
          }

          const response = await axios.post(
            `http://127.0.0.1:8000/api/actividades/asignar/${this.userId}`,
            { actividad_id: idActividad },
            { headers: { "Content-Type": "application/json" } }
          );

          // Actualizamos localmente el estado de la actividad
          if (this.actividad.id === idActividad) {
            this.actividad.isUserEnrolled = true;
          }

          this.showToast = true;
          setTimeout(() => {
            this.showToast = false;
          }, 3000);
        } catch (error) {
          console.error("Error al inscribirse:", error.response?.data || error);
        }
      },

      openDeleteModal(id) {
        this.actividadIdToDelete = id;
        this.deleteModal.show();
      },

      async confirmDelete() {
        try {
          await axios.post(`http://127.0.0.1:8000/api/actividades/destroy/${this.actividadIdToDelete}`);
          this.deleteModal.hide();
          // Redirigir o actualizar la vista después de borrar la actividad
          this.$router.push('/');
        } catch (error) {
          console.error('Error al borrar la actividad:', error);
        }
      }
    }
  };
  </script>

  <style scoped>
  .toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
  }
  </style>
<template>
    <div class="container">
<SidebarMenu></SidebarMenu>
      <h1>Notas</h1>
      <div class="note-list">
        <div class="note-item" v-for="note in notes" :key="note.id">
          <img
            :src="`/storage/${note.image_path}`"
            alt="Imagen de nota"
            v-if="note.image_path"
            class="note-image"
          />

          <div class="note-content">
            <h2>{{ note.title }}</h2>

            <!-- Cambiar el párrafo por un textarea -->
            <textarea
              v-model="note.description"
              rows="4"
              cols="50"
              readonly
              class="note-description"
            ></textarea>

            <div class="note-meta">
              <p><strong>Usuario:</strong> {{ note.user }}</p>
              <div class="tags">
                <span class="tag" v-for="tag in note.tags.split(',')" :key="tag">{{ tag.trim() }}</span>
              </div>
              <p><strong>Fecha de Vencimiento:</strong> {{ note.due_date }}</p>
            </div>
          </div>

          <div class="note-actions">
            <router-link :to="{ name: 'NoteEdit', params: { id: note.id } }" class="btn-edit">
              <i class="fas fa-pencil-alt"></i>
            </router-link>
            <button class="btn-delete" @click="deleteNote(note.id)">
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
        </div>
      </div>

      <router-link to="/create" class="btn-create-float">
      <i class="fas fa-plus"></i>
    </router-link>
    </div>
  </template>

  <script>
  import axios from 'axios';


  export default {
    data() {
      return {
        notes: [],
        userId: null,
        errorMessage: '', // Mensaje de error
      };
    },
    created() {
      this.getUser(); // Obtener el usuario autenticado al cargar el componente
    },
    methods: {
      async getUser() {
        const token = this.$store.state.token || localStorage.getItem('token');
        if (!token) {
          this.errorMessage = 'No estás autenticado. Por favor, inicia sesión.';
          this.$router.push('/'); // Redirigir al login
          return;
        }

        try {
          const response = await axios.get('http://localhost:8000/api/user', {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.userId = response.data.id;
          this.fetchNotes(); // Llamar a fetchNotes después de obtener el usuario
        } catch (error) {
          console.error('Error al obtener el usuario:', error);
          this.errorMessage = 'Error al obtener el usuario. Por favor, intenta nuevamente.';
        }
      },

      async fetchNotes() {
        const token = this.$store.state.token || localStorage.getItem('token');
        if (!token) {
          alert('No estás autenticado. Por favor, inicia sesión.');
          this.$router.push('/');
          return;
        }

        try {
          const response = await axios.get(`http://localhost:8000/api/notes/${this.userId}`, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.notes = response.data;
        } catch (error) {
          this.handleApiError(error);
        }
      },

      async deleteNote(noteId) {
        const token = localStorage.getItem('token');
        if (confirm('¿Estás seguro de que deseas eliminar esta nota?')) {
          try {
            await axios.delete(`http://localhost:8000/api/notes/${noteId}`, {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            });
            this.fetchNotes(); // Actualizar lista de notas
          } catch (error) {
            console.error('Error al eliminar la nota:', error);
            if (error.response && error.response.status === 401) {
              alert('Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
              this.$router.push('/login');
            }
          }
        }
      },

      handleApiError(error) {
        console.error('API Error:', error);
        this.errorMessage = 'Error al obtener datos de la API. Por favor, intenta nuevamente.';
      },
    },
  };
  </script>

  <style scoped>
  .note-description {
    width: 90%; /* Ajustar el ancho del textarea */
    resize: none; /* Evitar que el textarea se redimensione */
    margin-bottom: 10px; /* Espaciado inferior */
    border: 1px solid #ccc; /* Borde gris */
    padding: 5px; /* Espaciado interno */
  }

  .container {
    display: contents;
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .note-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .note-item {
    display: flex;
    background-color: #f9f9f9;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
  }

  .note-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  }

  .note-image {
    width: 120px;
    height: auto;
    margin-right: 15px;
    border-radius: 15px;
  }

  .note-content {
    flex: 1;
  }

  h2 {
    font-size: 1.6rem;
    color: #333;
    margin-bottom: 10px;
  }

  .note-description {
    font-size: 1rem;
    color: #555;
    margin-bottom: 10px;
    line-height: 1.6;
  }

  .note-meta p {
    font-size: 1rem;
    color: #777;
    margin: 5px 0;
  }

  .tags {
    margin: 10px 0;
  }

  .tag {
    display: inline-block;
    background-color: #e0f7fa;
    color: #00796b;
    padding: 8px 16px;
    margin-right: 8px;
    border-radius: 25px;
    font-size: 1rem;
    transition: background-color 0.3s;
  }

  .tag:hover {
    background-color: #b2ebf2;
  }

  .note-actions {
    display: flex;
    justify-content: space-between;
    align-items: center; /* Centrar verticalmente */
    margin-top: 15px;
  }

  .btn-edit,
  .btn-delete,
  .btn-toggle {
    padding: 12px 20px;
    border-radius: 25px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    font-size: 1rem;
    border: none; /* Elimina bordes */
    outline: none; /* Elimina líneas de enfoque */
    display: flex;              /* Usar flexbox */
    align-items: center;         /* Centrar verticalmente */
  }

  .btn-edit {
    background-color: #007bff;
    color: #fff;
  }

  .btn-edit:hover {
    background-color: #0069d9;
    transform: translateY(-3px);
  }

  .btn-delete {
    background-color: #dc3545;
    color: #fff;
  }

  .btn-delete:hover {
    background-color: #c82333;
    transform: translateY(-3px);
  }

  .btn-toggle {
    background-color: #6c757d;
    color: white;
    margin-top: 5px;
  }

  .btn-toggle:hover {
    background-color: #5a6268;
    transform: translateY(-3px);
  }


.btn-create-float {
  position: fixed; /* Mantener el botón en la parte inferior derecha */
  bottom: 20px; /* Espaciado desde el fondo */
  right: 20px; /* Espaciado desde la derecha */
  background-color: #28a745; /* Color de fondo verde */
  color: white; /* Color del ícono */
  border: none; /* Sin borde */
  border-radius: 50%; /* Forma circular */
  width: 60px; /* Ancho del botón */
  height: 60px; /* Alto del botón */
  display: flex; /* Flexbox para centrar el ícono */
  align-items: center; /* Alinear verticalmente */
  justify-content: center; /* Alinear horizontalmente */
  font-size: 24px; /* Tamaño del ícono */
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Sombra */
}

.btn-create-float:hover {
  background-color: #218838; /* Color más oscuro al pasar el mouse */
}
  </style>

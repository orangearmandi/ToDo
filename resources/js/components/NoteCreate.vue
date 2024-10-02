<template>
    <div class="container mt-5">
      <h1 class="mb-4">Crear Nota</h1>
      <form @submit.prevent="createNote" class="bg-light p-4 rounded shadow">
        <div class="form-group mb-3">
          <label for="title">Título</label>
          <input v-model="note.title" type="text" class="form-control" id="title" placeholder="Título" required />
        </div>

        <div class="form-group mb-3">
          <label for="description">Descripción</label>
          <textarea v-model="note.description" class="form-control" id="description" placeholder="Descripción" required></textarea>
        </div>

        <div class="form-group mb-3">
          <label for="user">Usuario</label>
          <input v-model="note.user" type="text" class="form-control" id="user" placeholder="Usuario" required readonly />
        </div>

        <div class="form-group mb-3">
          <label for="tags">Etiquetas (separadas por comas)</label>
          <input v-model="note.tags" type="text" class="form-control" id="tags" placeholder="Etiquetas" required />
        </div>

        <div class="form-group mb-3">
          <label for="due_date">Fecha de Vencimiento</label>
          <input v-model="note.due_date" type="date" class="form-control" id="due_date" required />
        </div>

        <div class="form-group mb-3">
          <label for="image">Cargar Imagen</label>
          <input type="file" class="form-control" id="image" @change="onFileChange" />
        </div>

        <button type="submit" class="btn btn-primary">Crear Nota</button>
        <div v-if="errorMessage" class="alert alert-danger mt-3">{{ errorMessage }}</div> <!-- Mensaje de error -->
      </form>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        note: {
          title: '',
          description: '',
          user: '',
          tags: '',
          due_date: '',
          image: null,
        },
        errorMessage: '', // Para manejar mensajes de error
      };
    },
    created() {
      this.getUser(); // Obtener el usuario autenticado al cargar el componente
    },
    methods: {
      // Obtener el usuario autenticado
      async getUser() {
        const token = localStorage.getItem('token');

        if (!token) {
          this.errorMessage = 'No estás autenticado. Por favor, inicia sesión.' ,$token; // Mensaje si no hay token
          this.$router.push('/'); // Redirigir al login
          return;
        }

        try {
          const response = await axios.get('http://localhost:8000/api/user', {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.note.user = response.data.id; // Asignar el ID del usuario al campo user
        } catch (error) {
          console.error('Error fetching user:', error);
          this.errorMessage = 'Error al obtener el usuario. Por favor, intenta nuevamente.'; // Mensaje de error
        }
      },

      onFileChange(event) {
        const file = event.target.files[0];
        this.note.image = file; // Guardamos el archivo
      },

      // Crear la nota
      async createNote() {
        const token = localStorage.getItem('token');
        if (!token) {
          this.errorMessage = 'No estás autenticado. Por favor, inicia sesión.'; // Mensaje si no hay token
          this.$router.push('/'); // Redirigir al login
          return;
        }

        const formData = new FormData();
        for (const key in this.note) {
          formData.append(key, this.note[key]);
        }

        try {
          await axios.post('http://localhost:8000/api/notes', formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
              Authorization: `Bearer ${token}`,
            },
          });
          this.$router.push('/'); // Redirigir a la lista de notas después de crear
        } catch (error) {
          console.error('Error creating note:', error);
          this.errorMessage = 'Error al crear la nota. Por favor, intenta nuevamente.'; // Mensaje de error
        }
      },
    },
  };
  </script>

  <style scoped>
  .container {
    max-width: 600px;
  }

  .shadow {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  </style>
  <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
  />

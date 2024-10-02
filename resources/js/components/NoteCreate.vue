<template>
    <SidebarMenu />
    <div class="container">
      <h1 class="page-title">Crear Nota</h1>
      <button @click="goToNotes" class="btn btn-secondary back-button">Volver a Notas</button>
      <form @submit.prevent="createNote" class="note-form">
        <div class="form-group">
          <label for="title">Título</label>
          <input v-model="note.title" type="text" class="form-control" id="title" placeholder="Introduce el título" required />
        </div>

        <div class="form-group">
          <label for="description">Descripción</label>
          <textarea v-model="note.description" class="form-control" id="description" placeholder="Escribe la descripción" required></textarea>
        </div>

        <div class="form-group">
          <label for="user">Usuario</label>
          <input v-model="note.user" type="text" class="form-control" id="user" placeholder="Usuario" required readonly />
        </div>

        <div class="form-group">
          <label for="tags">Etiquetas (separadas por comas)</label>
          <input v-model="note.tags" type="text" class="form-control" id="tags" placeholder="Introduce etiquetas" required />
        </div>

        <div class="form-group">
          <label for="due_date">Fecha de Vencimiento</label>
          <input v-model="note.due_date" type="date" class="form-control" id="due_date" required />
        </div>

        <div class="form-group">
          <label for="image">Cargar Imagen</label>
          <input type="file" class="form-control" id="image" @change="onFileChange" />
        </div>

        <button type="submit" class="btn btn-primary create-button">Crear Nota</button>
        <div v-if="errorMessage" class="alert alert-danger mt-3">{{ errorMessage }}</div>
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
        errorMessage: '',
      };
    },
    created() {
      this.getUser();
    },
    methods: {
      goToNotes() {
        this.$router.push('/notes');
      },

      async getUser() {
        const token = localStorage.getItem('token');
        if (!token) {
          this.errorMessage = 'No estás autenticado. Por favor, inicia sesión.';
          this.$router.push('/');
          return;
        }

        try {
          const response = await axios.get('http://localhost:8000/api/user', {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          this.note.user = response.data.id;
        } catch (error) {
          console.error('Error fetching user:', error);
          this.errorMessage = 'Error al obtener el usuario. Por favor, intenta nuevamente.';
        }
      },

      onFileChange(event) {
        const file = event.target.files[0];
        this.note.image = file;
      },

      async createNote() {
        const token = localStorage.getItem('token');
        if (!token) {
          this.errorMessage = 'No estás autenticado. Por favor, inicia sesión.';
          this.$router.push('/notes');
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
          this.$router.push('/notes');
        } catch (error) {
          console.error('Error creating note:', error);
          this.errorMessage = 'Error al crear la nota. Por favor, intenta nuevamente.';
        }
      },
    },
  };
  </script>

  <style scoped>
  .container {
    max-width: 600px; /* Ajustar el ancho máximo */
    margin: 50px auto; /* Centrar el contenedor */
    padding: 20px; /* Espaciado interno */
    border-radius: 8px; /* Bordes redondeados */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Sombra para el contenedor */
    background-color: #ffffff; /* Fondo blanco */
  }

  .page-title {
    text-align: center; /* Centrar el título */
    margin-bottom: 20px; /* Espaciado inferior */
    color: #333; /* Color del texto */
    font-size: 2rem; /* Tamaño del texto */
  }

  .back-button {
    display: block; /* Hacer que el botón ocupe todo el ancho */
    margin-bottom: 20px; /* Espaciado inferior */
  }

  .note-form {
    display: flex; /* Usar flexbox para el formulario */
    flex-direction: column; /* Apilar los elementos */
  }

  .form-group {
    margin-bottom: 15px; /* Espaciado inferior entre grupos de formulario */
  }

  .form-control {
    padding: 12px; /* Espaciado interno en los campos */
    border: 1px solid #ccc; /* Borde gris claro */
    border-radius: 5px; /* Bordes redondeados */
    transition: border-color 0.3s; /* Transición para el borde */
  }

  .form-control:focus {
    border-color: #007bff; /* Color del borde al enfocar */
    outline: none; /* Sin borde por defecto */
  }

  .create-button {
    padding: 12px; /* Espaciado interno en el botón */
    background-color: #007bff; /* Color de fondo azul */
    color: white; /* Color del texto */
    border: none; /* Sin borde */
    border-radius: 5px; /* Bordes redondeados */
    cursor: pointer; /* Cambiar cursor al pasar por encima */
    font-size: 16px; /* Tamaño del texto */
    transition: background-color 0.3s; /* Transición para el color de fondo */
  }

  .create-button:hover {
    background-color: #0056b3; /* Color al pasar el mouse */
  }

  .alert {
    margin-top: 15px; /* Espaciado superior en la alerta */
  }
  </style>
